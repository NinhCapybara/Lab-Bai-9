# Lab Bài 9 — FeedbackHub

Đề bài cho một web quản lý phản hồi khách hàng viết bằng PHP thuần + MySQL, triển khai
bằng Docker. Điểm đáng chú ý là trước app có đặt một lớp **WAF ModSecurity (OWASP CRS)**
nên muốn khai thác được lỗi thì phải vượt qua WAF trước đã.

Code này cố tình để vulnerable để làm lab, **đừng đem deploy ra ngoài**.

## Chạy thế nào

Cần Docker và Docker Compose. Từ thư mục `Feedback App`:

```bash
docker compose up -d --build
```

Rồi mở http://localhost:8080. Port 8080 là port của WAF, mọi request đều đi qua nó trước
khi tới nginx và PHP. Muốn xem WAF chặn được gì thì `docker compose logs -f waf`.

Nếu muốn đổi user/password của database thì tạo file `.env` rồi định nghĩa
`DB_USER`, `DB_PASS`, `MYSQL_ROOT_PASSWORD`. Không có `.env` thì nó dùng giá trị mặc
định trong `docker-compose.yml`.

Dừng lại thì `docker compose down`, thêm `-v` nếu muốn xóa luôn dữ liệu MySQL.

## Tài khoản đăng nhập

Mật khẩu trùng với username luôn:

- `admin / admin` — tài khoản quản trị
- `bob / bob`, `mia / mia`, `eve / eve`, ... — khoảng 40 user thường, danh sách đầy đủ
  trong `db/init.sql`

## Kiến trúc

4 container nối với nhau qua một network riêng:

```
waf  (owasp/modsecurity-crs, :8080)  ->  web (nginx 1.18)
                                        ->  php (php:7.4-fpm + mysqli)
                                        ->  db  (mysql:5.6)
```

- **waf**: ModSecurity + OWASP CRS, Paranoia Level 1, forward về `web:80`
- **web**: nginx, chỉ expose port 80 trong network, document root trỏ tới
  `src/public`, PHP chuyển qua FastCGI cho container `php`
- **php**: build từ `php/Dockerfile`. Vì `php:7.4` đã EOL nên image phải đổi apt mirror
  sang `archive.debian.org` thì mới build được, ai build lỗi 404 thì kiểm tra lại đoạn
  này trong Dockerfile
- **db**: MySQL 5.6, tự chạy `db/init.sql` lần đầu để tạo bảng và nạp dữ liệu mẫu

Lần đầu khởi động MySQL hơi chậm nên `db.php` có retry lại 1 lần sau 2 giây nếu kết nối
hỏng, tránh app chết ngay khi container chưa ready.

## Cấu trúc thư mục

```
Feedback App/
├── docker-compose.yml
├── db/
│   └── init.sql            # schema + dữ liệu mẫu
├── nginx/
│   └── default.conf
├── php/
│   └── Dockerfile
└── src/
    ├── includes/
    │   ├── db.php            # kết nối mysqli
    │   └── auth.php          # session, require_login()
    └── public/
        ├── login.php
        ├── dashboard.php     # trang chính
        ├── feedback_add.php / feedback_edit.php / feedback_delete.php
        ├── attachment.php    # đọc tài liệu đính kèm
        ├── diagnostic.php    # công cụ ping
        └── assets/style.css
```

## Các lỗ hổng trong lab (spoiler)

Đọc tới đây là mất vui, thử tự mò trước nhé.

1. **SQL Injection ở login** — `login.php` nối thẳng username/password vào câu query,
   và khi query lỗi thì hiện message lỗi MySQL ra trang. Đây là hướng error-based,
   phải chú ý vì WAF sẽ chặn pattern phổ biến.
2. **Stored XSS** — nội dung phản hồi ở `dashboard.php` được `echo` thẳng ra mà không
   qua `htmlspecialchars` (trong khi title thì có). Gửi một feedback chứa payload rồi
   chờ nạn nhân mở dashboard.
3. **Ăn cắp cookie admin** — khi admin đăng nhập, `login.php` set cookie `token` chứa
   flag nhưng quên bật `HttpOnly`, nên đọc được bằng `document.cookie`. Kết hợp với lỗi
   XSS ở trên là ra flag.
4. **Path traversal** — `attachment.php` nối `$_GET['doc']` vào đường dẫn không kiểm
   tra gì, `../../` là đọc được file ngoài thư mục `files/`.
5. **Command injection** — `diagnostic.php` chạy `ping -c 1` với host lấy thẳng từ GET,
   chèn `;` hoặc `|` là thực thi được lệnh khác.

Cái khó của lab này không nằm ở lỗi (lỗi khá sơ đẳng) mà ở chỗ CRS mức PL1 chặn khá
nhiều payload mẫu, nên phải mã hóa URL hoặc viết payload lách rule mới qua được WAF.

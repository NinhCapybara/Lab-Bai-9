DROP DATABASE IF EXISTS feedback;
CREATE DATABASE feedback CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE feedback;
SET NAMES utf8mb4;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(128) NOT NULL,
    nickname VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE secret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag VARCHAR(255) NOT NULL
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
) DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO secret(flag) VALUES
('flag{sql_1nj3ci1on_3rr0r_b4s3d_byp4ss_228b7133b1416d7a3e4fd0a0c74e6c4b9d99213813415b80291d78ea43b00c8a591360ed3a79db81317f3cc07e541bd1a120f0043b934efc2467752d2f039f01}');

INSERT INTO users(username,password,nickname,role) VALUES
('admin',SHA2('admin',512),'Administrator','admin'),
('bob',SHA2('bob',512),'Bob','user'),
('mia',SHA2('mia',512),'Mia','user'),
('eve',SHA2('eve',512),'Eve','user'),
('john',SHA2('john',512),'John','user'),
('mark',SHA2('mark',512),'Mark','user'),
('eric',SHA2('eric',512),'Eric','user'),
('ryan',SHA2('ryan',512),'Ryan','user'),
('adam',SHA2('adam',512),'Adam','user'),
('luke',SHA2('luke',512),'Luke','user'),
('kate',SHA2('kate',512),'Kate','user'),
('anna',SHA2('anna',512),'Anna','user'),
('jane',SHA2('jane',512),'Jane','user'),
('rose',SHA2('rose',512),'Rose','user'),
('lily',SHA2('lily',512),'Lily','user'),
('alice',SHA2('alice',512),'Alice','user'),
('kelly',SHA2('kelly',512),'Kelly','user'),
('frank',SHA2('frank',512),'Frank','user'),
('david',SHA2('david',512),'David','user'),
('maxim',SHA2('maxim',512),'Maxim','user'),
('chloe',SHA2('chloe',512),'Chloe','user'),
('brian',SHA2('brian',512),'Brian','user'),
('kevin',SHA2('kevin',512),'Kevin','user'),
('dylan',SHA2('dylan',512),'Dylan','user'),
('oscar',SHA2('oscar',512),'Oscar','user'),
('grace',SHA2('grace',512),'Grace','user'),
('hazel',SHA2('hazel',512),'Hazel','user'),
('sarah',SHA2('sarah',512),'Sarah','user'),
('henry',SHA2('henry',512),'Henry','user'),
('simon',SHA2('simon',512),'Simon','user'),
('logan',SHA2('logan',512),'Logan','user'),
('mason',SHA2('mason',512),'Mason','user'),
('lucas',SHA2('lucas',512),'Lucas','user'),
('clark',SHA2('clark',512),'Clark','user'),
('naomi',SHA2('naomi',512),'Naomi','user'),
('elena',SHA2('elena',512),'Elena','user'),
('fiona',SHA2('fiona',512),'Fiona','user'),
('claire',SHA2('claire',512),'Claire','user'),
('stella',SHA2('stella',512),'Stella','user'),
('oliver',SHA2('oliver',512),'Oliver','user');

INSERT INTO feedbacks(user_id,title,content) VALUES
(1,'Website rất tuyệt vời','Giao diện đẹp mắt, các chức năng được bố trí hợp lý và rất dễ sử dụng.'),
(2,'Trải nghiệm rất tốt','Tôi rất hài lòng với trải nghiệm sử dụng website, mọi thao tác đều đơn giản và thuận tiện.'),
(3,'Thiết kế hiện đại','Website có thiết kế hiện đại, màu sắc hài hòa và cách trình bày nội dung rất chuyên nghiệp.'),
(4,'Tốc độ tải nhanh','Các trang tải nhanh chóng, giúp tôi tiết kiệm thời gian khi sử dụng.'),
(5,'Dễ dàng sử dụng','Ngay từ lần đầu truy cập, tôi đã có thể sử dụng các chức năng mà không gặp khó khăn.'),
(6,'Giao diện thân thiện','Giao diện thân thiện với người dùng, các nút chức năng được đặt ở vị trí dễ tìm.'),
(7,'Chức năng hoạt động tốt','Các chức năng chính hoạt động ổn định và đáp ứng tốt nhu cầu sử dụng của tôi.'),
(8,'Rất đáng để trải nghiệm','Đây là một website hữu ích với cách sử dụng đơn giản và hiệu quả.'),
(9,'Bố cục rõ ràng','Các danh mục được sắp xếp khoa học, giúp tôi dễ dàng tìm thấy thông tin cần thiết.'),
(10,'Ấn tượng ngay lần đầu','Tôi có ấn tượng tốt ngay từ lần đầu truy cập nhờ giao diện đẹp và trực quan.'),
(11,'Phản hồi thuận tiện','Chức năng gửi phản hồi rất tiện lợi, biểu mẫu đơn giản và dễ hoàn thành.'),
(12,'Hoạt động ổn định','Tôi đã sử dụng website nhiều lần và nhìn chung hệ thống hoạt động rất ổn định.'),
(13,'Nội dung dễ theo dõi','Cách trình bày nội dung rõ ràng, dễ đọc và không gây cảm giác rối mắt.'),
(14,'Thiết kế chuyên nghiệp','Website được thiết kế chỉn chu, tạo cảm giác chuyên nghiệp và đáng tin cậy.'),
(15,'Trải nghiệm mượt mà','Quá trình chuyển đổi giữa các trang diễn ra nhanh chóng và mượt mà.'),
(16,'Rất hữu ích','Website cung cấp các chức năng thiết thực, hỗ trợ người dùng thực hiện công việc thuận tiện hơn.'),
(17,'Màu sắc hài hòa','Tôi thích cách phối màu của website vì tạo cảm giác dễ chịu khi sử dụng trong thời gian dài.'),
(18,'Dễ dàng tìm thông tin','Thông tin được tổ chức hợp lý nên tôi có thể tìm được nội dung mình cần rất nhanh.'),
(19,'Chất lượng tốt','Website có chất lượng tốt, giao diện đẹp và các chức năng được triển khai hợp lý.'),
(20,'Rất hài lòng','Tôi hoàn toàn hài lòng với website và chưa gặp vấn đề đáng kể trong quá trình sử dụng.'),
(21,'Tương thích tốt','Website hiển thị đẹp trên máy tính và mang lại trải nghiệm sử dụng rất thuận tiện.'),
(22,'Biểu mẫu đơn giản','Biểu mẫu được thiết kế gọn gàng, giúp việc nhập thông tin và gửi phản hồi trở nên dễ dàng.'),
(23,'Cách trình bày đẹp','Font chữ dễ đọc, khoảng cách hợp lý và bố cục tổng thể rất cân đối.'),
(24,'Thao tác nhanh chóng','Các thao tác trên website được thực hiện nhanh, không cần qua quá nhiều bước.'),
(25,'Giao diện trực quan','Các thành phần giao diện có ý nghĩa rõ ràng, giúp người dùng dễ dàng làm quen.'),
(26,'Một website hữu ích','Tôi đánh giá cao tính hữu ích của website và hy vọng sẽ tiếp tục sử dụng trong thời gian tới.'),
(27,'Dễ tiếp cận','Website phù hợp với cả những người ít kinh nghiệm sử dụng các hệ thống trực tuyến.'),
(28,'Trình bày khoa học','Các thành phần được bố trí logic, tạo cảm giác gọn gàng và thuận tiện khi thao tác.'),
(29,'Ấn tượng tốt','Tổng thể website mang lại ấn tượng tốt nhờ thiết kế đẹp và cách sử dụng đơn giản.'),
(30,'Hiệu suất tốt','Hệ thống phản hồi nhanh với các thao tác thông thường và mang lại trải nghiệm ổn định.'),
(31,'Quản lý dễ dàng','Các chức năng quản lý được bố trí hợp lý, giúp người dùng theo dõi thông tin thuận tiện.'),
(32,'Thiết kế tinh tế','Tôi thích phong cách thiết kế đơn giản nhưng hiện đại, không có quá nhiều chi tiết thừa.'),
(33,'Trải nghiệm thân thiện','Website có cách tương tác tự nhiên, các thông báo dễ hiểu và thao tác rất thuận tiện.'),
(34,'Đáp ứng tốt nhu cầu','Những chức năng hiện có đáp ứng tốt nhu cầu cơ bản của tôi trong quá trình sử dụng.'),
(35,'Giao diện dễ nhìn','Các tiêu đề và nội dung được phân cấp rõ ràng, giúp việc đọc thông tin trở nên thoải mái.'),
(36,'Rất tiện lợi','Tôi có thể hoàn thành công việc nhanh chóng mà không cần thực hiện nhiều thao tác phức tạp.'),
(37,'Chất lượng vượt mong đợi','Website có giao diện đẹp và trải nghiệm sử dụng tốt hơn mong đợi của tôi.'),
(38,'Hệ thống đáng tin cậy','Tôi đánh giá cao sự ổn định của hệ thống và cách tổ chức các chức năng.'),
(39,'Nên tiếp tục phát triển','Đây là một sản phẩm có tiềm năng tốt. Tôi mong website sẽ tiếp tục được phát triển với nhiều tính năng hữu ích.'),
(40,'Đánh giá năm sao','Một website đẹp, dễ sử dụng và hữu ích. Tôi rất hài lòng và đánh giá trải nghiệm tổng thể ở mức xuất sắc.');
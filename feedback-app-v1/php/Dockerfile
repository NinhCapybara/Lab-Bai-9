# Stage 1: Download Loophole CLI
FROM alpine:3.22 AS loophole-builder

ARG LOOPHOLE_VERSION=1.0.0-beta.15
ARG PLATFORM=linux_64bit

RUN apk add --no-cache curl tar \
    && curl -fLsS "https://github.com/loophole/cli/releases/download/${LOOPHOLE_VERSION}/loophole-cli_${LOOPHOLE_VERSION}_${PLATFORM}.tar.gz" \
       -o /tmp/loophole.tar.gz && tar -xzf /tmp/loophole.tar.gz -C /tmp && install -m 0755 \
       "/tmp/loophole-cli_${LOOPHOLE_VERSION}_${PLATFORM}/loophole" \
       /usr/local/bin/loophole && rm -rf /tmp/*

FROM php:7.3.10-fpm

RUN docker-php-ext-install mysqli

WORKDIR /var/www/html

COPY --from=loophole-builder /usr/local/bin/loophole /usr/local/bin/loophole

CMD ["php-fpm"]
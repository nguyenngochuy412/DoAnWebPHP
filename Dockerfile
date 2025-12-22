# Sử dụng image PHP kết hợp Nginx cực nhẹ và chuẩn cho Laravel
FROM richarvey/nginx-php-fpm:latest

# Copy toàn bộ code vào trong server ảo
COPY . /var/www/html

# Cấu hình để server chạy vào thư mục public của Laravel
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Chạy lệnh cài đặt thư viện PHP (giống như bạn chạy ở máy)
RUN composer install --no-dev --optimize-autoloader

# Cấp quyền cho thư mục log và cache để không bị lỗi 500
RUN chown -R webuser:webuser /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
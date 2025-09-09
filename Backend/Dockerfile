# Sử dụng PHP 8.2 + Composer + extensions
FROM php:8.2-cli

# Cài các extension cần thiết
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Cài Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc
WORKDIR /app

# Copy toàn bộ code vào container
COPY . .

# Cài Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Tạo SQLite database nếu chưa có
RUN mkdir -p database && touch database/database.sqlite

# Cache config và routes
RUN php artisan config:cache && php artisan route:cache

# Expose port 10000 (Render yêu cầu)
EXPOSE 10000

# Start Laravel server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]

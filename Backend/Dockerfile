# PHP base image
FROM php:8.2-cli

# Cài các package hệ thống và PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libsqlite3-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite gd zip

# Cài Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Đặt thư mục làm việc
WORKDIR /app

# Copy toàn bộ code
COPY . .

# Cài Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Tạo SQLite database nếu chưa có
RUN mkdir -p database && touch database/database.sqlite

# Cache config và route
RUN php artisan config:cache && php artisan route:cache

# Luôn đảm bảo có thư mục + file SQLite
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite

# Expose port cho Render
EXPOSE 10000

# Start Laravel server
CMD ["/bin/sh", "-c", "touch /var/www/html/database/database.sqlite && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=10000"]


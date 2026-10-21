FROM php:8.2-apache

# Install dependencies, ekstensi SQLite, dan tool yang dibutuhkan Composer
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_sqlite

# Copy Composer dari image resmi Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Ubah Document Root Apache langsung ke folder /public milik CI4
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# Set working directory
WORKDIR /var/www/html

# Copy semua file proyek ke dalam container
COPY . .

# Jalankan composer install untuk mengunduh folder vendor/
RUN composer install --no-dev --optimize-autoloader

# Set permission folder writable agar SQLite dan cache bisa ditulis
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80

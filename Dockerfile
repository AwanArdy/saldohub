FROM php:8.2-apache

# 1. Install system dependencies & ekstensi PHP yang dibutuhkan CI4 + SQLite
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_sqlite intl

# 2. Copy Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Setting environment agar Composer tidak dibatasi memori
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# 4. Enable Apache mod_rewrite & set document root
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# 5. Copy file proyek
COPY . .

# 6. Jalankan composer install tanpa autoloader berat jika RAM terbatas
RUN composer install --no-dev --no-scripts

# 7. Set permission folder writable
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80

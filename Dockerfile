FROM php:8.2-apache

# Install dependencies & ekstensi SQLite
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Ubah Document Root Apache langsung ke folder /public milik CI4
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# Copy semua file projek ke dalam container
COPY . /var/www/html

# Set permission folder writable agar SQLite bisa nulis data
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80

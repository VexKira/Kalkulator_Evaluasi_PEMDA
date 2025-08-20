# Gunakan image resmi PHP + Apache
FROM php:8.2-apache

# Copy semua file project ke folder default Apache
COPY . /var/www/html/

# Install ekstensi MySQL yang dibutuhkan
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html/

# Expose port 80 agar bisa diakses Railway
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
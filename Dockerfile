FROM php:8.2-apache

# Copy project ke Apache
COPY . /var/www/html/

# Install MySQL extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Tambahkan ServerName agar warning hilang
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html/
EXPOSE 80
CMD ["apache2-foreground"]
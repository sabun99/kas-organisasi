FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y nginx libpq-dev

# Copy aplikasi
COPY . /var/www/html

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader

# Setup permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080
CMD ["sh", "-c", "service nginx start && php-fpm"]
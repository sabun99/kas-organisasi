FROM php:8.2-fpm

# 1. Install dependencies (ditambah libpng dll untuk Laravel)
RUN apt-get update && apt-get install -y nginx libpq-dev libpng-dev libzip-dev zip unzip

# 2. Copy aplikasi
COPY . /var/www/html

# 3. COPY KONFIGURASI NGINX (Penting!)
COPY nginx.conf /etc/nginx/sites-available/default

# 4. Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN cd /var/www/html && composer install --no-dev --optimize-autoloader

# 5. Setup permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

# 6. Jalankan Nginx di foreground agar container tidak mati
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
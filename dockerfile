#Use official PHP with Apache
FROM php:8.2-apache

#install required extensions for laravel
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev zip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

#Enable apache mod_rewrite (needed for laravel)
RUN a2enmod rewrite

#Set apache DocumentRoot to public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's!/var/www/!/var/www/html/public/!g' /etc/apache2/apache2.conf

#Copy app code
COPY . /var/www/html

#create uploads directory and set permissions
RUN mkdir -p /var/www/html/storage/app/public/uploads \
    && chown -R www-data:www-data /var/www/html/storage/app/public/uploads \
    && chmod -R 775 /var/www/html/storage/app/public/uploads

#set working dir
WORKDIR /var/www/html

#install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#install laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

#set permissions for storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

#expose render required port
EXPOSE 10000

#Start apache
CMD ["apache2-foreground"]
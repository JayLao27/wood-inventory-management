#Use official PHP with Apache
FROM php:8.2-apache

#install required extensions for laravel
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev zip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

#Install Node.js (needed to build frontend assets)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

#Enable apache mod_rewrite (needed for laravel)
RUN a2enmod rewrite

#Copy app code FIRST
COPY . /var/www/html

#Set apache DocumentRoot to public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

#Add Directory configuration for Laravel
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/sites-available/000-default.conf

#set working dir
WORKDIR /var/www/html

#install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#install laravel dependencies
RUN composer install --no-dev --optimize-autoloader

#Install npm dependencies and BUILD assets
RUN npm install && npm run build

#create uploads directory and set permissions
RUN mkdir -p /var/www/html/storage/app/public/uploads \
    && chown -R www-data:www-data /var/www/html/storage/app/public/uploads \
    && chmod -R 775 /var/www/html/storage/app/public/uploads

#set permissions for storage and bootstrap cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

#expose render required port
EXPOSE 10000

#Start apache
CMD ["apache2-foreground"]
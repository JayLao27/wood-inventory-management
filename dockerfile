#Use official PHP with Apache
FROM php:8.2-apache

#install required extensions for laravel
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev zip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd bcmath

#Enable apache mod_rewrite (needed for laravel)
RUN a2enmod rewrite

#Set apache DocumentRoot to public and create proper virtual host
RUN rm /etc/apache2/sites-enabled/000-default.conf && \
    echo '<VirtualHost *:80>' > /etc/apache2/sites-available/000-default.conf && \
    echo '    ServerAdmin webmaster@localhost' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    ServerName localhost' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    DocumentRoot /var/www/html/public' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Options Indexes FollowSymLinks' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        AllowOverride All' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        Require all granted' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </Directory>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    <FilesMatch \.php$>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '        SetHandler application/x-httpd-php' >> /etc/apache2/sites-available/000-default.conf && \
    echo '    </FilesMatch>' >> /etc/apache2/sites-available/000-default.conf && \
    echo '</VirtualHost>' >> /etc/apache2/sites-available/000-default.conf && \
    a2ensite 000-default && \
    a2enmod php8.2

#set working dir
WORKDIR /var/www/html

#install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#Copy composer files first for better caching
COPY composer.json composer.lock /var/www/html/

#install laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

#Copy app code
COPY . /var/www/html

#Create necessary directories with correct permissions
RUN mkdir -p /var/www/html/storage/app/public/uploads /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

#Start apache and run artisan commands
CMD /bin/bash -c "php artisan config:cache && php artisan route:cache && php artisan view:cache && apache2-foreground"
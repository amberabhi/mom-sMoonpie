FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy Laravel app files
COPY . .

# Install Laravel dependencies
RUN apt-get update && apt-get install -y zip unzip libzip-dev && \
    docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Change Apache DocumentRoot to Laravel's /public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Enable Apache rewrite mod
RUN a2enmod rewrite

# Set permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html/storage

# Environment port (for Render)
ENV PORT=10000
EXPOSE 10000

# Update port in Apache
RUN sed -i "s/80/${PORT}/" /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

CMD ["apache2-foreground"]

FROM php:7.4-apache

# Install required packages
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && a2enmod rewrite \
    && docker-php-ext-install pdo_pgsql zip


# Copy Laravel app files
COPY . /var/www/html

# Set write permissions to used folders
RUN chown -R www-data:www-data /var/www/html /var/www/html/storage /var/www/html/bootstrap/cache

# Change working directory to Laravel app root
WORKDIR /var/www/html

# Install composer and Laravel dependencies with composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs \
    && npm i

# No go line for production
RUN echo "#!/bin/sh\n" \
  "php artisan migrate:fresh --seed --force" > /var/www/html/start.sh

# Expose port 80 for Apache
EXPOSE 80
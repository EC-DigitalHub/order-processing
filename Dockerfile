# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libssl-dev \
    default-mysql-client \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Configure Apache document root to point to public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Copy Laravel files into the container
COPY . .

# Create .env file if it doesn't exist
RUN if [ ! -f .env ]; then cp .env.example .env || echo "APP_NAME=Laravel\nAPP_ENV=production\nAPP_KEY=\nAPP_DEBUG=false\nAPP_URL=http://localhost\nDB_CONNECTION=mysql" > .env; fi

# Install PHP dependencies via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate application key
RUN php artisan key:generate

# Install JS dependencies via npm/yarn
RUN npm install && npm run build

# Set permissions
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Enable Apache modules
RUN a2enmod rewrite headers

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Expose port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

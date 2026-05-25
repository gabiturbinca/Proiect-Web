FROM php:8.3-apache

# System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apache config
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite headers

# App files
WORKDIR /var/www/html
COPY . /var/www/html/

#PHP deps (Dompdf, etc.)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# directory / permissions
RUN mkdir -p /var/www/html/public/uploads/gifts \
    && chown -R www-data:www-data /var/www/html/public/uploads \
    && chmod -R 755 /var/www/html/public/uploads

EXPOSE 80

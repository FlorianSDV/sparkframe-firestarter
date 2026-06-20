# syntax=docker/dockerfile:1
FROM php:8.5.7-apache-bookworm AS base

RUN apt update \
    && apt install zip -y

WORKDIR /var/www/html

# after WORKDIR /var/www/html
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Copy the composer.json and composer.lock files
COPY composer.* .

FROM base as production

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_mysql

# Install the dependencies by allowing Docker to use the auth.json file of the host
# RUN --mount=type=secret,id=composer_auth,dst=/var/www/html/auth.json composer install --no-dev --no-scripts --no-autoloader --no-progress --no-interaction

# Comment out the following line if you are using private composer packages
RUN composer install --no-dev --no-scripts --no-autoloader --no-progress --no-interaction

COPY . .

# Dump the autoloader
RUN composer dump-autoload --no-dev

FROM base as dev

# openssh-client is needed to use git to push to GitHub
RUN apt install openssh-client -y

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions xdebug pdo_mysql

# Install the dependencies by allowing Docker to use the auth.json file of the host
# RUN --mount=type=secret,id=composer_auth,dst=/var/www/html/auth.json composer install --no-scripts --no-autoloader --no-progress --no-interaction

# Comment out the following line if you are using private composer packages
RUN composer install --no-scripts --no-autoloader --no-progress --no-interaction

COPY . .

# Dump the autoloader
RUN composer dump-autoload

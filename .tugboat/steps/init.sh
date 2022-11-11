#!/bin/bash

set -eux
echo "Initializing..."

# Install mysql or mariadb client.
apt-get update
apt-get install -y mysql-client

# Link the document root to the expected path. Tugboat uses /docroot
# by default. So, if Drupal is located at any other path in your git
# repository, change that here. This example links /web to the docroot
ln -snf "${TUGBOAT_ROOT}/web" "${DOCROOT}"

# Enable mod_rewrite so clean URLs work.
a2enmod headers rewrite

# Install the PHP opcache as it's not included by default and needed for
# decent performance.
docker-php-ext-install opcache

# GD dependencies.
apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev

# WebP dependencies.
apt-get install -y libwebp-dev libwebp6 webp libmagickwand-dev

# Build and install gd.
docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
docker-php-ext-install gd

# Install ImageMagick. This is recommended by both Acquia and Pantheon instead
# of GD. Lullabot will likely be publishing an ADR recommending it too.
apt-get install -y imagemagick

# Install the PHP memcache extension. The Drupal Redis module recommends
# phpredis so no PHP extension is required.
docker-php-ext-install memcache

# Install drush-launcher
wget -O /usr/local/bin/drush https://github.com/drush-ops/drush-launcher/releases/download/0.10.1/drush.phar
chmod +x /usr/local/bin/drush

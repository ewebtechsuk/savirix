#!/usr/bin/env bash
# Force Hostinger CLI to use PHP 8.3 for Composer + Laravel
PHP_BIN=${PHP_BIN:-/opt/alt/php83/usr/bin/php}
set -e

cd /home/u753768407/domains/savarix.com/laravel_app

# Ensure composer.phar is available
if [ ! -f composer.phar ]; then
  $PHP_BIN -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
  $PHP_BIN composer-setup.php --quiet
  rm composer-setup.php
fi

# Install/update dependencies
$PHP_BIN composer.phar install --no-dev --optimize-autoloader

# OPTIONAL: run DB migrations on production (uncomment when comfortable)
# $PHP_BIN artisan migrate --force

# Clear caches
$PHP_BIN artisan config:clear
$PHP_BIN artisan route:clear
$PHP_BIN artisan view:clear

# Rebuild caches
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

# Sanity check admin login route & URL
$PHP_BIN artisan savarix:check-admin-login

#!/usr/bin/env bash
# exit on error
set -o errexit

# 1. Instal dependensi PHP
composer install --optimize-autoloader --no-dev

# 2. Instal dependensi frontend & build aset
npm install
npm run build

# 3. Jalankan perintah optimasi & migrasi Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
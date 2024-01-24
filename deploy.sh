#!/bin/sh
set -e

echo "🚚 Deploying application"

echo "⬇️ Laravel down"

(php artisan down) || true

    echo "⬇️ Updating base code: main branch"
    
    git fetch origin main
    git reset --hard origin/main

    echo "🧹 Cleaning up node modules"

    if [ -d "node_modules" ]; then
        rm -r node_modules
    fi

    if [ -f "package-lock.json" ]; then
        rm package-lock.json
    fi

    echo "🔧 Copying .env file"
    cp /var/www/.env.fitme /var/www/fitme/.env

    echo "📦 Installing composer dependencies"
    
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

    echo "🗃️ Running migrations"

    php artisan migrate

    echo "🌱 Seeding database"

    php artisan migrate:refresh --seed

    echo "🔄 Restarting queue"
    
    php artisan queue:restart

    echo "🧹 Recreating cache"
    
    php artisan optimize

    echo "📦 Installing Npm dependencies"
    
    npm install

    npm ci

    echo "🏗️ Compiling assets"
    
    npm run build

    echo "🔐 Applying permissions"
    
    sudo chmod -R 775 /var/www/fitme
    sudo chown -R www-data:www-data /var/www/fitme
    sudo chgrp -R www-data /var/www/fitme/storage /var/www/fitme/bootstrap/cache
    sudo chmod -R ug+rwx /var/www/fitme/storage /var/www/fitme/bootstrap/cache

    echo "🔄 Restarting Apache Service"
    
    echo "" | sudo systemctl restart apache2.service
    
echo "⬆️ Rising Laravel"

php artisan up

echo "🎉 Deployed application"
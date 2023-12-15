#!/bin/sh
#!/opt/plesk/php/7.4/bin/php
set -e

echo "Deploying application ..."

# Enter maintenance mode
(/opt/plesk/php/7.4/bin/php artisan down) || true

/opt/plesk/php/7.4/bin/php -d memory_limit=-1 composer.phar install --no-interaction --no-dev --prefer-dist
/opt/plesk/php/7.4/bin/php artisan migrate --force
yarn install
yarn prod
/opt/plesk/php/7.4/bin/php artisan cache:clear
/opt/plesk/php/7.4/bin/php artisan config:clear
/opt/plesk/php/7.4/bin/php artisan route:clear
/opt/plesk/php/7.4/bin/php artisan view:clear

# Exit maintenance mode
/opt/plesk/php/7.4/bin/php artisan up

echo "Application deployed!"

exit 0

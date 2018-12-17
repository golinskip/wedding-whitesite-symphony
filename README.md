# How to install:
    cp .env .env.dist
    vim .env.dist (and set variables)
    composer install
    bin/console doctrine:schema:update --foce
    bin/console doctrine:fixtures:load
    bin/console assets:install --symlink
    npm install
    grunt

# Requirements:
    php_zip enabled
    php_xml enabled
    php_gd2 enabled (if not compiled in)
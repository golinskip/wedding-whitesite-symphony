# How to install:
    cp .env .env.local
    vim .env.local (and set variables)
    composer install
    cp -rf project_dist project

(or copy project file to directory)

    bin/console doctrine:schema:update --force
    bin/console doctrine:fixtures:load
    bin/console ckeditor:install
    bin/console assets:install
    npm install --no-audit
    grunt


# Requirements:
* PHP 7.1.0
* MySQL 5.0
* php_zip enabled
* php_xml enabled
* php_gd2 enabled (if not compiled in)
* npm
* grunt-cli
* sass
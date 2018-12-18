# How to install:
    cp .env .env.dist
    vim .env.dist (and set variables)
    composer install
    cp -rf project_dist project
(or copy project file to directory)
    bin/console doctrine:schema:update --focre
    bin/console doctrine:fixtures:load
    bin/console ckeditor:install
    bin/console assets:install
    npm install
    grunt

# Requirements:
    php_zip enabled
    php_xml enabled
    php_gd2 enabled (if not compiled in)
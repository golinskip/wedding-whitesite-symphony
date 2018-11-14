How to install:

== PHP/Symfony application install ==
* cp .env .env.dist
* vim .env.dist (and set variables)
* composer install
* bin/console doctrine:schema:create
* bin/console fos:user:create

== Javascript dependences ==
* npm install
* grunt
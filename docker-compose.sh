#!/bin/bash

# lists Symfony commands
# docker compose run --rm php bin/console
# docker compose run --rm php bin/console doctrine:migrations:migrate
docker compose down
docker compose up -d --build
# docker compose run -it --rm -v "$(pwd):/var/www/app" php gosu www-data composer install
# docker compose run -u 0 -it --rm php gosu www-data composer install
docker compose run -it --rm php gosu www-data composer install

# docker compose run -it --rm -v "$(pwd):/var/www/app" php gosu www-data vendor/bin/phpspec run -fdot
# docker compose run -it --rm php gosu www-data vendor/bin/phpspec run -fdot
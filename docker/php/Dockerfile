FROM fsilva/php:8.3-apache

RUN apt-install libpq-dev libcurl4-openssl-dev pkg-config libssl-dev libyaml-dev
RUN docker-php-ext-install pdo pgsql pdo_pgsql

# Install yaml
RUN pecl install yaml \
    && echo "extension=yaml.so" > /usr/local/etc/php/conf.d/yaml.ini

# Add init scripts
COPY init.d /docker-entrypoint-init.d/
COPY etc /usr/local/etc
FROM php:7.3-fpm


RUN apt-get update && apt-get -y install \
        git g++ libcurl4-gnutls-dev libicu-dev libmcrypt-dev libpq-dev libxml2-dev unzip zlib1g-dev procps  \
    && docker-php-ext-install curl intl json mbstring pdo pdo_mysql pdo_pgsql xml \
    && apt-get autoremove && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN echo 'date.timezone="Europe/Madrid"' >>  /usr/local/etc/php/conf.d/date.ini
RUN echo 'session.save_path = "/tmp"' >>  /usr/local/etc/php/conf.d/session.ini

RUN curl -s https://getcomposer.org/installer | php \
	&& mv composer.phar /usr/local/bin/composer

WORKDIR WORK_DIR
COPY . WORK_DIR

COPY scripts/ /usr/local/bin
RUN chmod +x /usr/local/bin/ssh.sh

RUN composer install


# RUN ssh -fNg -L ${DATABASE_PORT}:127.0.0.1:${DATABASE_PORT} ${DATABASE_LOGIN}@${DATABASE_HOST}
# CMD ssh -fNg -L 3306:127.0.0.1:3306 root@47.101.202.230

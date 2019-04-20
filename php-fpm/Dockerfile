FROM php:7.3-fpm


RUN apt-get update && apt-get -y install \
        git g++ libcurl4-gnutls-dev libicu-dev libmcrypt-dev libpq-dev libxml2-dev unzip zlib1g-dev \
    && docker-php-ext-install curl intl json mbstring pdo pdo_mysql pdo_pgsql xml \
    && apt-get autoremove && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN echo 'date.timezone="Europe/Madrid"' >>  /usr/local/etc/php/conf.d/date.ini
RUN echo 'session.save_path = "/tmp"' >>  /usr/local/etc/php/conf.d/session.ini



# Use consul as client agent
# RUN curl  -O https://releases.hashicorp.com/consul/1.4.4/consul_1.4.4_linux_amd64.zip \
# 	 && unzip consul_1.4.4_linux_amd64.zip \
#     && mv consul /bin \
#     && rm consul_1.4.4_linux_amd64.zip

# ADD ~/.ssh/
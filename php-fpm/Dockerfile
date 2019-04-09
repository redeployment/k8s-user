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
ENV CONSUL_TEMPLATE_VERSION 0.20.0

RUN curl  -O https://releases.hashicorp.com/consul/1.4.4/consul_1.4.4_linux_amd64.zip \
	 && unzip consul_1.4.4_linux_amd64.zip \
    && mv consul /bin \
    && rm consul_1.4.4_linux_amd64.zip


# Use consul-template to re-write our PHP Service config
ENV CONSUL_TEMPLATE_VERSION 0.20.0

RUN curl  -O https://releases.hashicorp.com/consul-template/${CONSUL_TEMPLATE_VERSION}/consul-template_${CONSUL_TEMPLATE_VERSION}_linux_386.tgz \
	 && tar -zxf consul-template_${CONSUL_TEMPLATE_VERSION}_linux_386.tgz \
    && mv consul-template /bin \
    && rm consul-template_${CONSUL_TEMPLATE_VERSION}_linux_386.tgz



# get ContainerPilot release
ENV CONTAINERPILOT_VERSION 3.8.0
RUN export checksum=84642c13683ddae6ccb63386e6160e8cb2439c26	 \
    && curl -Lso /tmp/containerpilot.tar.gz \
         "https://github.com/joyent/containerpilot/releases/download/${CONTAINERPILOT_VERSION}/containerpilot-${CONTAINERPILOT_VERSION}.tar.gz" \
    && echo "${checksum}  /tmp/containerpilot.tar.gz" | sha1sum -c \
    && tar zxf /tmp/containerpilot.tar.gz -C /usr/local/bin \
    && rm /tmp/containerpilot.tar.gz	




# add config file
COPY config/ /etc
COPY scripts/ /usr/local/bin

RUN chmod +x /usr/local/bin/reload.sh


# CMD /usr/local/bin/containerpilot -config /etc/containerpilot.json5
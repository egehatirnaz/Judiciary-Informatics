FROM phusion/baseimage

RUN add-apt-repository ppa:ondrej/php

RUN \
  apt-get -y update \
  &&  apt-get -y upgrade \
  &&  apt-get update --fix-missing

RUN \
    apt-get install -y \
      php7.2 \
      php7.2-bcmath \
      php7.2-cli \
      php7.2-common \
      php7.2-curl \
      php7.2-fpm \
      php7.2-gd \
      php7.2-gmp \
      php7.2-imap \
      php7.2-intl \
      php7.2-json \
      php7.2-mbstring \
      php7.2-mysqlnd \
      php7.2-opcache \
      php7.2-pdo \
      php7.2-xml


RUN \
    apt-get install -y \
      git

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN service php7.2-fpm start

RUN \
    apt-get install -y \
      nginx-full

RUN apt-get clean
RUN apt-get autoclean

# build settings
COPY build/php.ini /etc/php/7.2/cli/php.ini

# nginx settings
# COPY nginx/.htpasswd /etc/nginx/.htpasswd
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/default-dev /etc/nginx/sites-enabled/default

RUN chown www-data:www-data /var/lib/php/sessions/
RUN unlink /etc/localtime && ln -s /usr/share/zoneinfo/Europe/Istanbul /etc/localtime


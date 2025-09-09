FROM almalinux:8.8

ARG UID
ARG GID
ARG PHP_VERSION
ARG NODE_VERSION
ARG NGINX_VERSION

RUN rpm --import https://repo.almalinux.org/almalinux/RPM-GPG-KEY-AlmaLinux
RUN yum -y update
RUN dnf update && dnf upgrade -y

RUN yum install -y ncurses
RUN yum clean all

RUN dnf install -y epel-release
RUN dnf install -y https://rpms.remirepo.net/enterprise/remi-release-8.rpm
RUN dnf -y module reset php
RUN dnf module enable php:remi-${PHP_VERSION} -y
RUN dnf install php -y
RUN dnf install -y php-gd php-pgsql php-mysql php-zip php-imagick
COPY .docker/webserver/php/php.ini /etc/php.ini

#important: for make www.sock & php-fpm.pid
RUN mkdir -p /run/php-fpm

#RUN dnf module reset nginx -y
#RUN dnf module enable nginx:${NGINX_VERSION} -y
#RUN dnf install nginx -y

RUN yum install -y unzip curl
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN curl -fsSL https://rpm.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && yum install -y nodejs

RUN yum install yum-utils -y
COPY .docker/webserver/nginx/nginx.repo /etc/yum.repos.d/nginx.repo
RUN yum install nginx -y
COPY .docker/webserver/nginx/default.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /etc/nginx/crt
COPY .docker/webserver/nginx/server.crt /etc/nginx/crt/server.crt
COPY .docker/webserver/nginx/server.key /etc/nginx/crt/server.key

RUN yum install supervisor -y
COPY .docker/webserver/supervisor/laravel-worker.ini /etc/supervisord.d/laravel-worker.ini
COPY .docker/webserver/supervisor/php-fpm-worker.ini /etc/supervisord.d/php-fpm-worker.ini
COPY .docker/webserver/supervisor/nginx-worker.ini /etc/supervisord.d/nginx-worker.ini

WORKDIR /var/www/html

COPY .docker/webserver/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN groupadd -g ${GID} --system laravel
RUN useradd -g laravel --system -M -s /bin/sh -u ${UID} laravel
RUN sed -i "s/user = apache/user = laravel/g" /etc/php-fpm.d/www.conf
RUN sed -i "s/group = apache/group = laravel/g" /etc/php-fpm.d/www.conf
RUN sed -i "s/;listen.owner = nobody/listen.owner = laravel/g" /etc/php-fpm.d/www.conf
RUN sed -i "s/;listen.group = nobody/listen.group = laravel/g" /etc/php-fpm.d/www.conf
RUN sed -i "s/listen.acl_users/;listen.acl_users/g" /etc/php-fpm.d/www.conf
RUN sed -i "s/user  nginx/user  laravel/g" /etc/nginx/nginx.conf

ENTRYPOINT [ "/usr/local/bin/entrypoint.sh" ]
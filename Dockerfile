FROM php:7.3-apache as production
RUN set -eux; \
    if command -v a2enmod; then \
        a2enmod rewrite; \
    fi; \
    apt-get update && apt-get upgrade -y && apt-get install -y \
        less \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libldap2-dev \
        libpng-dev \
        libmagickwand-dev \
        libmemcached-dev \
        zlib1g-dev \
        libzip-dev \
    ; \
    yes '' | pecl install memcached-3.1.5 imagick-3.4.4 \
    ; \
    docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
    ; \
    docker-php-ext-install -j$(nproc) \
        gd \
        exif \
        ldap \
        mysqli \
        opcache \
        pdo_mysql \
        zip \
    ; \
    docker-php-ext-enable memcached imagick;

RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=60'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini; \
    echo 'memory_limit = 256M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;
COPY --chown=www-data:www-data . /var/www/html/
# Updating the apache launch for public
RUN sed -i 's/\/html/\/html\/public/g' /etc/apache2/sites-available/000-default.conf
ENV PATH "$PATH:/var/www/html/vendor/bin"

FROM production as development
RUN set -ex; \
    apt-get update && apt-get install -y \
        golang \
        git \
        mariadb-client \
        vim \
        ; \
    go get github.com/mailhog/mhsendmail; \
    cp /root/go/bin/mhsendmail /usr/local/bin; \
    apt-get remove -y \
        golang \
        git \
    ; \
    apt-get autoremove -y; \
    echo 'sendmail_path = /usr/local/sbin/mhsendmail' >> /usr/local/etc/php/conf.d/docker-php-sendmail.ini;

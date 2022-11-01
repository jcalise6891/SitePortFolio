FROM thecodingmachine/php:8.1-v4-apache-node16

RUN sudo apt update && \
     sudo apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip
#     docker-php-ext-install intl opcache pdo pdo_mysql && \
#     pecl install apcu && \
#     docker-php-ext-enable apcu && \
#     docker-php-ext-configure zip && \
#     docker-php-ext-install zip

WORKDIR /var/www/html

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
RUN sudo apt install symfony-cli
RUN git config --global user.email "julien.calise@orange.fr" \
    && git config --global user.name "jcalise"

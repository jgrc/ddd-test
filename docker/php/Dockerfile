FROM php:7.3.1-cli-alpine3.8
RUN docker-php-ext-install bcmath mbstring
RUN mkdir /.composer && chmod 777 /.composer
ENV PATH /var/app/bin:/var/app/vendor/bin:$PATH
WORKDIR /var/app
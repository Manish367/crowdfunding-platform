FROM php:7.4-cli

WORKDIR /usr/src/app

COPY ./php/src/ ./

EXPOSE 80

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

CMD ["php", "-S", "0.0.0.0:80"]
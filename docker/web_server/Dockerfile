FROM php:8.1-apache
RUN apt update
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd
RUN docker-php-ext-configure mysqli --with-mysqli=mysqlnd

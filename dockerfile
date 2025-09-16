FROM php:8.1-apache

#instalar extensões necessarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

#Habilitar mod_rewrite para URLs amigaveis(mvc)
RUN a2enmod rewrite

#Copiar codigo para a pasta padrao do apache

COPY ./src/ /var/www/html

#AJustar permissões
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80
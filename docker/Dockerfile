# image php apache
FROM php:8.1-apache
# Telecharger un executable qui se trouve dans dans https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions et stocker dans usr/local/bin/
# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
# Executer cet exeutable en installant les extensions pdo_myql et inttl
# RUN chmod +x /usr/local/bin/install-php-extensions && \
#     install-php-extensions intl
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf 

RUN docker-php-ext-install \
    pdo pdo_mysql \
    \
    && apt update \
    && apt install -yqq libicu-dev \
    && apt install -yqq git \
    && apt install -yqq nodejs \
    \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl 
    
# 3
# RUN apt install -yqq --no-install-recommends \
#     locales apt-utils libxml2-dev libzip-dev libonig-dev libxslt-dev unzip 
# 4
 RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls \
    && mv composer.phar /usr/local/bin/composer 
# # 5
# # RUN curl -sS https://get.symfony.com/cli/installer | bash \
# #     && mv /root/.symfony5/bin/symfony usr/local/bin/symfony 

# # 6
# RUN docker-php-ext-configure \
#     intl 
# # 7
# # COPY . /var/www/
# #  Copier le fichier apache.conf dans /etc/apache/sites-available/ en ecrasant 000-default.conf de l'image
# # COPY ./docker/vhosts/vhost.conf /etc/apache2/sites-available/000-default.conf

# # ENV COMPOSER_ALLOW_SUPERUSER=1
# # # Lancer les commandes que l'applications a besoin pour fonctionner
# # RUN cd /var/www/projet && \
# #     composer install
# # # Chemin de demarrage de l'image
# # 8
# WORKDIR /var/www/
# # # Exposer le port 80 à l'exterieur 
# # EXPOSE 80
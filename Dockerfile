FROM library/php:7.4
LABEL maintainer="Bobby Hines <bobbyahines@gmail.com>"
LABEL image='bobbyahines/jeffersonparishcodepdf:latest'

# Export terminal processes for use of editors in container
ENV TERM xterm

# Update repos and install system/security updates
RUN apt-get update && apt-get dist-upgrade -y

#############################################################
## SELECTED UTILITIES  ######################################
#############################################################

# Install required utility programs
RUN apt-get install -y apt-utils \
    build-essential \
    curl \
    nano \
    wget

# Install base PDFtoText binary
RUN apt-get install -y poppler-utils

# Install composer and put binary into $PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install phpunit, the tool that we will use for testing
RUN curl --location --output /usr/local/bin/phpunit https://phar.phpunit.de/phpunit.phar && \
    chmod +x /usr/local/bin/phpunit

#############################################################
## PHP EXTENSIONS / LIBRARIES  ##############################
#############################################################

#Install/Enable gd library
RUN apt-get install -y libfontconfig1 libxrender1 libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) mysqli

# Install/Enable PDO mysql driver
RUN docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-configure pdo_mysql

# Install/Enable PHP Zip extension
RUN apt-get install -y libzip-dev zlib1g-dev zip \
    && docker-php-ext-install zip

#############################################################
##  DOCKER  #################################################
#############################################################

WORKDIR /srv
VOLUME /srv
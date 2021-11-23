#Base image for the container
FROM  php:7.2-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /website/

# Set working directory
WORKDIR /website/

#Install GIT, GnuPG, NodeJS and NPM
RUN apt-get update
# Run as root on RHEL, CentOS, CloudLinux or Fedora:

#Add Laravel necessary php extensions
RUN apt-get install -y \
    libzip-dev \
   build-essential \
    libpng-dev \
    mariadb-client \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    cron \
    curl
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
# Remove Cache
RUN rm -rf /var/cache/apk/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

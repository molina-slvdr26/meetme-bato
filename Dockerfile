FROM php:8.2-cli-alpine

RUN apk add --no-cache \
    mysql-client \
    nodejs \
    npm \
    git \
    curl \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    libxml2-dev

RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    xml \
    zip \
    bcmath \
    pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction

COPY package.json ./
RUN npm install

COPY . .

RUN npm run build

RUN composer dump-autoload --optimize --no-dev

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD ["/bin/sh", "/app/start.sh"]

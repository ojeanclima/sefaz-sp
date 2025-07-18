# Dockerfile para o ambiente sefaz-sp
FROM php:7.1-cli

# Corrige os repositórios do Debian Buster para o snapshot archive
RUN sed -i 's/deb.debian.org/archive.debian.org/g' /etc/apt/sources.list \
    && sed -i 's/security.debian.org/archive.debian.org/g' /etc/apt/sources.list \
    && apt-get update \
    && apt-get install -y libxml2-dev unzip git \
    && docker-php-ext-install soap

WORKDIR /app

# Copia e instala dependências PHP com Composer
COPY composer.json composer.lock /app/
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer install --no-interaction --optimize-autoloader

# Copia todo o código da aplicação
COPY . /app

# Comando padrão ao iniciar o container
CMD ["php", "examples/status-service.php"]

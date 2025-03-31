FROM php:8.2-fpm

# Argumentos definidos no docker-compose.yml
ARG user
ARG uid

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar o arquivo php.ini padrão
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd dom xml

# Garantir que as extensões estejam habilitadas no ambiente CLI
RUN echo "extension=dom.so" >> /usr/local/etc/php/conf.d/cli-dom.ini && \
    echo "extension=xml.so" >> /usr/local/etc/php/conf.d/cli-xml.ini

# Obter última versão do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário do sistema para rodar Composer e comandos Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Definir diretório de trabalho
WORKDIR /var/www

USER $user
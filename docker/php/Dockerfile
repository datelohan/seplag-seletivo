FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configuração de usuário dinâmica
ARG CURRENT_UID
ENV CURRENT_UID=${CURRENT_UID:-1000:1000}

# Criar usuário com UID dinâmico
RUN if [ -n "$CURRENT_UID" ]; then \
    deluser www-data && \
    addgroup --gid $(echo $CURRENT_UID | cut -d: -f2) www-data && \
    adduser --disabled-password --gecos '' --uid $(echo $CURRENT_UID | cut -d: -f1) --gid $(echo $CURRENT_UID | cut -d: -f2) www-data \
    ; fi

# Definir diretório de trabalho
WORKDIR /var/www/html

# Alterar proprietário dos arquivos
RUN chown -R www-data:www-data /var/www/html

# Mudar para usuário não-root
USER www-data

# Expor porta do PHP-FPM
EXPOSE 9000

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

# Comando padrão
CMD ["php-fpm"]
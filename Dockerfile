FROM php:8.2-cli-bookworm

RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    curl \
    xz-utils \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" \
    pdo_mysql \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache \
    && rm -rf /var/lib/apt/lists/*

# Node.js desde nodejs.org (evita tener que descargar la imagen node:* de Docker Hub).
ARG NODE_VERSION=22.12.0
RUN set -eux; \
    ARCH="$(uname -m)"; \
    case "$ARCH" in \
      x86_64) NODE_ARCH=x64 ;; \
      aarch64) NODE_ARCH=arm64 ;; \
      *) echo "unsupported arch: $ARCH"; exit 1 ;; \
    esac; \
    curl -fsSL "https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-${NODE_ARCH}.tar.xz" \
    | tar -xJ -C /usr/local --strip-components=1

# Composer sin imagen composer:2 (menos pulls desde el registro).
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

WORKDIR /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

COPY . /var/www/html

EXPOSE 8000 5174

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

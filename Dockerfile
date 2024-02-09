# Usa l'immagine di PHP con Apache
FROM php:8.2-apache

# Installa le dipendenze necessarie
RUN apt-get update && \
    apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zip \
        unzip \
        git \
        curl \
        nano

# Abilita i moduli di PHP necessari
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Abilita il modulo di Apache Rewrite
RUN a2enmod rewrite

# Imposta il percorso di lavoro all'interno del contenitore
WORKDIR /var/www/html

# Copia il file di configurazione Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Copia il codice sorgente Laravel nella directory di lavoro
COPY . .

# Imposta i permessi appropriati per la directory di storage di Laravel
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

# Installa Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installa le dipendenze PHP utilizzando Composer
RUN composer install

# Esporta la porta 80 per Apache
EXPOSE 80

# Avvia Apache quando il contenitore viene avviato
CMD ["apache2-foreground"]

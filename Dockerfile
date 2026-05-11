# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install mysqli, tzdata, wget
RUN docker-php-ext-install mysqli \
    && apt-get update && apt-get install -y tzdata wget && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Allow overrides and enable directory listing
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && sed -i 's/Options Indexes FollowSymLinks/Options +Indexes +FollowSymLinks/' /etc/apache2/apache2.conf

# Set ServerName to localhost
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy wait-for-it script from GitHub and make it executable
ADD https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh /usr/local/bin/wait-for-it.sh
RUN chmod +x /usr/local/bin/wait-for-it.sh

# Copy student files into Apache root
COPY student/ /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose HTTP port
EXPOSE 80

# Start Apache only after MySQL is ready
CMD ["bash", "-c", "wait-for-it.sh db:3306 -- apache2-foreground"]
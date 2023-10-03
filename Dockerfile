#FROM nginx:alpine3.18-slim
#
#ENV CONFIG_PATH=config_production
#ENV NODE_VERSION=18
#
## Installing packages
#RUN apk --no-cache add php nginx php-fpm zip unzip php-zip php-curl php-xml
#
## Create symlink so programs on php would know
##RUN ln -s /usr/bin/php8 /usr/bin/php
#
## Make directories
#RUN mkdir -p /var/www/html
#
## Configs
#COPY config_production/supervisord.conf /etc/supervisor/supervisord.conf
#COPY config_production/nginx.conf /etc/nginx/nginx.conf
#COPY config_production/fpm-pool.conf /etc/php8/php-fpm.d/www.conf
#COPY config_production/php.ini /etc/php8/conf.d/custom.ini
#
## Entrypoint
#COPY --chown=nginx config_production/entrypoint.sh /entrypoint.sh
#RUN chmod +x /entrypoint.sh
#
## Set Permissions
#RUN chown -R nginx /var && \
#    chown -R nginx /run
#
## Switch to use non-root user \
#USER nginx
#
## Build the app
#COPY --chown=nginx src/www /var/www
#
## Install packages
#COPY --from=composer:lts /usr/bin/composer /usr/bin/composer
#RUN cd /var/www/html && /usr/bin/composer install --optimize-autoloader --no-dev --no-interaction --no-progress
#
#EXPOSE 8080
#EXPOSE 8443
#
#ENTRYPOINT ["/entrypoint.sh"]
#CMD ["/usr/bin/supervisord", "-n"]

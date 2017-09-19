FROM bryanlatten/docker-php:7.1
RUN phpenmod redis
COPY ./ /app
RUN cd /app && chown -R www-data:www-data public/ && chmod -R 770 public/

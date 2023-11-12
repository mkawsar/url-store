FROM php:8.2.12-fpm-alpine

RUN apk update && apk add --no-cache supervisor
RUN mkdir -p "/etc/supervisor/logs"
COPY .docker/scheduler/supervisord.conf /etc/supervisor/supervisord.conf
CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]

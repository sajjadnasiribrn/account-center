FROM nginx:1.27.0-alpine


RUN apk add --no-cache gettext

COPY ./default.conf /etc/nginx/default.conf
COPY ./default-ssl.conf /etc/nginx/default-ssl.conf
COPY ./entrypoint.sh /entrypoint.sh

USER root
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]

FROM nginx:latest

# RUN rm /etc/nginx/conf.d/default.conf
# Copy your custom NGINX configuration
# COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/

ADD custom.nginx.conf /etc/nginx/conf.d/default.conf

RUN apt-get update && apt-get install -y \
    vim \
    nano

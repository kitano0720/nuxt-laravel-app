FROM node:16.15.0

WORKDIR /var/www/nuxt-app

RUN apt-get update && \
    apt-get install -y git unzip && \
    npm install -g npm@latest

ENV HOST 0.0.0.0

EXPOSE 3000

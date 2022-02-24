FROM php:7.1-alpine AS base

ENV APPUSR=twigger
ENV APPGRP=twigger

RUN addgroup -S $APPGRP && adduser -S $APPUSR -G $APPGRP
RUN mkdir -p /home/$APPUSR && chown -R $APPUSR:$APPGRP /home/$APPUSR
RUN mkdir -p /home/$APPUSR/bin && chown -R $APPUSR:$APPGRP /home/$APPUSR/bin
ENV PATH="/home/$APPUSR/bin:$PATH"

USER $APPUSR
ENV COMPOSER_HOME=/home/$APPUSR/composer
RUN (cd /tmp; \
    curl https://getcomposer.org/installer -o composer-setup.php  \
    && php composer-setup.php --install-dir=/home/$APPUSR/bin \
    && mv /home/$APPUSR/bin/composer.phar /home/$APPUSR/bin/composer)

FROM base as build
RUN mkdir -p /home/$APPUSR/cli && chown -R $APPUSR:$APPGRP /home/$APPUSR/cli
WORKDIR /home/$APPUSR/cli
COPY --chown=twigger:twigger composer.json .
COPY --chown=twigger:twigger composer.lock .
RUN composer install --optimize-autoloader
COPY --chown=twigger:twigger . .
RUN chmod +x /home/$APPUSR/cli/twigger.php
RUN ln -s /home/$APPUSR/cli/twigger.php /home/$APPUSR/bin/twigger

FROM build as app
WORKDIR /home/$APPUSR/app
ENTRYPOINT ["twigger", "lint:twig"]
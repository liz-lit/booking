FROM ubuntu
ENV DEBIAN_FRONTEND=noninteractive

ADD postgres /home/postgres/
ADD nginx /home/nginx

RUN mkdir -p /home/project
VOLUME ["/home/project"]
WORKDIR /home/project

RUN apt-get update && apt-get install -yq \
    vim \
    git \
    nginx \
    postgresql \
    php7.2 \
    php7.2-pgsql \
    php7.2-fpm \
    php7.2-dev \
    php-pear \
    php7.2-mbstring \
    php-yaml

RUN rm /etc/posgresql/10/main/pg_hba.conf \
    && cp /home/postgres/pg_hba.conf_trust /etc/postgresql/10/main/pg_hba.conf \
    && service postgresql start \
    && psql -U postgres -c "ALTER USER postgres PASSWORD '12345':" \
    && psql -U postgres -c "CREATE DATABASE intership;" \
    && rm /etc/posgresql/11/main/pg_hba.conf \
    && cp /home/postgres/pg_hba.conf_md5 /etc/postgresql/10/main/pg_hba.conf \
    && echo "listen_addresses = '*'" >> /etc/postgresql/10/main/postgresql.conf

RUN rm /etc/nginx/sites-available/default \
    && cp /home/nginx/default /etc/nginx/sites-available/default

CMD nginx && service postgresql restart && service php7.2-fpm start && bashhom

FROM mysql:8.0

ENV MYSQL_ROOT_PASSWORD=example
ENV MYSQL_DATABASE=fundraiser

COPY ./mysql/fundraiser.sql /init.sql

CMD ["mysqld", "--init-file=/init.sql"]
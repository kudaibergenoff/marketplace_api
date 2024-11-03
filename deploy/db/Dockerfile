FROM postgres:17-alpine3.20

COPY ./postgresql.conf /var/lib/postgresql/data/postgresql.conf
COPY ./pg_hba.conf /var/lib/postgresql/data/pg_hba.conf

CMD ["postgres", "-c", "config_file=/var/lib/postgresql/data/postgresql.conf"]

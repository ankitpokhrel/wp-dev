FROM mysql

COPY ./mysql-secret.cnf /mysql-secret.cnf

RUN chown mysql:mysql /mysql-secret.cnf
RUN chmod 600 /mysql-secret.cnf

EXPOSE 3306

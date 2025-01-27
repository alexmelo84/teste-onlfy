FROM shinsenter/laravel:latest

RUN phpaddmod pdo_mysql

# ADD ./bin/00-migration /startup/00-migration
# RUN chmod +x /startup/00-migration

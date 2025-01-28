# Introdução

Esse é um projeto para o desafio técnico de gestão de viagens para a Onfly.

Os requisitos do teste podem ser encontrados no diretório */api/resources/requirements/*.

## Stack

Roda em um container Docker com a [imagem](https://hub.docker.com/r/shinsenter/laravel).

Essa imagem instala e executa uma aplicação em Laravel mais recente.

Como banco de dados utiliza um MySQL.

## Utilização

Faça o clone do projeto:

- com SSH:
```
git clone git@github.com:alexmelo84/teste-onlfy.git
```

- ou com HTTPS:
```
git clone https://github.com/alexmelo84/teste-onlfy.git
```

Após terminar o download do projeto, execute o Docker:
```
docker compose up
```

Dando tudo certo, devem aparecer as seguintes mensagens no log:
```
NOTICE: fpm is running, pid XXXX
NOTICE: ready to handle connections
```

Para rodas as migrations, acesse o container:
```
docker exec -it teste-onfly sh
```

E então execute a migration:
```
/var/www/html# php artisan migrate
```

Para rodar o seeder que populará com um usuário de teste, execute:
```
/var/www/html# php artisan db:seed
```

A aplicação rodará na porta *:8000* então toda ass chamadas deverão ser feitas via Postman ou aplicações semelhantes através dessa porta.

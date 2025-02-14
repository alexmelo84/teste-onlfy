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

## Filas

Toda vez uma viagem tem seu status alterado uma notificação será enviada, mas ficará numa fila para processo assíncrono.

Nesse momento a fila usa a opção *database* para servir de exemplo. Os itens da fila podem ser vistos na tabela *jobs*.

Para rodar a fila, execute o comando:

```
php artisan queue:work
```

E para ver que o envio da notificação foi feito, consulte a tabela *notifications*. Nesse ponto foi considerado apenas um sistema interno de notificações, mas pode-se adicionar outras formas pois o *job* espera uma interface de notificação.

## Testes

### Integração

No diretório */api/resources/integration/postman* há uma coleção do Postman para ser utilizada para testes.

A primeira rota deve ser a de autenticação, que fica em *Autenticação -> Login*. Se o seeder tiver sido rodado basta usar as credenciais já salvas ou utilizar as criadas por você.

### Unitários

Para rodar os testes unitários execute no terminal:
```
docker exec -it teste-onfly sh
```

Para acessar o container e depois rode o teste:
```
php artisan test
```

Ou
```
./vendor/bin/phpunit
```

Nesse momento há teste de apenas uma classe para ilustração.

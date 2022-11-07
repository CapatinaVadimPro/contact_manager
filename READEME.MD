
# Symfony 6 + PHP 8.1 and MYSQL with Docker

## Run Locally

Clone the project

```bash
  git@github.com:CapatinaVadimPro/contact_manager.git
```

First of all create from .env.template files .env files 


Run the docker-compose

```bash
  docker-compose build
  docker-compose up -d
```

Log into the PHP container

```bash
  docker exec -it sf6_php bash
```


Start symfony project

```bash
  cd /var/www/html/
  symfony serve -d
```

*Your application is available at http://127.0.0.1:9000*

## Ready to use with
- End point */api/contact
[x]  [GET] / => list all contacts
[x]  [POST] /new => add new contact
  Payload:
   {
    "firstname": string,
    "lastname": string,
    "email": string,
    "address": string,
    "phone": string,
    "age": int
   }
[x]  [PUT] /{id} => update an existing contact 
[x]  [DELETE] /{id} => remove an existing contact



This docker-compose provides you :

- php:8.1-cli (Debian)
    - Composer
    - Symfony CLI
    - and some other php extentions
- mysql:5.7

## Requirements

- Linux (Ubuntu 20.04 or other)
- Docker
- Docker-compose
## Author

- [CAPATINA Vadim]
# Car API
A simple dockerized api projects powered by Symfony 6.3 and API Platform

## Requirements
Nginx (latest version recommended)
PHP _≥8.1_
PostgreSQL _≥15_
Symfony _≥6.3_
API Platform _≥3.2_

## Directory Structure
- docker
    > Including needed Dockerfiles and docker-compose to run the project
    * /.env
        > Set the variables for docker-compose
    * /Makefile
        > Useful commands to manage docker-compose build and run

- src
    > Including the symfony project files
    * /.env
        > The place where you can make basic configuration on the project

## Steps to run
> Following the blew steps to run the project using **docker-compose**
*For more info please read (docker/Makefile)*

```shell
cd docker
```

> Up
```shell
docker-compose up -d
```

> Down
```shell
docker-compose down
```

> Rebuild:
```shell
docker-compose down -v --remove-orphans
docker-compose rm -vsf
docker-compose up -d --build
```

> Run db commands
```shell
docker-compose exec php ./bin/console doctrine:database:drop --force
docker-compose exec php ./bin/console doctrine:database:create
docker-compose exec php ./bin/console doctrine:migrations:migrate -n
```

#### Notes:
- Project will run over **localhost** on ports [**8080**, **443**]
    You can change the ports using **docker/docker-compose.yml** file

- API routes are represent by **Swagger** through **http://localhost:8080/api**

- PostgreSQL is bounded to **0.0.0.0:15432** or **localhost:15432**
    Connection string already set in the **src/.env** file
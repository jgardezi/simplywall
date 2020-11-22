# Introduction
 
 This document describes project requirements, setup and directory structure.
 
### Requirements & Prerequisites
 
  - [Latest Docker](https://www.docker.com/) and [Docker Compose](https://docs.docker.com/compose/install/)
  - Git
  
### Directory Structure

Top level two main directories are

- **Code** 
  - *All the custom code, Lumen framework and depenencies*
- **Docker** 
  - *All the required docker images, PHP-FPM, NGINX, Workspace containers*
  
## Setup

1. Clone this repository anywhere on your OS.

```bash
> git clone https://github.com/jgardezi/simplywall.git
> cd simplywall
```

2.  There are two environment files, one for the PHP Lumen application itself, and the other to configure the Docker containers. Both have example templates. Copy these into place, and then edit as needed.

```bash
// Docker container enviornment
> cd docker; cp env-example .env

// Lumen App
> cd code; cp env-example .env
```

- Note that DB is not included in this Git repository. Can be downloaded by the provided link. Place sqlite DB inside
this project under the `code` directory. The `code` directory will be accessible inside the PHP docker container. The
example path for Lumen App `.env` DB path will be

```bash
// Lumen App .env
DB_DATABASE=/var/www/database.sqlite3
```

3. Build and run docker container. The first time the 'build' part takes some time, depending on your machine.

```bash
> cd docker
> docker-compose up -d nginx php-fpm workspace
```

4. Varify that all the container are running 
```bash
> docker-compose ps

// example of running containers
            Name                           Command               State                        Ports
-------------------------------------------------------------------------------------------------------------------------
simplywall_docker-in-docker_1   dockerd-entrypoint.sh            Up      2375/tcp, 2376/tcp
simplywall_nginx_1              /docker-entrypoint.sh /bin ...   Up      0.0.0.0:443->443/tcp, 0.0.0.0:80->80/tcp, 81/tcp
simplywall_php-fpm_1            docker-php-entrypoint php-fpm    Up      9000/tcp
simplywall_workspace_1          /sbin/my_init                    Up      0.0.0.0:2222->22/tcp
```

5. Install Lumen App
```bash
> cd docker
> docker-compose exec workspace composer install
```

6. Verify Install is successful by loading `localhost` your browser or issue command `curl -i localhost` or using [Postman](https://www.postman.com/).

```bash
HTTP/1.1 200 OK
Server: nginx
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.3.24
Cache-Control: no-cache, private
Date: Sat, 21 Nov 2020 15:30:22 GMT

Lumen (8.2.0) (Laravel Components ^8.0)
```

## API Documentation

- Compaines list API's and paramaters options.
  - orderBy: *volatility* option will not work with sqlite DB as `FIELD` function is not available.

```bash
> curl --location --request GET 'localhost/companies?limit=10&orderBy=score&sortBy=asc&exchangeSymbols=ASX,NYSE&scoreTotal=13&page=1'

Parameters:
limit: (optional) number results in a page i.e. 10, 15, 25, ...
page: (optional) page number i.e. 1, 2, ...
orderBy: (optional) Options: *score*, *volatility*
sortBy: (optional) Options: *asc*, *desc*
exchangeSymbols: (optional) filter result by one or more exchanges code by comma seperate i.e. ASX,NYSE
scoreTotal: (optional) filter result by overall score i.e. 8, 13, 20, ...
```

## API Testing

Only API unit cases is added to cover larger portion of the code. All the test cases are under directory `code/tests`. To execute test cases, see commnd below.

```bash
> cd docker
> docker-compose exec workspace vendor/bin/phpunit


PHPUnit 9.4.3 by Sebastian Bergmann and contributors.

.....                                                               5 / 5 (100%)

Time: 00:02.402, Memory: 14.00 MB

OK (5 tests, 98 assertions)
```
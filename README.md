# docker-wordpress-phpmyadmin-maildev
```sh
git clone git@github.com:Kodi-Studio/docker-wordpress-phpmyadmin-maildev-.git
```
Build docker image :
```sh
docker-compose build
```
Run project images :
```sh
docker-compose up -d
```
## PhpMyadmin :

```sh
- http://localhost:8080
- login : root (without password)
```
## WORDPRESS :

```sh
http://localhost:3000
```

Create and config your Wordpress :
 - DB : wordpress
 - Login : root
 - pass :
 - prefix : wp_

 You can change DB name in the docker-compose.yml :
```sh
db:
      image: mysql
      container_name: db_docker_kodistudio
      restart: always
      volumes:
          # to persist data into db-data directory project :
          - ./db-data:/var/lib/mysql
          # to persist data into db-data Docker volume
          # - db-data:/var/lib/mysql
      environment:
          MYSQL_ALLOW_EMPTY_PASSWORD: 'yes'
          MYSQL_DATABASE: wordpress
      networks:
        - dev
```
# Lemonnier
# Lemonnier

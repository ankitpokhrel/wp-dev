## WP Dev
Rapid dev environment using docker for modern WordPress development.

> This project is experimental and is currently in "works on my machine" stage. i.e
> it is only tested in OSX Sierra 10.12.5. Please feel free to try and report any bug 
> found. Pull requests, issues, and project recommendations are more than welcome!

## Overview
WP Dev aims to setup dev environment for modern WordPress development using simple yaml configuration inside `setups.yml`. 
A basic setup will only have website name, host and database name. The build command will fetch latest WordPress, configure 
and make it ready for you to work further. If git `source` is provided, it will clone the project from given repo. The system 
is also capable of provisioning database, installing plugins and themes using `wp-cli` during project setup.
```yaml
# Sample configuration
website1:
  host: website1.dev
  env:
    DB_NAME: website1_db
```

### What's included?
1. [PHP-fpm 7.0.x](https://php-fpm.org/)
2. [Nginx](http://nginx.org/) ([stable](https://www.nginx.com/blog/nginx-1-10-1-11-released/) version)
3. [Supervisor](http://supervisord.org/)
4. [MySQL 5.7.*](https://www.mysql.com/)
5. [Redis](https://redis.io/)
6. [WP-CLI](http://wp-cli.org/)
7. [Composer](https://getcomposer.org/)
8. [NodeJs 6.x](https://nodejs.org)
9. [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) & [WP Coding Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards)
10. [phpMyAdmin](https://www.phpmyadmin.net/) & [Adminer](https://www.adminer.org/)

### Prerequisites
1. Install docker: https://docs.docker.com/engine/installation/
2. Make sure that you have `docker-compose` installed

   ```shell
   $ docker-compose --version
   docker-compose version: 1.11.2
   ```

   If not, install `docker-compose`: https://docs.docker.com/v1.11/compose/install/

3. Install shyaml: https://github.com/0k/shyaml#installation
4. Install `git` if you haven't already: https://git-scm.com/book/en/v2/Getting-Started-Installing-Git

### Application level environments
Application level environment variables are located inside `app_env`. Following values are configurable.
```shell
# WP Dev
export APP_NAME="wpdev"
export APP_PORT="80"
export NETWORK_NAME="wpdev_network"
export LOG_FILE="${PWD}/logs/${APP_NAME}.logs"

# Default WordPress Settings
export WP_DEFAULT_TITLE="WordPress" # Site title
export WP_ADMIN_USER="admin"
export WP_ADMIN_PASSWORD="admin"
export WP_ADMIN_EMAIL="admin@local.dev"

# MySQL Database
export MYSQL_PORT="3306"
export MYSQL_ROOT_PASSWORD="wpdev"
export DB_HOST="wpdev-mysql" # Name of your mysql container
export DB_USER="wpdev"
export DB_PASSWORD="wpdev"
export MYSQL_CLIENT_PORT="8080"

# Redis
export REDIS_PORT="6379"

# phpmyadmin or adminer
export MYSQL_CLIENT="phpmyadmin"

# xdebug
export HOST_IP=192.168.1.2 # Your machine ip address for xdebug connection
```

### Configure websites
Copy or rename `setups.template.yml` to `setups.yml` to get started with the website setup. Website name, host and DB_NAME 
inside env are the only values required. Website name can only be alphanumeric and can contain hyphen/dash (-). 
```yaml
# Basic setup
website1:
  host: website1.dev
  env:
    DB_NAME: website1_db

# Complete entry with source as a git repo
website2:
 host: website2.dev
 source: git@git.org:user/project.git
 title: "Website 2 with all settings"
 admin_user: "admin"
 admin_password: "admin"
 admin_email: "admin@website1.com"
 plugins:
   - "plugin-slug-1 --activate"
   - "plugin-slug-2"
 themes:
   - "theme-slug-1 --activate"
   - "theme-slug-2"
 env:
   DB_NAME: website2_db

# WordPress 4.3
website3:
  host: website3.dev
  version: 4.3
  env:
    DB_NAME: website3_db
    
 # Cloning from existing project
 website2_clone:
   clone: website2
   host: website2clone.local
   env:
     DB_NAME: website2_clone_db

```

## Available options
Option         | Description                                                                                                                  | Default      
---------------|------------------------------------------------------------------------------------------------------------------------------|-----------------------
host           | Host name. This entry should also be made inside `/etc/hosts`                                                                |  
source         | Git source for the project to clone from                                                                                     |
clone          | Existing project to clone from                                                                                               |
version        | WordPress version                                                                                                            | latest
title          | WordPress site title                                                                                                         | defaults from `app_env`
admin_user     | WordPress admin user                                                                                                         | defaults from `app_env`
admin_password | WordPress admin password                                                                                                     | defaults from `app_env`
admin_email    | WordPress admin email                                                                                                        | defaults from `app_env`
plugins        | List of plugins to install during setup. You can provide all parameters that `wp-cli` accepts, eg: `--activate` or `--debug` |
themes         | List of themes to install during setup. You can provide all parameters that `wp-cli` accepts, eg: `--activate` or `--debug`  |
env            | Environment variables like `DB_NAME`. `DB_NAME` is required.                                                                 |

### Build
You only need to run build script if you have made any changes in `setups.yml` file.
```shell
$ ./wpdev build
```

To build core images only, use
```shell
$ ./wpdev build core

# To skip cache, use --no-cache option
$ ./wpdev build core --no-cache
```
   
To build projects only, use
```shell
$ ./wpdev build projects "<list of website name from setups.yml>"
```

You can access help file using `./wpdev build -h`

### Run project containers
You can skip this step if you just build the projects using above step. The projects should already be up and running.
From next time, you can just boot the containers using following command as the related project containers are already built.
```shell
$ ./wpdev up
```

### Update /etc/hosts
Update `/etc/hosts` by adding all hosts listed in `setups.yml`
```shell
0.0.0.0 your-project.host
```

If you followed above steps correctly then, at this point, you should be able access project in your browser. Project files are 
located inside `projects` folder.

### Accessing database configs
Database configs are stored in environment variables. In order to use it in say your project, use `getenv`.
```
/** The name of the database for WordPress */
define('DB_NAME', getenv('DB_NAME'));

/** MySQL database username */
define('DB_USER', getenv('DB_USER'));

/** MySQL database password */
define('DB_PASSWORD', getenv('DB_PASSWORD'));

/** MySQL hostname */
define('DB_HOST', getenv('DB_HOST'));
```

### Shutdown project containers
You can shutdown running containers using following script.
```shell
$ ./wpdev down
```

### Clean or destroy
You can delete all related containers using destroy script.
```shell
$ ./wpdev destroy
```

### Rebuild
Rebuild will first delete all related containers and builds it again. It is same as running `./wpdev destroy && ./wpdev build`.
```shell
$ ./wpdev rebuild -h
usage: rebuild
        --no-cache    Skip cache
        -h | --help   Display this help text
```

### Override project configuration
To override configurations for a project, copy `core/configs/default` folder and name it to your website name you are 
using in `setups.yml`. You can now change required configurations for the project. The system will first check if the 
configuration for the website is available and builds it, if not, it will use default configuration. 

### Volumes
All volumes are mounted inside `.data` folder except the logs. Logs are mounted inside `logs` folder.

- Composer: .data/composer
- NPM: .data/npm
- MySQL: .data/mysql
- Redis: .data/redis
- WP-CLI: .data/wp-cli

### Database provisioning and backup
If you want to import database for a project during setup, just add a sql file with same name as your database name and the system
will automatically import it during the build process. So for the basic setup above in [Configure websites](#configure-websites) 
section, you need to add a file called `website1_db` inside database folder. 

#### Backup all databases
To backup all databases, use
```shell
$ ./wpdev db backup_all
```

By default it will save backup to the `database` folder. You can provide custom path using `-p` option. 
```shell
$ ./wpdev db backup_all -p /path/to/downloads/bkp.sql
```

#### Backup specific databases
To only backup some databases, use
```shell
$ ./wpdev db backup -d "db1 db2"
```

Same as above it will save backup to the `database` folder. You can provide custom path using `-p` option. 
```shell
$ ./wpdev db backup -d "db1 db2" -p /path/to/downloads/bkp.sql
```

### MySQL Client
You can choose between `phpmyadmin` or `adminer` as your mysql client. By default the client runs on port `8080`.
These values are configurable in `app_env`. So with default configuration, you can access the client by visiting 
http://localhost:8080. You can use the values `DB_USER` and `DB_PASSWORD` from `app_env` to login.

> To connect database using third party clients like sequel pro, use `0.0.0.0` as a host. 
> `DB_HOST` is the ip of your mysql container which is `wpdev-mysql` by default.

### Running WP CodeSniffer
You can enter into container and run:
```shell
$ phpcs --standard=WordPress /path/to/file/or/folder

# to fix
$ phpcbf --standard=WordPress /path/to/file/or/folder
```

Or, execute it from outside
```shell
$ docker exec -it <container name or id> bash -c "phpcs --standard=WordPress /path/to/file/or/folder"

# to fix
$ docker exec -it <container name or id> bash -c "phpcbf --standard=WordPress /path/to/file/or/folder"
```

### Xdebug Remote Connection
To debug with xdebug using IDE like PHPStorm, follow following steps.
1. Update your machine ip (`HOST_IP`) in `app_env`.
2. Use your host name (container name) as a server name.
3. Use `localhost` as `host` and `APP_PORT` as port.
4. Start listening to PHP Debug Connections from your IDE.

### Todo
- [x] Add NodeJs and npm support.
- [x] Add PHP_CodeSniffer for [WordPress](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards).
- [x] Setup [Xdebug](https://xdebug.org/) remote connection.
- [ ] Ability to sync/update plugins, themes, core etc for a project.
- [x] Ability to create new project from existing one (variation).

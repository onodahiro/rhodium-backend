## Install guide 

### GIT

- sudo apt install git

### NGINX

- sudo apt update
- sudo apt install nginx
- sudo systemctl reload nginx

### MYSQLhttps://github.com/onodahiro/rhodium-backend/blob/main/SERVER.md

- sudo apt install mysql-server
- sudo mysql
- SELECT user,authentication_string,plugin,host FROM mysql.user;
- ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
- exit
- sudo mysql_secure_installation
- sudo mysql -u root -p
- CREATE USER 'laravel'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
- CREATE DATABASE laravel;
 -GRANT ALL ON laravel.* TO 'laravel'@'localhost';
- FLUSH PRIVILEGES;

### PHP-FPM-8.2 / PHP Extensions

- sudo apt update && sudo apt install -y software-properties-common
- sudo add-apt-repository ppa:ondrej/php
- sudo apt update
- sudo apt install php8.2-fpm
- sudo apt-get install -y php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath php-pgsql
- sudo apt-get install php8.2-mysql

### COMPOSER

- sudo apt install php-cli unzip
- cd ~
- curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
- HASH=`curl -sS https://composer.github.io/installer.sig`
- echo $HASH

#### check Installer verified

- php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
- sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer

#### check composer installed

- composer

### NODE NPM v20

- sudo apt-get update
- sudo apt-get install -y ca-certificates curl gnupg
- sudo mkdir -p /etc/apt/keyrings
- curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | sudo gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
- NODE_MAJOR=20 echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | sudo tee /etc/apt/sources.list.d/nodesource.list
- sudo apt-get update
- sudo apt-get install nodejs -y

### LINKS
#### sertbot install
- https://www.inmotionhosting.com/support/website/ssl/lets-encrypt-ssl-ubuntu-with-certbot/

sudo apt-get -y install gcc make autoconf libc-dev pkg-config
sudo pecl install oauth

sudo bash -c "echo extension=oauth.so > /etc/php/7.2/fpm/conf.d/oauth.ini"
sudo bash -c "echo extension=oauth.so > /etc/php/7.2/cli/conf.d/oauth.ini"
sudo service php7.2-fpm restart
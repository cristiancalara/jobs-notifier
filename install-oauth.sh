sudo apt-get -y install gcc make autoconf libc-dev pkg-config
sudo pecl install oauth

sudo bash -c "echo extension=oauth.so > /etc/php/7.2/mods-available/oauth.ini"
sudo ln -s /etc/php/7.2/mods-available/oauth.ini /etc/php/7.2/fpm/conf.d/30-oauth.ini
sudo ln -s /etc/php/7.2/mods-available/oauth.ini /etc/php/7.2/cli/conf.d/30-oauth.ini
sudo service php7.2-fpm restart
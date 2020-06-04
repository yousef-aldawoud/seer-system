apt-get update -y
apt-get upgrade -y
apt-get install vim -y
apt-get install composer -y
apt-get install git -y
apt-get install php php-xml php-mbstring php-mysql -y
apt-get install nginx -y
apt-get install mysql-server -y
apt-get install php-fpm -y
service mysql start
service nginx start
service php7.4-fpm start
git clone https://github.com/yousef-aldawoud/seer-system/ /var/www/seer-system
cp /var/www/seer-system/nginx/default.conf /etc/nginx/conf.d/
cp /var/www/seer-system/.env.example /var/www/seer-system/.env
cd /var/www/seer-system
composer install
php artisan key:generate
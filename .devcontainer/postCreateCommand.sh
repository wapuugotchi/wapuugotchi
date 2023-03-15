#! /bin/bash
REPO_FOLDER="/workspaces/$RepositoryName"

# Apache
sudo chmod 777 /etc/apache2/sites-available/000-default.conf
sudo sed "s@.*DocumentRoot.*@\tDocumentRoot $PWD/wordpress@" .devcontainer/000-default.conf > /etc/apache2/sites-available/000-default.conf
update-rc.d apache2 defaults 
service apache2 start

LOCALE="de_DE"

# WordPress Cire install
wp core download --locale=$LOCALE --path=wordpress
cd wordpress
wp config create --dbname=wordpress --dbuser=wordpress --dbpass=wordpress --dbhost=db
LINE_NUMBER=`grep -n -o 'stop editing!' wp-config.php | cut -d ':' -f 1`
sed -i "${LINE_NUMBER}r ../.devcontainer/wp-config-addendum.txt" wp-config.php && sed -i -e "s/CODESPACE_NAME/$CODESPACE_NAME/g"  wp-config.php
wp core install --url=https://$(CODESPACE_NAME) --title=WordPress --admin_user=admin --admin_password=admin --admin_email=mail@example.com

# Selected plugins
wp plugin delete akismet
wp plugin install show-current-template --activate
wp plugin activate wapuugotchi

# Demo content for WordPress
wp plugin install wordpress-importer --activate
curl https://raw.githubusercontent.com/WPTT/theme-unit-test/master/themeunittestdata.wordpress.xml > demo-content.xml
wp import demo-content.xml --authors=create
rm demo-content.xml

#Xdebug
echo xdebug.log_level=0 | sudo tee -a /usr/local/etc/php/conf.d/xdebug.ini

# install dependencies
cd $REPO_FOLDER
npm install 
composer install

# Setup local plugin
cd $REPO_FOLDER/wordpress/wp-content/plugins/wapuugotchi && npm install && npx playwright install && npm run compile:css
code -r wapuugotchi.php

# Setup bash
echo export PATH=\"\$PATH:$REPO_FOLDER/vendor/bin:$REPO_FOLDER/node_modules/.bin/\" >> ~/.bashrc
echo "cd $REPO_FOLDER/wordpress" >> ~/.bashrc
source ~/.bashrc

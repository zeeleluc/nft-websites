#!/bin/bash

apt-get update
apt-get install -y apache2

# Copy the vhost config file
cp /var/www/provision/config/apache/vhosts/weepingplebs.local.conf /etc/apache2/sites-available/weepingplebs.local.conf
cp /var/www/provision/config/apache/vhosts/lasereyes.local.conf /etc/apache2/sites-available/lasereyes.local.conf

# Disable the default vhost file
a2dissite 000-default

# Enable our custom vhost files
a2ensite weepingplebs.local.conf
a2ensite lasereyes.local.conf

# Enable ModRewrite
a2enmod rewrite

# Restart for the changes to take effect
service apache2 restart

# ssl certificate for domain
sudo apt install openssl
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/weepingplebs.local.key \
    -out /etc/ssl/certs/weepingplebs.local.crt \
    -subj "/C=US/ST=CA/L=San Francisco/O=Example, Inc./OU=IT Department/CN=weepingplebs.local"

sudo a2enmod ssl
sudo systemctl restart apache2

# ssl certificate for domain
sudo apt install openssl
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/lasereyes.local.key \
    -out /etc/ssl/certs/lasereyes.local.crt \
    -subj "/C=US/ST=CA/L=San Francisco/O=Example, Inc./OU=IT Department/CN=lasereyes.local"

sudo a2enmod ssl
sudo systemctl restart apache2


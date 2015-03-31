#!/bin/bash

service mysql start
mysql -uroot -e 'create database php7'
drush si --db-url=mysql://root:@127.0.0.1/php7 -y
apachectl -DFOREGROUND

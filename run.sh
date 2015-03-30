#!/bin/bash

service mysql start
mysql -uroot -e 'create database php7'
apachectl -DFOREGROUND

FROM dockerfile/ubuntu

# Install Apache/MySQL.
RUN sudo apt-get update -y
RUN sudo apt-get install apache2 mysql-client mysql-server curl libapache2-mod-auth-mysql -y

# Setup PHP7
COPY php-src /src
# autoconf, bison and libxml are for building PHP. apache2-dev is so we can build
# the shared PHP library for apache.
RUN sudo apt-get install autoconf bison libxml2-dev apache2-dev libfreetype6-dev libmcrypt-dev -y

# build the ./configure script
RUN cd /src && ./buildconf

# Configure with an apache shared .so file.
RUN cd /src && ./configure --with-apxs2=/usr/bin/apxs --enable-maintainer-zts --with-pdo-mysql --with-gd --enable-mbstring --enable-exif --with-mcrypt

#compile (4 is the number of cores you have)
RUN cd /src && make -j4 && make install

# Copy a config file into place and enable the php7 extension.
COPY php7.conf /etc/apache2/mods-available/php7.conf
RUN a2enmod php7

# Copy in the vhost and enable it.
COPY vhost /etc/apache2/sites-available/php7.conf
RUN a2ensite php7

# We need this hack to map the uid of our boot2docker user to the host so that
# we can write to the disk without permission issues.
RUN usermod -u 1000 www-data

RUN /usr/sbin/mysqld &

COPY run.sh /root/run.sh

CMD ["/root/run.sh"]

# Required Core Issues

 - https://www.drupal.org/node/2462151

# PHP7-Docker

To build the image:

    `docker build -t benjy/php7 .`
    
To run the image with fig:

    `fig up -d`
    
To run the image with docker (untested):

    `docker run benjy/php7 -p 8080 -v ./drupal8:/var/www/html/app`

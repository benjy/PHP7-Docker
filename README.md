# PHP7-Docker

To build the image:

    docker build -t benjy/php7 .
    
To run the image with docker-composer:

    docker-compose up -d
    
To run the image with docker (untested):

    docker run benjy/php7 -p 8080 -v ./drupal8:/var/www/html/app

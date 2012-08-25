PHP Tent server
===============

A project to create a simple PHP server for tent.io.

By:

* Ben Werdmuller: <http://benwerd.com/>
* Marcus Povey: <http://www.marcus-povey.co.uk>

Installation
------------

1) Copy files onto your webserver

2) Create a configuration file for your domain in /configuration/ e.g.

    /configuration/tentserver.mydomain.com.php

3) Rename htaccess_dist to .htaccess, optionally set RewriteBase according to 
your setup.

4) Create a database, and install a schema from /lib/schema

5) Add your database settings in your newly created configuration file, e.g.

    $CONFIG->mysql_db_user = 'db_user';
    $CONFIG->mysql_db_password = 'Some password'; 
    $CONFIG->mysql_db_database = 'tentserver';
    $CONFIG->mysql_db_host = 'localhost';
    


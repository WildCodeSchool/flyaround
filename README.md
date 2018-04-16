# FlyAround
=============

## Description

A Symfony 3.4.8 project in dev environment resulting from WCS's "symfony_parcours".
This one is based on flight sharing website linking specific users and pilots.

## Technos

PHP 7.1.3 / Symfony 3.4.8 / Doctrine / MYSQL.

## Require
    
    * Php 7.1.3 or higher           http://php.net/downloads.php
    * MySQL                         https://dev.mysql.com/downloads/installer/
    * Symfony Installer             https://github.com/symfony/symfony-installer
    * Composer                      https://getcomposer.org/download/

## Download project

Go to your working folder

    * Clone project -> git clone <url>
    * composer install / composer update (create parameters.yml with your default config based on parameters.yml.dist)
    * bin/console d:s:u --force (in "flyaround" database.)
    * Import documentation/flyaround.sql
    * bin/console c:c
    * bin/console s:r
    * Go on localhost:8000, create a profile, log in and go to flight creation and reservation.

- 16/04/2018 - V.1.0.0
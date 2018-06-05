# FlyAround
=============

## Description

A Symfony 3.4.11 project in dev environment resulting from WCS's "symfony_parcours".
This one is based on flight sharing website linking specific users and pilots.

## Technos

PHP ^7.1 / Symfony 3.4.11 / Doctrine / MYSQL / Webpack.

## Require
    
    * Php ^7.1.3 or higher          http://php.net/downloads.php
    * MySQL                         https://dev.mysql.com/downloads/installer/
    * Symfony Installer             https://github.com/symfony/symfony-installer
    * Composer                      https://getcomposer.org/download/
    * npm ^5.6 or higher            https://docs.npmjs.com/getting-started/installing-node#linux                  

## Download project

Go to your working folder

    * Clone project -> git clone <url>.
    * 'composer install' / 'composer update' (create parameters.yml with your default config based on parameters.yml.dist).
    * 'bin/console d:d:c' (will create flyaround database).
    * 'bin/console d:s:u --force' (will map all entities and create tables in "flyaround" database.)
    * Import documentation/flyaround.sql into your flyaround DB (instead of dataFixtures).
    * Run 'npm install' and then run 'npm run dev' to run the dev script.
    * 'bin/console c:c'.
    * 'bin/console s:r'.
    * Go on localhost:8000, create a profile, log in and go to flight creation and reservation.

- 18/05/2018 - V.1.1.0

Mgt Developer Toolbar for Magento 2
============================

The Mgt Developer Toolbar is a must have for Magento 2 developers and frontend guys.
The toolbar shows you all important information for performance optimisation and module development.

![Mgt Developer Toolbar](doc/static_files/mgt_developer_toolbar.png "Mgt Developer Toolbar")

## Main Features

* PHP Parse Time / Profiler
* Memory Consumption
* List of all Database Queries
* Block nesting
* Cache Storage Information
* Session Storage Information
* Enabled / Disabled Modules
* Request / Response Data
* Handles
* Events / Observers
* Plugins
* Preferences
* PHP-Info

## Installation with Composer

* Connect to your server with SSH
* Navigation to your project and run these commands
 
```bash
composer config repositories.mgt-developertoolbar vcs https://github.com/mgtcommerce/Mgt_Developertoolbar.git
composer require mgtcommerce/module-mgtdevelopertoolbar:dev-master

php bin/magento setup:upgrade
rm -rf pub/static/* 
rm -rf var/view_preprocessed/*

php bin/magento setup:static-content:deploy
```

## Installation without Composer

* Download the files from github: https://github.com/mgtcommerce/Mgt_Developertoolbar/archive/master.zip
* Extract archive and copy all directories from src/app/code/ to app/code/
* Go to project home directory and execute these commands

```bash
php bin/magento setup:upgrade
rm -rf pub/static/* 
rm -rf var/view_preprocessed/*

php bin/magento setup:static-content:deploy
```


## Usage

To enable / disable the toolbar go to Stores --> Configuration --> MGT-COMMERCE.COM --> Developer Toolbar

![Enable Mgt Developer Toolbar](doc/static_files/enable_toolbar.png "Enable Mgt Developer Toolbar")

Make sure to have the Full Page Caching (FPC) disabled otherwise the toolbar will not work

![Disable FPC](doc/static_files/disable_fpc.png "Disable FPC")
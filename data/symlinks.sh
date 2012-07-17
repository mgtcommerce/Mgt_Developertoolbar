#!/bin/sh

# find and deletes dead symlinks
cd /var/www/magento1420/htdocs && find -L . -type l -delete

lns -afFr /var/www/Mgt_DeveloperToolbar/htdocs/app/ /var/www/magento1420/htdocs/app/
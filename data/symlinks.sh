#!/bin/sh

# find and deletes dead symlinks
cd /var/www/magento1610/htdocs && find -L . -type l -print0 | xargs -0 rm

lns -afFr /var/www/Mgt_DeveloperToolbar/htdocs/ /var/www/magento1610/htdocs/
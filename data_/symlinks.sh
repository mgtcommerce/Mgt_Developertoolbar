#!/bin/sh

# find and deletes dead symlinks
cd /var/www/magento2.dev/ && find -L . -type l -print0 | xargs -0 rm

lns -afFr /var/www/Mgt_DeveloperToolbar/src/ /var/www/magento2.dev/
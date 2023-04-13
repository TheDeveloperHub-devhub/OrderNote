[//]: # (File format based on https://www.makeareadme.com/)

# Order Note
### Features
* Provides a note block on the order checkout page.
* Guest user(s) & logged-in customer(s) can write notes to their orders just by
entering them in the note block.
* Vendor(s) can set the maximum length of the order note from the backend
configurations.
* Vendor(s) can set the visibility of order notes to the customer(s) in their dashboard
order view page.


## Installation

1. Please run the following command
```shell
composer require developerhub/core
composer require developerhub/order-note
```

2. Update the composer if required
```shell
composer update
```

3. Enable module
```shell
php bin/magento module:enable DeveloperHub_Core
php bin/magento module:enable DeveloperHub_OrderNote
php bin/magento setup:upgrade
php bin/magento cache:clean
php bin/magento cache:flush
```
4.If your website is running in product mode the you need to deploy static content and
then clear the cache
```shell
php bin/magento setup:static-content:deploy
php bin/magento setup:di:compile
```



#####This extension is compatible with all the versions of Magento 2.3.* and 2.4.*. 
###Tested on following instances:
#####multiple instances i.e. 2.3.7-p4 and 2.4.5p1

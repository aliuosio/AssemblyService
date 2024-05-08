## Assembly Service
 
    composer config minimum-stability dev \
        && composer config repositories.assembly git https://github.com/aliuosio/AssemblyService.git \
        && composer config repositories.class git https://github.com/aliuosio/ProductClassToPostcode.git \
        && composer require biwac/magento-assembly-service:dev-develop \
        && bin/magento setup:upgrade \
        && bin/magento cache:clean;



### TODOS
* ~~add config to turn module turn module on/off~~
* ~~create **attribute products assembly service** (Type: radio, Values: true/false) (not visible in frontend only admin)~~
* ~~create **attribute products Product Class** for  (Type: select, Values: dummies (takes values later from table delievery Category)) (not visible in frontend only admin)~~
* ~~remove asembly service attributes from assembly service generated product~~
* ~~create product Assembly Service with fixed price~~
* ~~create table Product Class with category code (not unique) assigned to different postcodes~~
* ~~make table Product Class editable in admin~~
* ~~Get **attribute products Product Class** in admin from table. Each value distinct~~
* ~~add block with product assembly service under product only visible when parent product has been added to cart~~
* ~~add product_id of to be assembled product as custom option in assembly service product~~
* ~~display pulldown with Delivery Categories and postcode~~
* ~~change select in product assembly service to searchbale field~~
* make **attribute products Product Class** visible/dependent on selection of assembly service
* ~~display block assembly service in modal field~~
* only show modal if the assembly service for the current product has not been added to cart
* ~~show image for assembly service~~
* exclude the custon option postcode from verification so it can be added to cart
* create unit test
* create integration tests

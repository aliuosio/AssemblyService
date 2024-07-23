# Assembly Service

Assembly Service Integration for Product Detail Page
This project provides an assembly service integration for product detail pages, with dynamic pricing based on product complexity and customer postcode.

Features:
* Dynamic Pricing: Calculate assembly service fees based on the difficulty of the product and the customer's postcode.
* Easy Integration: Seamlessly integrate with your existing product detail page.
* User-Friendly: Ensure a smooth user experience with clear pricing information and service details.


## Installation
    composer require aliuosio/magento-assembly-service \
    && bin/magento setup:upgrade \
    && bin/magento cache:flush;


## Configuration
    Backend 
    Shop -> Configuration
    Tab: Osio -> Assembly Service

### Adminstration Postcode to Price
    Catalog -> Product Class to Postcode

### Asignment Assemby Service to Product
On the Product Edit page in Backend there is Group now called Assembly Service
If you only have an assembly service use the checkbox.
If there aso the option of the product being delivered. 
You can choose a Product class
    

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
* ~~display block assembly service in modal field~~
* ~~show image for assembly service~~
* ~~add new row and edit in admin grid~~
* ~~add assembly service on ad to cart~~
* ~~Configuration instructions~~
* ~~check new product bug~~
* ~~check if all five digits have been entered to postcode~~
* ~~make postcode mandatory before add to catt function~~
* ~~only show modal if the assembly service for the current product has not been added to cart~~
* make **attribute products Product Class** visible/dependent on selection of assembly service

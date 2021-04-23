<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  20/04/2021  Created purchases.php file 
#                               this will show all the purchases made by customer
#Gurpreet(1911343)  20/04/2021  Created a container for our purchase table



#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 

// Calling to generate header part of html
createPageHeader("Purchases");

// calling Buy form 
createPurchaseSearchForm();

//here is a container for our table
?>
    <div class="table-order" id="purchaseTableContainer">
        
    </div>
<?php

//Calling closing part of html
createPageFooter();
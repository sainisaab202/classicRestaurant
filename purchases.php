<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  20/04/2021  Created purchases.php file 
#                               this will show all the purchases made by customer



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

//Calling closing part of html
createPageFooter();
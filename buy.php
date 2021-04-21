<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  20/04/2021  Created buy.php file 
#                               For registering new customers by calling buy form



#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 


// Calling to generate header part of html
createPageHeader("Buy");

// calling Buy form 
createBuyForm();

//Calling closing part of html
createPageFooter();
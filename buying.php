<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   21/02/2021  connecting page with others and puting some text for test 


#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 


//Calling header part with a title
createPageHeader("Buying");

//Calling closing part of html
createPageFooter();
?>
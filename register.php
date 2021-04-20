<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  19/04/2021  Created register.php file 
#                               For registering new customers



#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 


// Calling to generate header part of html
createPageHeader("Register");

// calling regester form 
createRegisterForm();

//Calling closing part of html
createPageFooter();
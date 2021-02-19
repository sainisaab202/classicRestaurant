<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  19/02/2021  Created NetBeans project and related folders
#Gurpreet(1911343)  19/02/2021  set up the git repository
#Gurpreet(1911343)  19/02/2021  Importing functions and calling to page header and footer


#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 


// put your code here
createPageHeader();
createPageFooter();
?>

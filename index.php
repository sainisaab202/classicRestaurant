<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  19/02/2021  Created NetBeans project and related folders
#Gurpreet(1911343)  19/02/2021  set up the git repository, Importing functions and calling to page header and footer
#Gurpreet(1911343   21/02/2021  Added paragraph text and advertisment section


#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 


// Calling to generate header part of html
createPageHeader("Home");
?>
    <div class='home-paragraph'>
        <p>Mouthwatering Indian cuisine Classic Restaurant. Newly opened at a walking distance from Parc Metro station.
        A lot of choices available from North India to South shore. Delivery and Pickup service available. You can also order form Doordash.</p>
    </div>
    <div class='advertising-section'>
        <a href="https://www.doordash.com/" target="_blank"><?php displayAdvertisment() ?></a>
    </div>
<?php

//Calling closing part of html
createPageFooter();
?>

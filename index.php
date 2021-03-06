<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  19/02/2021  Created NetBeans project and related folders
#Gurpreet(1911343)  19/02/2021  set up the git repository, Importing functions and calling to page header and footer
#Gurpreet(1911343)  21/02/2021  Added paragraph text and advertisment section
#Gurpreet(1911343)  05/03/2021  Testing ErrorHandling and Exception Handling by creating errors
#Gurpreet(1911343)  05/03/2021  Project completed 100% (project 1)
#Gurpreet(1911343)  15/04/2021  Created the key and certificate for ssl 
#Gurpreet(1911343)  24/04/2021  Added a link where user can visit my cheatSheet file 
#Gurpreet(1911343)  28/04/2021  Project finished 100% (FINAL)



#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 


// Calling to generate header part of html
createPageHeader("Home");

//////---------------------------------------------------------
////to create exception
//throw new Exception("You got one more");

////to create error
//$number = 1;
//if($number / 0 == 10){
//    echo "Never going to happen";
//}
////---------------------------------------------------------
?>
    <div class='home-paragraph'>
        <p>Mouthwatering Indian cuisine Classic Restaurant. Newly opened at a walking distance from Parc Metro station.
        A lot of choices available from North India to South shore. Delivery and Pickup service available. You can also order form Doordash.</p>
    </div>
    <div class='advertising-section'>
        <a href="https://www.doordash.com/" target="_blank"><?php displayAdvertisment() ?></a>
    </div>

    <div class="cheatSheet-download">
        Visit my Cheat-Sheet 👉 <a href="<?php echo FILE_CHEATSHEET ?>" target="_blank">Here</a>.
    </div>
<?php

//Calling closing part of html
createPageFooter();


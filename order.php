<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   21/02/2021  connecting page with others and puting some text for test
#Gurpreet(1911343)   03/03/2021  calling of function to check any parameter in URL
#                                created div for table, download and call to the function 


#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('PHP_FUNCTIONS',PHP_FOLDER.'PHP_functions.php');

#import functions
require_once PHP_FUNCTIONS; 

checkUrlParameters();
//Calling top part of html
createPageHeader("Orders");

//create table and fill information from the text file
?>
    <div class="table-order">
        <?php
            createOrdersTable();
        ?>
    </div>
    <div class="cheatSheet-download">
        Download my Cheat-Sheet <a href="<?php echo FILE_CHEATSHEET ?>" download="">Here</a>.
    </div>
<?php

//calling bottom part of html
createPageFooter();
?>
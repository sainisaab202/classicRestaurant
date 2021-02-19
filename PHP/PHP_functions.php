<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   19/02/2021  Created functions for page header, page footer, Logo and navigation bar

//Declaring some constants
define('FOLDER_CSS', 'CSS/');
define('FILE_CSS', FOLDER_CSS.'style.css');
define('IMAGE_FOLDER', 'IMAGES/');
define('IMG_LOGO', IMAGE_FOLDER.'logo.png');

define('HOME_PAGE', 'index.php');
define('BUYING_PAGE', 'buying.php');
define('ORDER_PAGE', 'order.php');

function createPageHeader($title = "Classic Restaurant"){
    ?>
    <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" type="text/css" href="<?php echo FILE_CSS ?>">
                <title><?php echo $title ?></title>
            </head>
            <body class="bg-color-lightcyan">
                
    <?php
        createLogo();
        createNavigationMenu();
}

function createPageFooter(){
    ?>
            </body>
            <footer>Copyright by GurPreet SaiNi &COPY;<?php echo date('Y');?></footer>
        </html>
    <?php
}

function createLogo(){
    ?>
        <img class="logo-style" src="<?php echo IMG_LOGO ?>" alt="LOGO image"/>
    <?php
}

function createNavigationMenu(){
    ?>
        <div class='nav-float-right'>
            <ul>
                <li><a href="<?php echo HOME_PAGE; ?>">Home</a></li>
                <li><a href="<?php echo BUYING_PAGE; ?>">Buying</a></li>
                <li><a href="<?php echo ORDER_PAGE; ?>">Order</a></li>
            </ul>
        </div>
    <?php
}
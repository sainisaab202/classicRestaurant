<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   19/02/2021  Created functions for page header, page footer, Logo and navigation bar
#Gurpreet(1911343)   21/02/2021  Declared constants for images, function for advertisment, added header for UTF-8

//Declaring some CONSTANTS
define('FOLDER_CSS', 'CSS/');
define('FILE_CSS', FOLDER_CSS.'style.css');
define('IMAGE_FOLDER', 'IMAGES/');
define('IMG_LOGO', IMAGE_FOLDER.'logo.png');
define('IMG_ADV_PIZZA', IMAGE_FOLDER.'pizza.jpeg');
define('IMG_ADV_BURRITOS', IMAGE_FOLDER.'burritos.jpeg');
define('IMG_ADV_SANDWICH', IMAGE_FOLDER.'sandwich.jpeg');
define('IMG_ADV_PANEER', IMAGE_FOLDER.'shahi_paneer.jpeg');
define('IMG_ADV_SAMOSE', IMAGE_FOLDER.'samose.jpeg');

//constant for advertisment who pays us more
define('HIGH_ADV_PAYER', IMG_ADV_SAMOSE);

//Website page
define('HOME_PAGE', 'index.php');
define('BUYING_PAGE', 'buying.php');
define('ORDER_PAGE', 'order.php');

//CopyRight name
define('COPYRIGHT_NAME', 'GurPreet SaiNi (1911343)');


/**Will generage header part of website page 
 * @Param $title the title for your webpage */
function createPageHeader($title){
    header('Content-Type: text/html; charset=UTF-8');
    ?>
    <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" type="text/css" href="<?php echo FILE_CSS ?>">
                <title><?php echo "$title | Classic Restaurant"; ?></title>
            </head>
            <body class="bg-color-lightcyan">
                <h1 class='website-title'>Classic Restaurant</h1>
    <?php
        createLogo();
        createNavigationMenu();
}

/**Will generate footer part of webpage */
function createPageFooter(){
    ?>
            </body>
            <footer class='copyright-info'>Copyright by <?php echo COPYRIGHT_NAME ?> &COPY; <?php echo date('Y');?></footer>
        </html>
    <?php
}

/**Will create the logo of your website with IMG tag */
function createLogo(){
    ?>
        <img class="logo-style" src="<?php echo IMG_LOGO ?>" alt="LOGO image"/>
    <?php
}

/**Will create navigation menu using unorder list*/
function createNavigationMenu(){
    ?>
        <div class='navigation-bar'>
            <ul>
                <li><a href="<?php echo HOME_PAGE; ?>">Home</a></li>
                <li><a href="<?php echo BUYING_PAGE; ?>">Buying</a></li>
                <li><a href="<?php echo ORDER_PAGE; ?>">Order</a></li>
            </ul>
        </div>
    <?php
}

/**Will generate random image for the array using IMG tag*/
function displayAdvertisment(){
    $adv = array(IMG_ADV_BURRITOS, IMG_ADV_PANEER, IMG_ADV_PIZZA, IMG_ADV_SAMOSE, IMG_ADV_SANDWICH);
    shuffle($adv);
    $imgClass = $adv[0] == HIGH_ADV_PAYER ? 'gold-adv':'basic-adv';
    ?>
        <img class='adv <?php echo $imgClass ?>' src="<?php echo $adv[0] ?>" alt='advertisment image'>
    <?php
}
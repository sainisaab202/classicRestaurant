<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   19/02/2021  Created functions for page header, page footer, Logo and navigation bar
#Gurpreet(1911343)   21/02/2021  Declared constants for images, function for advertisment, added header for UTF-8
#Gurpreet(1911343)   26/02/2021  Declared function for form and did all the validations

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

//constants for Minumum and maximum for forms
define('FORM_MAX_PROD_CODE',12);
define('FORM_MAX_FNAME',20);
define('FORM_MAX_LNAME',20);
define('FORM_MAX_CITY',8);
define('FORM_MAX_COMMENT',200);
define('FORM_MAX_PRICE',10000);
define('FORM_MAX_QUANTITY',99);
define('FORM_MIN_QUANTITY',1);
define('FORM_LOCAL_TAX_PER', 12.05);
define('FORM_NUMS_AFTER_DECIMAL', 2);

//Global Variables
$productCode = "";
$firstName = "";
$lastName = "";
$customerCity = "";
$comment = "";
$price = "";
$quantity = "";
$subTotal = "";
$taxesAmount = "";
$grandTotal = "";


$errorProductCode = "";
$errorFirstName = "";
$errorLastName = "";
$errorCustomerCity = "";
$errorComment = "";
$errorPrice = "";
$errorQuantity = "";


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

/**Will generate html to create form*/
function createBuyingForm(){
    //getting access to global variable
    global $productCode;
    global $firstName;
    global $lastName;
    global $customerCity;
    global $comment;
    global $price;
    global $quantity;

    global $errorProductCode;
    global $errorFirstName;
    global $errorLastName;
    global $errorCustomerCity;
    global $errorComment;
    global $errorPrice;
    global $errorQuantity;
    
    //will check if submit button is clicked or not
    if(isset($_POST["save"])){
        $productCode = htmlspecialchars(trim($_POST['productCode']));
        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $lastName = htmlspecialchars(trim($_POST['lastName']));
        $customerCity = htmlspecialchars(trim($_POST['customerCity']));
        $comment = htmlspecialchars(trim($_POST['comment']));
        $price = htmlspecialchars(trim($_POST['price']));
        $quantity = htmlspecialchars(trim($_POST['quantity']));
                
        #validate the Product code
        if($productCode == ''){
            $errorProductCode = "The Product code cannot be empty.";
        }else if(!ctype_alnum($productCode)){       //if it contains special symbols
            $errorProductCode = "The Product code cannot contain symbols and white space.";
        }
        else{
            if(strtoupper(mb_substr($productCode, 0, 1))=="P"){    //if first letter is not P
                if(mb_strlen($productCode) > FORM_MAX_PROD_CODE){   //if exceeds max length
                $errorProductCode = "The Product code cannot cantain more than ".FORM_MAX_PROD_CODE." characters";
                } 
            } else {
                $errorProductCode = "The Product code should start from 'P' or 'p'.";
            }
        }
        
        #Validate First Name
        if($firstName == ''){
            $errorFirstName = "First name cannot be empty.";
        }else if(mb_strlen($firstName) > FORM_MAX_FNAME){
            $errorFirstName = "First name cannot contain more than ".FORM_MAX_FNAME." characters.";
        }else if(!ctype_alpha($firstName)){
            $errorFirstName = "First name should only contains alpha characters.";
        }
        
        #Validate Last Name
        if($lastName == ''){
            $errorLastName = "Last name cannot be empty.";
        }else if(mb_strlen($lastName) > FORM_MAX_LNAME){
            $errorLastName = "Last name cannot contain more than ".FORM_MAX_LNAME." characters.";
        }else if(!ctype_alpha($lastName)){
            $errorLastName = "Last name should only contains alpha characters.";
        }
        
        #Validate City
        if($customerCity == ''){
            $errorCustomerCity = "Customer cannot be empty.";
        }else if(mb_strlen($customerCity) > FORM_MAX_CITY){
            $errorCustomerCity = "Customer city cannot contain more than ".FORM_MAX_CITY." characters.";
        }else if(!ctype_alpha($customerCity)){
            $errorCustomerCity = "Customer city should only contains alpha characters.";
        }
        
        #Validate comment
        if(mb_strlen($comment) > FORM_MAX_COMMENT){
            $errorComment = "Comment cannot contain more than ".FORM_MAX_COMMENT." characters.";
        }
        
        #Validate Price
        if($price == ""){
            $errorPrice = "Price cannot be empty and should be in between 0$ and ".FORM_MAX_PRICE."$.";
        }else if($price < 0 || $price > FORM_MAX_PRICE){
            $errorPrice = "Price should be between 0$ and ".FORM_MAX_PRICE."$.";
        }
        
        #Validate Quantity
        if($quantity == ""){
            $errorQuantity = "Quantity cannot be empty and should be in between 1 and ".FORM_MAX_QUANTITY.".";
        }else if($quantity < 1 || $quantity > FORM_MAX_QUANTITY){
            $errorQuantity = "Quantity should be between 1 and ".FORM_MAX_QUANTITY.".";
        }
        
        #######
        #If all validation is successful then continue
        if($errorProductCode == "" && $errorFirstName == "" && $errorLastName == "" && $errorCustomerCity == "" && $errorComment == "" && $errorPrice == "" && $errorQuantity == ""){
            echo "<p style='color: red'> everything is good</p>";
            $subTotal = round($price * $quantity, FORM_NUMS_AFTER_DECIMAL);
            $taxesAmount = round($subTotal * (FORM_LOCAL_TAX_PER/100),FORM_NUMS_AFTER_DECIMAL);
            $grandTotal = $subTotal + $taxesAmount;

        }
    }
    
    ?>
        <div class="buying-form">
            <h2>Buying Form</h2>
            <form action='buying.php' method='POST'>
                <p>
                    <label>Product Code : </label><br>
                    <input type="text" name="productCode" value ="<?php echo $productCode?>"/>
                    <label class="error-code-label">* <?php echo $errorProductCode ?></label>
                </p>
                <p>
                    <label>Customer First Name : </label><br>
                    <input type="text" name="firstName" value="<?php echo $firstName ?>"/>
                    <label class="error-code-label">* <?php echo $errorFirstName ?></label>
                </p>
                <p>
                    <label>Customer Last Name : </label><br>
                    <input type="text" name="lastName" value="<?php echo $lastName ?>"/>
                    <label class="error-code-label">* <?php echo $errorLastName ?></label>
                </p>
                <p>
                    <label>Customer City : </label><br>
                    <input type="text" name="customerCity" value="<?php echo $customerCity ?>"/>
                    <label class="error-code-label">* <?php echo $errorCustomerCity ?></label>
                </p>
                <p>
                    <label>Comments : </label><br>
                    <textarea name="comment" rows="3" cols="30" maxlength="200"><?php echo $comment ?></textarea>
                    <label class="error-code-label"><?php echo $errorComment ?></label>
                </p>
                <p>
                    <label>Price : </label><br>
                    <input type="number" name="price" step=".01" value="<?php echo $price ?>"/>
                    <label class="error-code-label">* <?php echo $errorPrice ?></label>
                </p>
                <p>
                    <label>Quantity : </label><br>
                    <input type="number" name="quantity" value="<?php echo $quantity ?>"/>
                    <label class="error-code-label">* <?php echo $errorQuantity ?></label>
                </p>
                <p class="button-section">
                    <input type="submit" value='Submit' name="save" class="button"/>
                    <input type="reset" value='Clear' class="button"/>
                </p>
            </form>
        </div>
    <?php
}
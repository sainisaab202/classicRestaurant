<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   19/02/2021  Created functions for page header, page footer, Logo and navigation bar
#Gurpreet(1911343)   21/02/2021  Declared constants for images, function for advertisment, added header for UTF-8
#Gurpreet(1911343)   26/02/2021  Declared function for form and did all the validations
#Gurpreet(1911343)   27/02/2021  Optimize my validations for quantity and price
#Gurpreet(1911343)   03/03/2021  Clear text box after submit and save it in text file 
#                                Also commented the validation for numbers and symbols for first name, last name and city
#                                Declared function related to create table and check parameter URL
#                                Declared some constants for files and fileOperations
#Gurpreet(1911343)   05/03/2021  Declaration of Error and Exception handeling and write errors into log files
#                                Added header to prevent using browser cache   
#Gurpreet(1911343)   28/03/2021  corrected my tables for orders by putting th inside tr
#Gurpreet(1911343)   15/04/2021  Created key and certificate.
#                                Redirected to secure connection(HTTPS) if a request got from http
#Gurpreet(1911343)   18/04/2021  Declared some constants related to classes
#Gurpreet(1911343)   19/04/2021  Declared function to create login and logout form
#                                Declared constant for new page register.php
#                                Defining function for register form
#Gurpreet(1911343)   20/04/2021  Updated tax constant to 15.2%
#                                Created buy form and did all the validation stuff
#                                Added new pages in the navigation bar
#Gurpreet(1911343)   21/04/2021  Updated Register form so that we can use it for account info update as well
#                                Created script file to search for purchases with AJAX
#                                constants for file name and folder
#Gurpreet(1911343)   24/04/2021  Added a css class for Register Form
#Gurpreet(1911343)   28/04/2021  Edited registerUpdate function now clear button will appear only at register and not on update
#Gurpreet(1911343)   28/04/2021  Project part-3 finished 100%


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

//for the text file of orders and buying page
define('FOLDER_DATA', 'DATA/');
define('FILE_PURCHASE', FOLDER_DATA.'purchases.txt');
define('FILE_CHEATSHEET', FOLDER_DATA.'myCheatSheet.txt');
define('NEXTLINE',"\n\r");
define('APPEND_FILE','a');
define('WRITE_FILE','w');
define('READ_FILE','r');
define('MONEY_SIGN', '$');
//for css url argument
define('ARGU_PRINT',"print");
define('ARGU_COLOR',"color");

//constant for advertisment who pays us more
define('HIGH_ADV_PAYER', IMG_ADV_SAMOSE);

//Website pages
define('HOME_PAGE', 'index.php');
define('BUYING_PAGE', 'buying.php');
define('ORDER_PAGE', 'order.php');
define('REGISTER_PAGE', 'register.php');
define('BUY_PAGE', 'buy.php');
define('PURCHASES_PAGE', 'purchases.php');

//CopyRight name
define('COPYRIGHT_NAME', 'GurPreet SaiNi (1911343)');

//turn debug true if you are modifying code else keep it false
define('DEBUG', false);
//define('DEBUG', true);
define('FILE_LOGS', FOLDER_DATA.'logsFile.txt');

//constants for Minumum and maximum for forms
define('FORM_MAX_PROD_CODE',12);
define('FORM_MAX_FNAME',20);
define('FORM_MAX_LNAME',20);
define('FORM_MAX_CITY',8);
define('FORM_MAX_COMMENT',200);
define('FORM_MAX_PRICE',10000);
define('FORM_MAX_QUANTITY',99);
define('FORM_MIN_QUANTITY',1);
define('FORM_LOCAL_TAX_PER', 15.2);     //updated tax as mentioned in project 3
define('FORM_NUMS_AFTER_DECIMAL', 2);

//constant for our script file
define('FOLDER_SCRIPT', 'SCRIPT/');
define('FILE_SCRIPT_PURCHASES', FOLDER_SCRIPT.'searchPurchases.js');

//Global Variables
$productCode = "";
$firstName = "";
$lastName = "";
$customerCity = "";
$comment = "";
$price = "";
$quantity = "";

$errorProductCode = "";
$errorFirstName = "";
$errorLastName = "";
$errorCustomerCity = "";
$errorComment = "";
$errorPrice = "";
$errorQuantity = "";

//for login stuff
$currentCustomer = "";
$errorUserName = "";
$errorPassword = "";
$loginFailed = "";

//for register stuff
$address = "";
$city = "";
$province = "";
$postalCode = "";
$userName = "";
$password = "";

$errorAddress = "";
$errorCity = "";
$errorProvince = "";
$errorPostalCode = "";
//this and some other we already have for other stuff
//$errorUserName = "";
//$errorPassword = "";

$registerOrUpdate = "Register";

//for css with URL parameters
$arguBackground = "";
$arguOpacity = "";
$arguColor = array("red"=>"", "orange"=>"", "green"=>"");

//project part 3 variables starts here
//constants for our files which contains plural class

define("CLASS_CUSTOMERS", 'customers.php');
define("CLASS_PRODUCTS", 'products.php');
define("CLASS_PURCHASES", 'purchases.php');

//we can remove require of singular classes becuase we already import/require_once inside plural classes
//require_once CLASS_CUSTOMER;
require_once CLASS_CUSTOMERS;
//require_once CLASS_PRODUCT;
require_once CLASS_PRODUCTS;
//require_once CLASS_PURCHASE;
require_once CLASS_PURCHASES;


/**Will generage header part of website page 
 * @Param $title the title for your webpage */
function createPageHeader($title){
    //To make connection Secure we only use HTTPS and will redirect to HTTPS if it is http
    if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on"){
        header("Location: https://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }
    //type of our document
    header('Content-Type: text/html; charset=UTF-8');
    //to avoid using browser cache
    header("Expires: Thu, 14 May 1998 08:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");
    //to set error/exception handler
    handleAllErrors();
    session_start();
    global $arguBackground;
    
    //will check if its a form for update or register
    if(strtolower($title) == "register" && isset($_SESSION["currentCustomer"])){
        $title = "Update";
    }
    ?>
    <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <link rel="stylesheet" type="text/css" href="<?php echo FILE_CSS ?>">
                <script language="javascript" type="text/javascript" src="<?php echo FILE_SCRIPT_PURCHASES; ?>" ></script>
                <title><?php echo "$title | Classic Restaurant"; ?></title>
            </head>
            <body class="bg-color-lightcyan <?php echo $arguBackground ?>">
                <h1 class='website-title'>Classic Restaurant</h1>
    <?php
        createLogo();
        createNavigationMenu();
        //will show only if its not register page
        if(strtolower($title) != "register"){
            createLoginLogoutForm();
        }
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
    global $arguOpacity;
    ?>
        <img class="logo-style <?php echo $arguOpacity; ?>" src="<?php echo IMG_LOGO ?>" alt="LOGO image"/>
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
                <li><a href="<?php echo BUY_PAGE; ?>">Buy</a></li>
                <li><a href="<?php echo PURCHASES_PAGE; ?>">Purchases</a></li>
                <?php if(isset($_SESSION["currentCustomer"])){ ?>
                    <li><a href="<?php echo REGISTER_PAGE; ?>">Account</a></li>
                <?php } ?>
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
        <img class='adv <?php echo $imgClass ?>' src="<?php echo $adv[0] ?>" alt='advertisment image'/>
    <?php
}

/**Will generate html to create buying form*/
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
    
    //will check if submit button is clicked or not (if clicked then we do validation of fields)
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
        }
        //this does not allow accents for french name
//        else if(!ctype_alpha($firstName)){         //check if firstName contains only alphabets
//            $errorFirstName = "First name should only contains alpha characters.";
//        }
        
        #Validate Last Name
        if($lastName == ''){
            $errorLastName = "Last name cannot be empty.";
        }else if(mb_strlen($lastName) > FORM_MAX_LNAME){
            $errorLastName = "Last name cannot contain more than ".FORM_MAX_LNAME." characters.";
        }
        //this does not allow accents for french name
//        else if(!ctype_alpha($lastName)){
//            $errorLastName = "Last name should only contains alpha characters.";
//        }
        
        #Validate City
        if($customerCity == ''){
            $errorCustomerCity = "Customer cannot be empty.";
        }else if(mb_strlen($customerCity) > FORM_MAX_CITY){
            $errorCustomerCity = "Customer city cannot contain more than ".FORM_MAX_CITY." characters.";
        }
        //this does not allow accents for french name
//        else if(!ctype_alpha($customerCity)){
//            $errorCustomerCity = "Customer city should only contains alpha characters.";
//        }
        
        #Validate comment
        if(mb_strlen($comment) > FORM_MAX_COMMENT){
            $errorComment = "Comment cannot contain more than ".FORM_MAX_COMMENT." characters.";
        }
        
        #Validate Price
        if($price == ""){
            $errorPrice = "Price cannot be empty and should be in between 0$ and ".FORM_MAX_PRICE."$.";
        }else if(!is_numeric($price)){      //if its only numbers 0-9 and contain decimal points
            $errorPrice = "Price can only contains 0-9 digits and can have decimal numbers.";
        }else if($price < 0 || $price > FORM_MAX_PRICE){
            $errorPrice = "Price should be between 0$ and ".FORM_MAX_PRICE."$.";
        }
        
        #Validate Quantity
        if($quantity == ""){
            $errorQuantity = "Quantity cannot be empty and should be in between 1 and ".FORM_MAX_QUANTITY.".";
        }else if(!ctype_digit($quantity)){      //if its only digits without decimal point
            $errorQuantity = "Quantity should be between 1 and ".FORM_MAX_QUANTITY." and without any decimal points.";
        }else if($quantity < 1 || $quantity > FORM_MAX_QUANTITY){
            $errorQuantity = "Quantity should be between 1 and ".FORM_MAX_QUANTITY.".";
        }
        
        #######
        #If all validation is successful then continue to create array of all data
        if($errorProductCode == "" && $errorFirstName == "" && $errorLastName == "" && $errorCustomerCity == "" && $errorComment == "" && $errorPrice == "" && $errorQuantity == ""){
            
            $subTotal = round($price * $quantity, FORM_NUMS_AFTER_DECIMAL);
            $taxesAmount = round($subTotal * (FORM_LOCAL_TAX_PER/100),FORM_NUMS_AFTER_DECIMAL);
            $grandTotal = $subTotal + $taxesAmount;
            
            //array creation of all information
            $anOrder = array("productCode"=>$productCode, "firstName"=>$firstName, "lastName"=>$lastName, "customerCity"=>$customerCity,
                        "comment"=>$comment, "price"=>$price, "quantity"=>$quantity, "subTotal"=>$subTotal, "taxesAmount"=>$taxesAmount, "grandTotal"=>$grandTotal);
            
            //creation of json string to save in a file
            $jsonString = json_encode($anOrder);
            
            //Save it in the file
            $myFileHandler = fopen(FILE_PURCHASE, APPEND_FILE) or die("This file could not be opened");
            fwrite($myFileHandler, $jsonString.NEXTLINE);
            fclose($myFileHandler);
            
            //to clear all the text boxes
            $productCode = "";
            $firstName = "";
            $lastName = "";
            $customerCity = "";
            $comment = "";
            $price = "";
            $quantity = "";
            
            //confirmation for the order
            ?>
                <script>alert("Your order is confirmed");</script>
            <?php
        }
    }
    
    //to clear all the fields in the form   
    //now its not using but before i use a submit button to reset/clear all the fields 
    if(isset($_POST['reset'])){
        $productCode = "";
        $firstName = "";
        $lastName = "";
        $customerCity = "";
        $comment = "";
        $price = "";
        $quantity = "";

        $errorProductCode = "";
        $errorFirstName = "";
        $errorLastName = "";
        $errorCustomerCity = "";
        $errorComment = "";
        $errorPrice = "";
        $errorQuantity = "";
    }
    
    ?>
        <div class="buying-form">
            <h2>Buying Form</h2>
            <form action='<?php echo BUYING_PAGE ?>' method='POST'>
                <p>
                    <label>Product Code : </label><br/>
                    <input type="text" name="productCode" value ="<?php echo $productCode?>"/>
                    <label class="error-code-label">* <?php echo $errorProductCode ?></label>
                </p>
                <p>
                    <label>Customer First Name : </label><br/>
                    <input type="text" name="firstName" value="<?php echo $firstName ?>"/>
                    <label class="error-code-label">* <?php echo $errorFirstName ?></label>
                </p>
                <p>
                    <label>Customer Last Name : </label><br/>
                    <input type="text" name="lastName" value="<?php echo $lastName ?>"/>
                    <label class="error-code-label">* <?php echo $errorLastName ?></label>
                </p>
                <p>
                    <label>Customer City : </label><br/>
                    <input type="text" name="customerCity" value="<?php echo $customerCity ?>"/>
                    <label class="error-code-label">* <?php echo $errorCustomerCity ?></label>
                </p>
                <p>
                    <label>Comments : </label><br/>
                    <textarea name="comment" rows="3" cols="30" maxlength="200"><?php echo $comment ?></textarea>
                    <label class="error-code-label"><?php echo $errorComment ?></label>
                </p>
                <p>
                    <label>Price : </label><br/>
                    <input type="number" name="price" step=".01" value="<?php echo $price ?>"/>
                    <label class="error-code-label">* <?php echo $errorPrice ?></label>
                </p>
                <p>
                    <label>Quantity : </label><br/>
                    <input type="number" name="quantity" value="<?php echo $quantity ?>"/>
                    <label class="error-code-label">* <?php echo $errorQuantity ?></label>
                </p>
                <p class="button-section">
                    <input type="submit" value='Submit' name="save" class="button"/>
                    <!--Here type= reset was not working because we use value attribute in inputs so i just reload the page-->
                    <input type="reset" value='Clear' onclick="window.location.href = window.location.href" name="reset" class="button"/>
                </p>
            </form>
        </div>
    <?php
}


/** Will generate orders table and fill the information with specified file */
function createOrdersTable(){
    global $arguColor;
    $thisColor = "";
    
    // to check if file exist or no
    if(file_exists(FILE_PURCHASE)){
        $myFileHandler = fopen(FILE_PURCHASE, READ_FILE) or die("File does not exists!");
        ?>
                <h2>Your all orders</h2>
                <table>
                    <tr>
                        <th>Product ID</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>City</th>
                        <th>Comments</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Taxes</th>
                        <th>Grand total</th>
                    </tr>
        <?php
        //to read file line by line until end of file
        while(!feof($myFileHandler)){
            $anOrder = fgets($myFileHandler) or die("");
            //to check if the line we read is empty or not
            if(trim($anOrder) != ""){
                $dataObj = json_decode($anOrder);
                //to check if we received parameter color in URL
                if($arguColor["red"] != ""){
                    if($dataObj->subTotal < 100){
                        $thisColor = $arguColor["red"];
                    }elseif($dataObj->subTotal >= 100 && $dataObj->subTotal <= 999.99 ){
                        $thisColor = $arguColor["orange"];
                    }elseif($dataObj->subTotal >= 1000 ){
                        $thisColor = $arguColor["green"];
                    }
                }
                ?>
                    <tr>
                        <td><?php echo $dataObj->productCode ?></td>
                        <td><?php echo $dataObj->firstName ?></td>
                        <td><?php echo $dataObj->lastName ?></td>
                        <td><?php echo $dataObj->customerCity ?></td>
                        <td><?php echo $dataObj->comment ?></td>
                        <td><?php echo $dataObj->price.MONEY_SIGN  ?></td>
                        <td><?php echo $dataObj->quantity ?></td>
                        <td class="<?php echo $thisColor ?>"><?php echo $dataObj->subTotal.MONEY_SIGN ?></td>
                        <td><?php echo $dataObj->taxesAmount.MONEY_SIGN ?></td>
                        <td><?php echo $dataObj->grandTotal.MONEY_SIGN ?></td>
                    </tr>
                <?php
            }
        }
        ?>
                </table>
        <?php
        
    }else{
        ?>
            <p class="error-file">Required File does not exists!! </p>;
        <?php
    }
}

/** will check parameters in URL and perform action accordingly */
function checkUrlParameters(){
    global $arguBackground;
    global $arguOpacity;
    global $arguColor;
    
    // if we received any argument in URL we will use different CSS
    if(isset($_GET["command"])){
        $cmd = htmlspecialchars($_GET["command"]);
        
        if($cmd == ARGU_PRINT){
            $arguBackground = "arguPrint-background";
            $arguOpacity = "arguPrint-opacity";
        }else if($cmd == ARGU_COLOR){
            $arguColor = array("red"=>"arguColor-red", "orange"=>"arguColor-orange", "green"=>"arguColor-green");
        }
        
    }
}


/** this called when PHP function fails */
function manageError($errorNumber, $errorString, $errorFile, $errorLine){
    //details info to create error message
    $date = new DateTime(); 
    $now = $date->format('Y-m-d H:i:s.u');
    $browser = $_SERVER["HTTP_USER_AGENT"];
    $ErrorInfo = "An ERROR occured in the file $errorFile, on line $errorLine. "
            . "Error: $errorNumber : $errorString, at $now with browser: $browser.";
    
    if(DEBUG==false){
        //Message for end-user
        echo "An ERROR occured on the website. Please consult the log for more details.";
        
        //here we need to save error in a file
        $myFileHandler = fopen(FILE_LOGS, APPEND_FILE) or die("Writing ERROR in log file Failed!");
        fwrite($myFileHandler, $ErrorInfo.NEXTLINE);
        fclose($myFileHandler);
    }else{
        //detail info for the developers
        echo $ErrorInfo;
    }
    die();
}

/** this called when user-defined function fails */
function manageExceptions($error){
    //details info to create exception message
    $date = new DateTime(); 
    $now = $date->format('Y-m-d H:i:s.u');
    $browser = $_SERVER["HTTP_USER_AGENT"];
    $ExcepInfo = "An EXCEPTION occured in the file ". $error->getFile()." on line ".$error->getLine()
            . ", Error: ".$error->getMessage()." at $now with browser $browser.";
            
    if(DEBUG==false){
        //Message for end-user
        echo "An EXCEPTION occured on the website. Please consult the log for more details.";
        
        //here we need to save error in a file
        $myFileHandler = fopen(FILE_LOGS, APPEND_FILE) or die("Writing EXCEPTION in log file Failed!");
        fwrite($myFileHandler, $ExcepInfo.NEXTLINE);
        fclose($myFileHandler);
    }else{
        //detail info for the developers
        echo $ExcepInfo;
    }
    die();
}

/** This function will set All the error in a log file */
function handleAllErrors(){
    set_error_handler("manageError");
    set_exception_handler("manageExceptions");
}

//------------------------------------------------------------------------project 3rd
/**
 * will generate HTML for login and logout form
 */
function createLoginLogoutForm(){
    global $currentCustomer;
    global $errorUserName;
    global $errorPassword;
    global $loginFailed;
    
    if(isset($_POST["login"])){
        $userName = htmlspecialchars(trim($_POST['userName']));
        $password = htmlspecialchars(trim($_POST['password']));
        
        if($userName == ""){
            $errorUserName = "UserName cannot be empty.";
        }
        if($password == ""){
            $errorPassword = "Password cannot be empty.";
        }
        
        if($errorUserName == "" && $errorPassword == ""){
            //creating object 
            $currentCustomer = new customer();
            //validating username and password
            if($currentCustomer->login($userName, $password) != null){
                //saving our customer uuid inside global session variable
                //this one is just in case thing actually we gonna use the bottom one
                $_SESSION['customer_uuid'] = $currentCustomer->getCustomer_uuid();
                
                //here just creating object for customer inside global session variable
                //which we going to use on all the pages 
                $_SESSION['currentCustomer'] = new customer();
                $_SESSION['currentCustomer']->load($currentCustomer->getCustomer_uuid());
                
                //to load all things on our navigation (account)
                header("Refresh:0");
            }else{
                $loginFailed = "Incorrect Username and password";
            }
        }
    }else if(isset($_POST["logout"])){
        //will delete the customer_uuid from session variable
        //session_destroy();    //destroy is not working it brokes the code 
        //this will realise all the variables under session global variable
        session_unset();
        
        //this will refresh the page
        //we need this because if a customer logout in account.php then we need to clear all info
        header("Refresh:0");
        exit();
    }
    
    //this will decide whether to print login form or logout form
    if(!isset($_SESSION['customer_uuid'])){ 
        ?>
        <div class="login-logout-form">
            <h2>Login Form</h2>
            <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                <p>
                    <label>Username : </label><br/>
                    <input type="text" name="userName"/>
                    <label class="error-code-label">* <?php echo $errorUserName ?></label>
                </p>
                <p>
                    <label>Password : </label><br/>
                    <input type="password" name="password"/>
                    <label class="error-code-label">* <?php echo $errorPassword ?></label>
                </p>
                <p class="button-section">
                    <label class="error-code-label"> <?php echo $loginFailed ?></label>
                    <input type="submit" value='Login' name="login" class="button"/>
                </p>
                <p>
                    Need a user account ? <a href="<?php echo REGISTER_PAGE ?>">Register</a>
                </p>
            </form>
        </div>
        <?php
    }else{
        ?>
        <div class="login-logout-form logout-form">
            <h2>Welcome <span class="welcome-color"><?php echo $_SESSION['currentCustomer']->getFirstName()." ".$_SESSION['currentCustomer']->getLastName() ?></span></h2>
            <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                <p class="button-section">
                    <input type="submit" value='Logout' name="logout" class="button"/>
                </p>
            </form>
        </div>
        <?php
    }
}

/**
 * will generate HTML for register form also we used it for Update
 */
function createRegisterUpdateForm(){
    global $firstName;
    global $lastName;
    global $address;
    global $city;
    global $province;
    global $postalCode;
    global $userName;
    global $password;
    
    global $errorFirstName;
    global $errorLastName;
    global $errorAddress;
    global $errorCity;
    global $errorProvince;
    global $errorPostalCode;
    global $errorUserName;
    global $errorPassword;
    
    global $currentCustomer;
    
    global $registerOrUpdate;
    
    //will choose whether its a form for update or a new register
    if(isset($_SESSION["currentCustomer"])){ 
        $registerOrUpdate = "Update"; 
        
        $currentCustomer = new customer();
        $currentCustomer->load(htmlspecialchars($_SESSION["currentCustomer"]->getCustomer_uuid()));
        
        $firstName = $currentCustomer->getFirstName();
        $lastName = $currentCustomer->getLastName();
        $address = $currentCustomer->getAddress();
        $city = $currentCustomer->getCity();
        $province = $currentCustomer->getProvince();
        $postalCode = $currentCustomer->getPostalCode();
        $userName = $currentCustomer->getUserName();
        
        //we don't need this here because we show on each page except Register
//        createLoginLogoutForm();
    }
    else { 
        $registerOrUpdate = "Register"; 
        $currentCustomer = new customer();
    }
    
    if(isset($_POST["register"])){
        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $lastName = htmlspecialchars(trim($_POST['lastName']));
        $address = htmlspecialchars(trim($_POST['address']));
        $city = htmlspecialchars(trim($_POST['city']));
        $province = htmlspecialchars(trim($_POST['province']));
        $postalCode = htmlspecialchars(trim($_POST['postalCode']));
        $userName = htmlspecialchars(trim($_POST['userName']));
        $password = htmlspecialchars(trim($_POST['password']));
        
        
        $errorFirstName = $currentCustomer->setFirstName($firstName);
        $errorLastName = $currentCustomer->setLastName($lastName);
        $errorAddress = $currentCustomer->setAddress($address);
        $errorCity = $currentCustomer->setCity($city);
        $errorProvince = $currentCustomer->setProvince($province);
        $errorPostalCode= $currentCustomer->setPostalCode($postalCode);
        $errorUserName = $currentCustomer->setUserName($userName);
        $errorPassword = $currentCustomer->setPassword($password);
        
        if($errorFirstName == "" && $errorLastName == "" && $errorAddress == "" && $errorCity == "" && $errorProvince == "" && $errorPostalCode == "" && $errorUserName == "" && $errorPassword == ""){
            
            //saving the current customer inside the database (will check if its update or insert)
            $currentCustomer->save();
            
            //clear the variables
            $firstName = "";
            $lastName = "";
            $address = "";
            $city = "";
            $province = "";
            $postalCode = "";
            $userName = "";
            $password = "";
            
            //confirmation for the user that account has been created or updated
            if(isset($_SESSION["currentCustomer"])){
                //to update even in our current website variable
                $_SESSION["currentCustomer"]->load($currentCustomer->getCustomer_uuid());
                ?>
                <script>alert("Your account information updated successfully!");</script>
                <?php
            }else{
                ?>
                <script>alert("Your account is created successfully!");</script>
                <?php
            }
        }    
    }
    
    ?>
                <div class="buying-form <?php if(!isset($_SESSION["currentCustomer"])){echo "register-form";} ?>">
            <h2><?php echo $registerOrUpdate; ?> - Form</h2>
            <form action='<?php echo REGISTER_PAGE ?>' method='POST'>
                <p>
                    <label>First Name : </label><br/>
                    <input type="text" name="firstName" value="<?php echo $firstName ?>"/>
                    <label class="error-code-label">* <?php echo $errorFirstName ?></label>
                </p>
                <p>
                    <label>Last Name : </label><br/>
                    <input type="text" name="lastName" value="<?php echo $lastName ?>"/>
                    <label class="error-code-label">* <?php echo $errorLastName ?></label>
                </p>
                <p>
                    <label>Address : </label><br/>
                    <input type="text" name="address" value="<?php echo $address ?>"/>
                    <label class="error-code-label">* <?php echo $errorAddress ?></label>
                </p>
                <p>
                    <label>City : </label><br/>
                    <input type="text" name="city" value="<?php echo $city ?>"/>
                    <label class="error-code-label">* <?php echo $errorCity ?></label>
                </p>
                <p>
                    <label>Province : </label><br/>
                    <input type="text" name="province" value="<?php echo $province ?>"/>
                    <label class="error-code-label">* <?php echo $errorProvince ?></label>
                </p>
                <p>
                    <label>Postal Code : </label><br/>
                    <input type="text" name="postalCode" value="<?php echo $postalCode ?>"/>
                    <label class="error-code-label">* <?php echo $errorPostalCode ?></label>
                </p>
                <p>
                    <label>Username : </label><br/>
                    <input type="text" name="userName" value="<?php echo $userName ?>"/>
                    <label class="error-code-label">* <?php echo $errorUserName ?></label>
                </p>
                <p>
                    <label>Password : </label><br/>
                    <input type="password" name="password" value="<?php echo $password ?>"/>
                    <label class="error-code-label">* <?php echo $errorPassword ?></label>
                </p>
                <p class="button-section">
                    <input type="submit" value='<?php echo $registerOrUpdate; ?>' name="register" class="button"/>
                    <!--Here type= reset was not working because we use value attribute in inputs so i just reload the page-->
                    <?php
                    //this will show clear button only if it is a register and not appear on update
                    if(!isset($_SESSION["currentCustomer"])){
                        ?>
                        <input type="reset" value='Clear' onclick="window.location.href = window.location.href" name="reset" class="button"/>
                        <?php
                    }
                    ?>
                </p>
            </form>
        </div>
    <?php
}

/**
 * will generate HTML for BUY form
 */
function createBuyForm(){
    global $productCode;
    global $comment;
    global $quantity;
    
    global $errorProductCode;
    global $errorComment;
    global $errorQuantity;
    if(!isset($_SESSION['customer_uuid'])){ 
        ?>
                <script>alert("In order to access this page, You need to login first!!");</script>
        <?php
    }else{
        //for our option list inside html 
        $products = new products();
        
        //will validate if its a valid purchase //meaning validate all fields
        if(isset($_POST["buy"])){
            $productCode = htmlspecialchars(trim($_POST['productCode']));
            $comment = htmlspecialchars(trim($_POST['comment']));
            $quantity = htmlspecialchars(trim($_POST['quantity']));
            
            //to access the price of our product
            $product = new product();
            //to create this new purchase
            $aPurchase = new purchase();
            
            if($productCode == "-1"){
                $errorProductCode = "You must choose a product to proceed your purchase order.";
            }else{
                if($product->load($productCode)){
                    $aPurchase->setProduct_uuid($product->getProduct_uuid());
                }
            }
            //we gonna get error msg if these two are not valid
            $errorComment = $aPurchase->setComment($comment);
            $errorQuantity = $aPurchase->setSoldQuantity($quantity);
            
            //checking if we got any error and if not than complete this purchase
            if($errorProductCode == "" && $errorComment == "" && $errorQuantity == ""){
                
                //getting customer_uuid from global variable 
                $aPurchase->setCustomer_uuid(htmlspecialchars($_SESSION["customer_uuid"]));
                
                $price = $product->getPrice();
                $aPurchase->setSalePrice($price);
                //we are rounding up inside the class method means method will just save only 2 digits after decimal
                $aPurchase->setSubTotal($price * $quantity);
                $aPurchase->setTaxesAmount($aPurchase->getSubTotal() * FORM_LOCAL_TAX_PER / 100);
                $aPurchase->setGrandTotal($aPurchase->getSubTotal() + $aPurchase->getTaxesAmount());
                
                $productCode = "";
                $comment = "";
                $quantity = "";
                
                //if save succeed redirect to purchases page
                if($aPurchase->save()){                    
                    header("Location: https://".$_SERVER['HTTP_HOST']."/".explode('/', $_SERVER['REQUEST_URI'])[1]."/".PURCHASES_PAGE);
                    exit();
                }else{
                    ?>
                    <script>alert("Something went wrong, Your order is not placed!!");</script>    
                    <?php
                }
            }
        }
        ?>
            <div class="buying-form buy-form">
                <h2>Buy Form</h2>
                <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                    <p>
                    <label>Product Code : </label><br/>
                    <select name="productCode" id="productCode">
                        <option value="-1">
                            -- Choose an Option --
                        </option>
                        <?php foreach ($products->items as $aProduct) { ?>
                        <option value="<?php echo $aProduct->getProduct_uuid(); ?>" <?php if($productCode == $aProduct->getProduct_uuid()){echo "selected";} ?>>
                            <?php echo $aProduct->getProductCode()." - ".$aProduct->getDescription()." (".$aProduct->getPrice().")"; ?>
                        </option>
                        <?php } ?>
                    </select>
                    <label class="error-code-label">* <?php echo $errorProductCode ?></label>
                    </p>
                    <p>
                        <label>Comments : </label><br/>
                        <textarea name="comment" rows="3" cols="30" maxlength="200"><?php echo $comment ?></textarea>
                        <label class="error-code-label"><?php echo $errorComment ?></label>
                    </p>
                    <p>
                        <label>Quantity : </label><br/>
                        <input type="number" name="quantity" value="<?php echo $quantity ?>"/>
                        <label class="error-code-label">* <?php echo $errorQuantity ?></label>
                    </p>
                    <p class="button-section">
                        <input type="submit" value='Buy' name="buy" class="button"/>
                        <!--Here type= reset was not working because we use value attribute in inputs so i just reload the page-->
                        <input type="reset" value='Clear' onclick="window.location.href = window.location.href" name="reset" class="button"/>
                    </p>
                </form>
            </div>
        <?php
    }
}

/**
 * will generate HTML for Purchase Search Form
 */
function createPurchaseSearchForm(){    
    //will show the table if user is connected and hit's the search button
    if(!isset($_SESSION['customer_uuid'])){ 
        ?>
                <script>alert("In order to access this page, You need to login first!!");</script>
        <?php
    }else{
        ?>
        <div class="buying-form buy-form">
            <h2>Purchase Search</h2>
                <p>
                    <label>Show purchases made on this date or later:   </label>
                    <input type="text" name="searchDate" id="searchDate" placeholder="yyyy-mm-dd (optional)"/>
                    <input type="hidden" id="customer_uuid" value="<?php echo $_SESSION['customer_uuid'] ?>"/>
                    <p class="button-section">
                        <input type="button" value='Search' name="search" class="button" onclick="searchPurchases();"/>
                    </p>
                </p>
        </div>
        <?php
    }
    
    //to delete a purchase of a customer
    if(isset($_POST['delete'])){
        $purchase_uuid = htmlspecialchars($_POST['purchase_uuid']);
        
        $aPurchase = new purchase($purchase_uuid);
        
        if($aPurchase->delete()){
                //here we will load our purchases again once our website is fully loaded because
                //our div container for the table is after this function call
            ?>
                <script>window.onload = function () { searchPurchases(); };</script>
            <?php   
        }
    }
}
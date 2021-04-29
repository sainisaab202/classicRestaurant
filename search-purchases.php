<?php
#DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)  20/04/2021  Created search-purchases.php file 
#                               this will generate html code for purchases as a table
#Gurpreet(1911343)  22/04/2021  Added date to our search of customer so will get result after that date
#Gurpreet(1911343)  28/04/2021  Modified and commented where we create aCustomer and aProduct
#                               Instead of that we already have a customer object and a product object inside a purchase


#--------------------------------------------------------------
#constants Declaration
define('PHP_FOLDER','./PHP/');
define('CLASS_CUSTOMER',PHP_FOLDER.'customer.php');
define('CLASS_PURCHASES',PHP_FOLDER.'purchases.php');
define('CLASS_PRODUCT',PHP_FOLDER.'product.php');

define('MONEY_SIGN', '$');

#import the class that we going to use
require_once CLASS_CUSTOMER;
require_once CLASS_PURCHASES; 
require_once CLASS_PRODUCT; 

//just informing that this file contain only plain text
header('Content-type: text/plain');

//this thing works but i have to check this by passing a date as well and 
//we don't know what does he ment by reduce the calls to database also

if(isset($_POST['searchDate'])){
    $searchedDate = htmlspecialchars($_POST['searchDate']);
    $customer_uuid = htmlspecialchars($_POST['customer_uuid']);
    //here we need to plug date as well for now just to check if it works or no
    $purchases = new purchases($customer_uuid, $searchedDate);
    
    //now we don't need to create customer here because we already have customer object inside a purchase
//    $aCustomer = new customer();
//    $aCustomer->load($customer_uuid);
    ?>
    <h2>Your Purchases</h2>
    <table>
        <tr>
            <th>Delete</th>
            <th>Product code</th>
            <th>First name</th>
            <th>Last name</th>
            <th>City</th>
            <th>Comments</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Taxes</th>
            <th>Grand total</th>
        </tr>
        <?php
        foreach ($purchases->items as $aPurchase){
            
            //Also here we don't need to create product because we already have it in our purchase
//            $aproduct = new product();
//            $aproduct->load($aPurchase->getProduct_uuid());
            ?>
        <tr>
            <td>
                <form action="purchases.php" method="post">
                    <input type="submit" name="delete" value="Delete">
                    <input type="hidden" name="purchase_uuid" value="<?php echo $aPurchase->getPurchase_uuid(); ?>">
                </form>
            </td>
            <td><?php echo $aPurchase->product->getProductCode(); ?></td>
            <td><?php echo $aPurchase->customer->getFirstName(); ?></td>
            <td><?php echo $aPurchase->customer->getLastName(); ?></td>
            <td><?php echo $aPurchase->customer->getCity(); ?></td>
            <td><?php echo $aPurchase->getComment(); ?></td>
            <td><?php echo $aPurchase->getSalePrice().MONEY_SIGN;  ?></td>
            <td><?php echo $aPurchase->getSoldQuantity(); ?></td>
            <td><?php echo $aPurchase->getSubTotal().MONEY_SIGN ?></td>
            <td><?php echo $aPurchase->getTaxesAmount().MONEY_SIGN ?></td>
            <td><?php echo $aPurchase->getGrandTotal().MONEY_SIGN ?></td>
        </tr>
            <?php
        }
    ?></table><?php
}
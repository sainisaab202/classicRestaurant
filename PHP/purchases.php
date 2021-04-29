<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   18/04/2021  created class purchases which inherits from collection
#Gurpreet(1911343)   20/04/2021  added 3 more fields when creating a purchase subTotal, taxesAmount, grandTotal
#Gurpreet(1911343)   22/04/2021  added date feature in the constructor so we can search by date as well
#Gurpreet(1911343)   28/04/2021  added customer and product object to the each purchase 

//for our database
require_once 'connection.php';
//To use our collection class
require_once 'collection.php';
//because we use purchase class //as constant
define("CLASS_PURCHASE", 'purchase.php');
require_once CLASS_PURCHASE;


class purchases extends collection{
    
    //this will take all the stuff from database and put inside our collection
    function __construct($customer_uuid="", $aDate="") {
        global $connection;
        
        $sqlQuery = "CALL purchases_select();";
        
        if($customer_uuid != ""){             //here we passing '' to procedure because it works without date
            $sqlQuery = "CALL purchases_filterCustomer(:customer_uuid, '');";
        }
        if($customer_uuid != "" && $aDate != ""){   //and here is with date
            $sqlQuery = "CALL purchases_filterCustomer(:customer_uuid, :aDate);";
        }
        
        $PDOStatement = $connection->prepare($sqlQuery);
        
        if($customer_uuid != ""){
            $PDOStatement->bindParam(":customer_uuid", $customer_uuid);
            if($aDate != ""){
               $PDOStatement->bindParam(":aDate", $aDate);
            }  
        }
        
        $PDOStatement->execute();
        
        while($row = $PDOStatement->fetch()){
            //creating object of customer
            $aCustomer = new customer($row["customer_uuid"], $row["customer_firstName"], $row["customer_lastName"], 
                    $row["customer_address"], $row["customer_city"], $row["customer_province"], $row["customer_postalCode"], 
                    $row["customer_userName"], $row["customer_password"]);
            
            //creating object of product
            $aProduct = new product($row["product_uuid"], $row["product_code"], $row["product_description"], 
                     $row["product_price"], $row["product_costPrice"]);
            
            //creating a purchase which also includes aCustomer and aProduct object
            $aPurchase = new purchase($row["purchase_uuid"], $row["customer_uuid"], $row["product_uuid"],
                    $row["purchase_soldQuantity"], $row["purchase_salePrice"], $row["purchase_comment"], 
                        $row["purchase_created"], $row["purchase_lastModified"],
                    $row["purchase_subTotal"], $row["purchase_taxesAmount"], $row["purchase_grandTotal"], 
                    $aCustomer, $aProduct);
            
            //adding the purchase in our collection
            $this->add($row["purchase_uuid"], $aPurchase);
        }
    }
}
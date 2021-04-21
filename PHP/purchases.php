<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   18/04/2021  created class purchases which inherits from collection
#Gurpreet(1911343)   20/04/2021  added 3 more fields when creating a purchase subTotal, taxesAmount, grandTotal

//for our database
require_once 'connection.php';
//To use our collection class
require_once 'collection.php';
//because we use purchase class //as constant
define("CLASS_PURCHASE", 'purchase.php');
require_once CLASS_PURCHASE;


class purchases extends collection{
    
    //this will take all the stuff from database and put inside our collection
    function __construct($customer_uuid="") {
        global $connection;
        
        $sqlQuery = "CALL purchases_select();";
        
        if($customer_uuid != ""){             //here we passing '' to procedure because it works without date
            $sqlQuery = "CALL purchases_filterCustomer(:customer_uuid, '');";
        }
        
        $PDOStatement = $connection->prepare($sqlQuery);
        
        if($customer_uuid != ""){
            $PDOStatement->bindParam(":customer_uuid", $customer_uuid);
        }
        
        $PDOStatement->execute();
        
        while($row = $PDOStatement->fetch()){
            $aPurchase = new purchase($row["purchase_uuid"], $row["customer_uuid"], $row["product_uuid"],
                    $row["purchase_soldQuantity"], $row["purchase_salePrice"], $row["purchase_comment"], 
                        $row["purchase_created"], $row["purchase_lastModified"],
                    $row["purchase_subTotal"], $row["purchase_taxesAmount"], $row["purchase_grandTotal"]);
            
            $this->add($row["purchase_uuid"], $aPurchase);
        }
    }
}
<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   18/04/2021  created class products which inherits from collection

//for our database
require_once 'connection.php';
//To use our collection class
require_once 'collection.php';
//because we use product class //as constant
define("CLASS_PRODUCT", 'product.php');

require_once CLASS_PRODUCT;


class products extends collection{
    
    //this will take all the stuff from database and put inside our collection
    function __construct() {
        global $connection;
        
        $sqlQuery = "CALL products_select();";
        
        $PDOStatement = $connection->prepare($sqlQuery);
        
        $PDOStatement->execute();
        
        while($row = $PDOStatement->fetch()){
            $aProduct = new product($row["product_uuid"], $row["product_code"], $row["product_description"],
                    $row["product_price"], $row["product_costPrice"], $row["product_created"], $row["product_lastModified"]);
            
            $this->add($row["product_uuid"], $aProduct);
        }
    }
}
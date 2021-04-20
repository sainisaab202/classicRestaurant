<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   18/04/2021  created class customers which inherits from collection

//for our database
require_once 'connection.php';
//To use our collection class
require_once 'collection.php';
//because we use customer class //as constant
define("CLASS_CUSTOMER", 'customer.php');

require_once CLASS_CUSTOMER;


class customers extends collection{
    
    //this will take all the stuff from database and put inside our collection
    function __construct() {
        global $connection;
        
        $sqlQuery = "CALL customers_select();";
        
        $PDOStatement = $connection->prepare($sqlQuery);
        
        $PDOStatement->execute();
        
        while($row = $PDOStatement->fetch()){
            $aCustomer = new customer($row["customer_uuid"], $row["customer_firstName"], $row["customer_lastName"],
                    $row["customer_address"], $row["customer_city"], $row["customer_province"], $row["customer_postalCode"],
                    $row["customer_userName"], $row["customer_password"], $row["customer_created"], $row["customer_lastModified"]);
            
            $this->add($row["customer_uuid"], $aCustomer);
        }
    }
}
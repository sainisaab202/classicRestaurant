<?php

##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   17/04/2021  created class purchase and constructor
#                                declared required constants, getters and setters
#Gurpreet(1911343)   18/04/2021  Created methods: load, save, delete
#Gurpreet(1911343)   20/04/2021  Change max_sold_quantity constant to 99 from 999
#                                Added new fields: subTotal, taxesAmount and GrandTotal
#                                Added new getters, setters and modify other methods




//constant for required files
//define('DB_CONNECTION', 'connection.php');
//we can not define it again because we already did it in customer.php
require_once DB_CONNECTION;

class purchase{
    //some constants
    const MAX_SOLD_QUANTITY = 99;
    const MAX_PRICE = 10000;
    const MAX_LENGTH_COMMENT = 200;
    const MAX_NUMS_AFTER_DECIMAL = 2;
    const MAX_LENGTH_UUID = 36;
    
    //private variables
    private $purchase_uuid="";
    private $customer_uuid="";
    private $product_uuid="";
    private $soldQuantity=0;
    private $salePrice=0.0;
    private $comment=null;
    private $created="";
    private $lastModified="";
    private $subTotal="";
    private $taxesAmount="";
    private $grandTotal="";
    
    /**
     * fully parameterized constructor use only when reading from the database
     */
    public function __construct($purchase_uuid="", $customer_uuid="", $product_uuid="", $soldQuantity="",
            $salePrice="", $comment="", $created="", $lastModified="", $subTotal="", $taxesAmount="", $grandTotal="") {
        if($purchase_uuid != ""){
            $this->setPurchase_uuid($purchase_uuid);
        }
        if($customer_uuid != ""){
            $this->setCustomer_uuid($customer_uuid);
        }
        if($product_uuid != ""){
            $this->setProduct_uuid($product_uuid);
        }
        if($soldQuantity != ""){
            echo $this->setSoldQuantity($soldQuantity);
        }
        if($salePrice != ""){
            $this->setSalePrice($salePrice);
        }
        if($comment != ""){
            $this->setComment($comment);
        }
        $this->created = $created;
        $this->lastModified = $lastModified;
        $this->subTotal = $subTotal;
        $this->taxesAmount = $taxesAmount;
        $this->grandTotal = $grandTotal;
    }
    
    //getters and setter for our private attributes
    //some private setters because we don't want to set it from outside the class
    private function setPurchase_uuid($purchase_uuid){
        if(mb_strlen($purchase_uuid) == self::MAX_LENGTH_UUID){
            $this->purchase_uuid = $purchase_uuid;
        }
    }
    
    //public getters and setters
    public function setCustomer_uuid($customer_uuid){
        if(mb_strlen($customer_uuid) == self::MAX_LENGTH_UUID){
            $this->customer_uuid = $customer_uuid;
        }
    }
    
    public function setProduct_uuid($product_uuid){
        if(mb_strlen($product_uuid) == self::MAX_LENGTH_UUID){
            $this->product_uuid = $product_uuid;
        }
    }
    
    public function getPurchase_uuid(){
        return $this->purchase_uuid;
    }
    
    public function getCustomer_uuid(){
        return $this->customer_uuid;
    }
    
    public function getproduct_uuid(){
        return $this->product_uuid;
    }
    
    public function setSoldQuantity($soldQuantity){
        if($soldQuantity == ""){
            return "Sold Quantity cannot be empty and should be in between 0 and ".self::MAX_SOLD_QUANTITY.".";
        }else if(!ctype_digit($soldQuantity)){      //if its only digits without decimal point
            return "Sold Quantity should be between 1 and ". self::MAX_SOLD_QUANTITY." and without any decimal points.";
        }else if($soldQuantity < 1 || $soldQuantity > self::MAX_SOLD_QUANTITY){
            return "Sold Quantity should be between 1 and ". self::MAX_SOLD_QUANTITY.".";
        }else{
            $this->soldQuantity = $soldQuantity;
            return "";
        }
    }
    
    public function getSoldQuantity(){
        return $this->soldQuantity;
    }
    
    public function setSalePrice($salePrice){
        if($salePrice == ""){
           return "Sale Price cannot be empty and should be in between 0$ and ". self::MAX_PRICE."$.";
        }else if(!is_numeric($salePrice)){      //if its only numbers 0-9 and contain decimal points
            return "Sale Price can only contains 0-9 digits and can have upto ". self::MAX_NUMS_AFTER_DECIMAL." decimal numbers.";
        }else if($salePrice < 0 || $salePrice > self::MAX_PRICE){
            return "Price should be between 0$ and ". self::MAX_PRICE."$.";
        }else{
            $this->salePrice = round($salePrice, self::MAX_NUMS_AFTER_DECIMAL);
            return "";
        }
    }
    
    public function getSalePrice(){
        return $this->salePrice;
    }
    
    public function setComment($comment){
        if($comment == ""){
            $this->comment = null;
           return "";
        }else if(mb_strlen($comment) > self::MAX_LENGTH_COMMENT){
            return "Comment cannot contain more than ". self::MAX_LENGTH_COMMENT." characters.";
        }else{
            $this->comment = $comment;
            return "";
        }
    }
    
    public function getComment(){
        return $this->comment;
    }
    
    public function getCreated(){
        return $this->created;
    }
    
    public function getLastModified(){
        return $this->lastModified;
    }
    
    public function setSubTotal($subTotal){
        $this->subTotal = round($subTotal, self::MAX_NUMS_AFTER_DECIMAL);
    }
    
    public function getSubTotal(){
        return $this->subTotal;
    }
    
    public function setTaxesAmount($taxesAmount){
        $this->taxesAmount = round($taxesAmount, self::MAX_NUMS_AFTER_DECIMAL);
    }
    
    public function getTaxesAmount(){
        return $this->taxesAmount;
    }
    
    public function setGrandTotal($grandTotal){
        $this->grandTotal = round($grandTotal, self::MAX_NUMS_AFTER_DECIMAL);
    }
    
    public function getGrandTotal(){
        return $this->grandTotal;
    }
    
    /**
     * Will load all the fields from database of specified primary key
     * @param string $purchase_uuid   is primary key of purchase
     * @return boolean Returns true if purchase found and loaded successfully otherwise return false
     */
    public function load($purchase_uuid){
        global $connection;
        
        $sqlQuery = "CALL purchases_selectOne(:purchase_uuid)";
        
        $PDOStatement = $connection->prepare($sqlQuery);
        $PDOStatement->bindParam(":purchase_uuid", $purchase_uuid);
        
        $PDOStatement->execute();
        if($row = $PDOStatement->fetch()){
            $this->setPurchase_uuid($row["purchase_uuid"]);
            $this->setCustomer_uuid($row["customer_uuid"]);
            $this->setProduct_uuid($row["product_uuid"]);
            $this->setSoldQuantity($row["purchase_soldQuantity"]);
            $this->setSalePrice($row["purchase_salePrice"]);
            $this->setComment($row["purchase_comment"]);
            $this->created = $row["purchase_created"];
            $this->lastModified = $row["purchase_lastModified"];
            $this->subTotal = $row["purchase_subTotal"];
            $this->taxesAmount = $row["purchase_taxesAmount"];
            $this->grandTotal = $row["purchase_grandTotal"];
            
            //closing our statement
            $PDOStatement->closeCursor();
            $PDOStatement = null;
            return true;
        }
        return false;
    }
    
    /**
     * Will save the current purchase if already exist otherwise create a new purchase in database
     */
    public function save(){
        global $connection;
        
        //to check if we need to use insert or update purchase
        if($this->purchase_uuid==""){
            $sqlQuery = "CALL purchases_insert(:customer_uuid, :product_uuid, :soldQuantity,"
                    . " :salePrice, :comment, :subTotal, :taxesAmount, :grandTotal);";
        }else{
            $sqlQuery = "CALL purchases_update(:purchase_uuid, :customer_uuid, :product_uuid, :soldQuantity,"
                    . " :salePrice, :comment, :subTotal, :taxesAmount, :grandTotal);";
        }

        $PDOStatement = $connection->prepare($sqlQuery);
        if($this->purchase_uuid!= ""){
            $PDOStatement->bindParam(":purchase_uuid", $this->purchase_uuid);
        }
        $PDOStatement->bindParam(":customer_uuid", $this->customer_uuid);
        $PDOStatement->bindParam(":product_uuid", $this->product_uuid);
        $PDOStatement->bindParam(":soldQuantity", $this->soldQuantity);
        $PDOStatement->bindParam(":salePrice", $this->salePrice);
        $PDOStatement->bindParam(":comment", $this->comment);
        $PDOStatement->bindParam(":subTotal", $this->subTotal);
        $PDOStatement->bindParam(":taxesAmount", $this->taxesAmount);
        $PDOStatement->bindParam(":grandTotal", $this->grandTotal);
        

        $result = $PDOStatement->execute();
        
        //closing our statement
        $PDOStatement->closeCursor();
        $PDOStatement = null;
        return $result;
    }
    
    /**
     * will delete related purchase row with current purchase's uuid
     * @return boolean Return true if successfully deleted else return false
     */
    public function delete(){
        #check if you have a primay key
        if($this->purchase_uuid != ""){
            global $connection;
            
            $sqlQuery = "CALL purchases_delete(:purchase_uuid);";
            
            $PDOStatement = $connection->prepare($sqlQuery);
            
            $PDOStatement->bindParam(":purchase_uuid", $this->purchase_uuid);
            
            $result = $PDOStatement->execute();
            
            //closing our statement
            $PDOStatement->closeCursor();
            $PDOStatement = null;
            return $result;
        }
        return false;
    }
}


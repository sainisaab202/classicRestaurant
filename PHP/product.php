<?php

##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   17/04/2021  created class product and constructor
#                                declared required constants
#Gurpreet(1911343)   18/04/2021  declared getters and setters for required attributes
#Gurpreet(1911343)   18/04/2021  Created methods: load, save, delete

//constant for required files
//define('DB_CONNECTION', 'connection.php');
//will use constant defined earlier in customer.php // so you need to import first before using this one
require_once DB_CONNECTION;

class product{
    //some constants
    const MAX_LENGTH_CODE = 12;
    const MAX_LENGTH_DESC = 100;
    const MAX_PRICE = 10000;
    const MAX_NUMS_AFTER_DECIMAL = 2;
    const MAX_LENGTH_UUID = 36;
    
    //private attributes
    private $product_uuid = "";
    private $productCode = "";
    private $description = "";
    private $price = 0.0;
    private $costPrice = null;
    private $created = "";
    private $lastModified = "";
    
    /**
     * we use fully parameterized when reading from database
     * @param string $product_uuid
     * @param string $productCode
     * @param string $desc
     * @param decimal $price
     * @param decimal $costPrice
     * @param datetime $created
     * @param datetime $lastModified
     */
    public function __construct($product_uuid="", $productCode="", $desc="", $price=0.0,
            $costPrice=0.0, $created="", $lastModified="") {
        if($product_uuid != ""){
            $this->setProduct_uuid($product_uuid);
        }
        if($productCode != ""){
            $this->setProductCode($productCode);
        }
        if($desc != ""){
            $this->setDescription($desc);
        }
        if($price != ""){
            $this->setPrice($price);
        }
        if($costPrice != ""){
            $this->setCostPrice($costPrice);
        }
        //we don't have to create setter for these because are not setting this from outside class
        $this->created = $created;
        $this->lastModified = $lastModified;
    }
    
    //our getters and setters for private attributes
    private function setProduct_uuid($product_uuid){
        if(mb_strlen($product_uuid) == self::MAX_LENGTH_UUID){
            $this->product_uuid = $product_uuid;
        }
    }
    
    public function getProduct_uuid(){
        return $this->product_uuid;
    }
    
    public function setProductCode($productCode){
        if(trim($productCode) == ""){
            return "Product code cannot be empty.";
        }else if(mb_strlen($productCode) > self::MAX_LENGTH_CODE){
            return "Product code cannot contain more than ". self::MAX_LENGTH_CODE." characters.";
        }else{
            $this->productCode = trim($productCode);
            return "";
        }
    }
    
    public function getProductCode(){
        return $this->productCode;
    }
    
    public function setDescription($desc){
        if(trim($desc) == ""){
            return "Description cannot be empty.";
        }else if(mb_strlen($desc) > self::MAX_LENGTH_DESC){
            return "Description cannot contain more than ". self::MAX_LENGTH_DESC." characters.";
        }else{
            $this->description = trim($desc);
            return "";
        }
    }
    
    public function getDescription(){
        return $this->description;
    }
    
    public function setPrice($price){
        if($price == ""){
           return "Price cannot be empty and should be in between 0$ and ". self::MAX_PRICE."$.";
        }else if(!is_numeric($price)){      //if its only numbers 0-9 and contain decimal points
            return "Price can only contains 0-9 digits and can have upto ". self::MAX_NUMS_AFTER_DECIMAL." decimal numbers.";
        }else if($price < 0 || $price > self::MAX_PRICE){
            return "Price should be between 0$ and ". self::MAX_PRICE."$.";
        }else{
            $this->price = round($price, self::MAX_NUMS_AFTER_DECIMAL);
            return "";
        }
    }
    
    public function getPrice(){
        return $this->price;
    }
    
    public function setCostPrice($costPrice){
        if($costPrice == ""){
            $this->costPrice = null;
           return "";
        }else if(!is_numeric($costPrice)){      //if its only numbers 0-9 and contain decimal points
            return "Cost price can only contains 0-9 digits and can have upto ". self::MAX_NUMS_AFTER_DECIMAL." decimal numbers.";
        }else if($costPrice < 0 || $costPrice > self::MAX_PRICE){
            return "Cost price should be between 0$ and ". self::MAX_PRICE."$.";
        }else{
            $this->costPrice = round($costPrice, self::MAX_NUMS_AFTER_DECIMAL);
            return "";
        }
    }
    
    public function getCostPrice(){
        return $this->costPrice;
    }
    
    public function getCreated(){
        return $this->created;
    }
    
    public function getLastModified(){
        return $this->lastModified;
    }
    
    /**
     * Will load all the fields from database of specified primary key
     * @param string $product_uuid   is primary key of product
     * @return boolean Returns true if product found and loaded successfully otherwise return false
     */
    public function load($product_uuid){
        global $connection;
        
        $sqlQuery = "CALL products_selectOne(:product_uuid)";
        
        $PDOStatement = $connection->prepare($sqlQuery);
        $PDOStatement->bindParam(":product_uuid", $product_uuid);
        
        $PDOStatement->execute();
        if($row = $PDOStatement->fetch()){
            $this->setProduct_uuid($row["product_uuid"]);
            $this->setProductCode($row["product_code"]);
            $this->setDescription($row["product_description"]);
            $this->setPrice($row["product_price"]);
            $this->setCostPrice($row["product_costPrice"]);
            $this->created = $row["product_created"];
            $this->lastModified = $row["product_lastModified"];
            
            //closing our statement
            $PDOStatement->closeCursor();
            $PDOStatement = null;
            return true;
        }
        return false;
    }
    
    /**
     * Will save the current product if already exist otherwise create a new product in database
     */
    public function save(){
        global $connection;
        
        //to check if we need to use insert or update procedure
        if($this->product_uuid==""){
            $sqlQuery = "CALL products_insert(:productCode, :desc, :price, :costPrice);";
        }else{
            $sqlQuery = "CALL products_update(:product_uuid, :productCode, :desc, :price, :costPrice);";
        }

        $PDOStatement = $connection->prepare($sqlQuery);
        if($this->product_uuid != ""){
            $PDOStatement->bindParam(":product_uuid", $this->product_uuid);
        }
        $PDOStatement->bindParam(":productCode", $this->productCode);
        $PDOStatement->bindParam(":desc", $this->description);
        $PDOStatement->bindParam(":price", $this->price);
        $PDOStatement->bindParam(":costPrice", $this->costPrice);
        

        $result = $PDOStatement->execute();
        
        //closing our statement
        $PDOStatement->closeCursor();
        $PDOStatement = null;
        return $result;
    }
    
    /**
     * will delete related product row with current product's uuid
     * @return boolean Return true if successfully deleted else return false
     */
    public function delete(){
        #check if you have a primay key
        if($this->product_uuid != ""){
            global $connection;
            
            $sqlQuery = "CALL products_delete(:product_uuid);";
            
            $PDOStatement = $connection->prepare($sqlQuery);
            
            $PDOStatement->bindParam(":product_uuid", $this->product_uuid);
            
            $result = $PDOStatement->execute();
            
            //closing our statement
            $PDOStatement->closeCursor();
            $PDOStatement = null;
            return $result;
        }
        return false;
    }
}
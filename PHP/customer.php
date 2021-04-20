<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   15/04/2021  Created class customer and constructor
#Gurpreet(1911343)   17/04/2021  Created getters and setters for attributes
#                                Declared some constants for max and min length
#Gurpreet(1911343)   18/04/2021  Created methods: load, login, save, delete
#Gurpreet(1911343)   19/04/2021  Added load function call if login is successfull
#                                Removed minimum length validation for password
#                                and now we just will put hash password method inside our setter



//constant for required files
define('DB_CONNECTION', 'connection.php');

require_once DB_CONNECTION;

class customer{
    
    //Our constants for validation
    const MAX_LENGTH_FIRSTNAME = 10;
    const MAX_LENGTH_LASTNAME = 10;
    const MAX_LENGTH_ADDRESS = 8;
    const MAX_LENGTH_CITY = 8;
    const MAX_LENGTH_PROVINCE = 9;
    const MAX_LENGTH_POSTALCODE = 7;
    const MIN_LENGTH_POSTALCODE = 6;
    const MAX_LENGTH_USERNAME = 12;
    const MAX_LENGTH_PASSWORD = 255;
    const MAX_LENGTH_UUID = 36;
    
    //local variables
    private $customer_uuid="";
    private $firstName="";
    private $lastName="";
    private $address="";
    private $city="";
    private $province="";
    private $postalCode="";
    private $userName="";
    private $password="";
    private $created="";
    private $lastModified="";
    
    //our constructor we will use when we read data from DATADABE
    public function __construct($customer_uuid="", $firstName="", $lastName="", $address="", $city="",
            $province="", $postalCode="", $userName="", $password="", $created="", $lastModified="") {
        if($customer_uuid != ""){
            $this->setCustomer_uuid($customer_uuid);
        }
        if($firstName != ""){
            $this->setFirstName($firstName);
        }
        if($lastName != ""){
            $this->setLastName($lastName);
        }
        if($address != ""){
            $this->setAddress($address);
        }
        if($city != ""){
            $this->setCity($city);
        }
        if($province != ""){
            $this->setProvince($province);
        }
        if($postalCode != ""){
            $this->setPostalCode($postalCode);
        }
        if($userName != ""){
            $this->setUserName($userName);
        }
        //we don't have to create setter for these because are not setting this from outside class
        $this->password = $password;
        $this->created = $created;
        $this->lastModified = $lastModified;
    }
    
    //getters and setter for our private attributes
    //this one is only private because we don't want to set it from outside the class
    private function setCustomer_uuid($customer_uuid){
        if(mb_strlen($customer_uuid) == self::MAX_LENGTH_UUID){
            $this->customer_uuid = $customer_uuid;
        }
    }
    
    public function getCustomer_uuid(){
        return $this->customer_uuid;
    }
    
    public function setFirstName($firstName){
        //before setting it to attribute first we need to validate it
        if(trim($firstName) == ""){
            return "First name cannot be empty.";
        }else if(mb_strlen($firstName) > self::MAX_LENGTH_FIRSTNAME){
            return "First name cannot contain more than ". self::MAX_LENGTH_FIRSTNAME." characters.";
        }else{
            $this->firstName = trim($firstName);
            return "";
        }
    }
    
    public function getFirstName(){
        return $this->firstName;
    }
    
    public function setLastName($lastName){
        //before setting it to attribute first we need to validate it
        if(trim($lastName) == ""){
            return "Last name cannot be empty.";
        }else if(mb_strlen($lastName) > self::MAX_LENGTH_LASTNAME){
            return "Last name cannot contain more than ". self::MAX_LENGTH_LASTNAME." characters.";
        }else{
            $this->lastName = trim($lastName);
            return "";
        }
    }
    
    public function getLastName(){
        return $this->lastName;
    }
    
    public function setAddress($address){
        //before setting it to attribute first we need to validate it
        if(trim($address) == ""){
            return "Address cannot be empty.";
        }else if(mb_strlen($address) > self::MAX_LENGTH_ADDRESS){
            return "Address cannot contain more than ". self::MAX_LENGTH_ADDRESS." characters.";
        }else{
            $this->address = trim($address);
            return "";
        }
    }
    
    public function getAddress(){
        return $this->address;
    }
    
    public function setCity($city){
        //before setting it to attribute first we need to validate it
        if(trim($city) == ""){
            return "City cannot be empty.";
        }else if(mb_strlen($city) > self::MAX_LENGTH_CITY){
            return "City cannot contain more than ". self::MAX_LENGTH_CITY." characters.";
        }else{
            $this->city = trim($city);
            return "";
        }
    }
    
    public function getCity(){
        return $this->city;
    }
    
    public function setProvince($province){
        //before setting it to attribute first we need to validate it
        if(trim($province) == ""){
            return "Province cannot be empty.";
        }else if(mb_strlen($province) > self::MAX_LENGTH_PROVINCE){
            return "Province cannot contain more than ". self::MAX_LENGTH_PROVINCE." characters.";
        }else{
            $this->province = trim($province);
            return "";
        }
    }
    
    public function getProvince(){
        return $this->province;
    }
    
    public function setPostalCode($postalCode){
        //before setting it to attribute first we need to validate it
        if(trim($postalCode) == ""){
            return "Postal Code cannot be empty.";
        }else if(mb_strlen($postalCode) > self::MAX_LENGTH_POSTALCODE){
            return "Postal Code cannot contain more than ". self::MAX_LENGTH_POSTALCODE." characters.";
        }else if(mb_strlen($postalCode) < self::MIN_LENGTH_POSTALCODE){
            return "Postal Code cannot contain less than ". self::MIN_LENGTH_POSTALCODE." characters.";
        }else{
            $this->postalCode = trim($postalCode);
            return "";
        }
    }
    
    public function getPostalCode(){
        return $this->postalCode;
    }
    
    public function setUserName($userName){
        //before setting it to attribute first we need to validate it
        if(trim($userName) == ""){
            return "Username cannot be empty.";
        }else if(mb_strlen($userName) > self::MAX_LENGTH_USERNAME){
            return "Username cannot contain more than ". self::MAX_LENGTH_USERNAME." characters.";
        }else{
            $this->userName = trim($userName);
            return "";
        }
    }
    
    public function getUserName(){
        return $this->userName;
    }
    
    /**
     *  before type $password is a hashed password calculated with password_hash()
     * 
     *  now method will calculates hashed password with password_hash()
     * @param type $password is a string 
     * @return string An empty string "" if password is valid otherwise returns error as string
     */
    public function setPassword($password){
        //before setting it to attribute first we need to validate it
        if(trim($password) == ""){
            return "Password cannot be empty.";
        }else if(mb_strlen($password) > self::MAX_LENGTH_PASSWORD){
            return "Password cannot contain more than ". self::MAX_LENGTH_PASSWORD." characters.";
        }else{                  //here we are hashing our password (encrypting) and then saving into variable
            $this->password = password_hash(trim($password), PASSWORD_DEFAULT);
            return "";
        }
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    public function getCreated(){
        return $this->created;
    }
    
    public function getLastModified(){
        return $this->lastModified;
    }
    
    /**
     * 
     * @param type $userName is a string of maximum 12 chars
     * @param type $password is password related to same username
     * @return string of UUID if userName and password are valid
     * @return null if username and password are wrong or not valid
     */
    public function login($userName, $password){
        global $connection;
        $sqlQuery = "CALL customers_getPassword(:userName)";
        
        $PDOStatement = $connection->prepare($sqlQuery);
        $PDOStatement->bindParam(":userName", $userName);
        
        $PDOStatement->execute();
        if($row = $PDOStatement->fetch()){
            //password from database
            $hashPass = $row["customer_password"];
            //password from user and verifing it
            if(password_verify($password, $hashPass)){
                //closing our statement
                $PDOStatement->closeCursor();
                $PDOStatement = null;
                $this->load($row["customer_uuid"]);
                return $row["customer_uuid"];
            }else{
                //closing our statement
                $PDOStatement->closeCursor();
                $PDOStatement = null;
                return null;
            }
        }else{
            //closing our statement
            $PDOStatement->closeCursor();
            $PDOStatement = null;
            return null;
        }
    }
    
    /**
     * Will load all the fields from database of specified primary key
     * @param string $customer_uuid   is primary key of customers
     * @return boolean Returns true if customer found and loaded successfully otherwise return false
     */
    public function load($customer_uuid){
        global $connection;
        
        $sqlQuery = "CALL customers_selectOne(:customer_uuid)";
        
        $PDOStatement = $connection->prepare($sqlQuery);
        $PDOStatement->bindParam(":customer_uuid", $customer_uuid);
        
        $PDOStatement->execute();
        if($row = $PDOStatement->fetch()){
            $this->setCustomer_uuid($row["customer_uuid"]);
            $this->setFirstName($row["customer_firstName"]);
            $this->setLastName($row["customer_lastName"]);
            $this->setAddress($row["customer_address"]);
            $this->setCity($row["customer_city"]);
            $this->setProvince($row["customer_province"]);
            $this->setPostalCode($row["customer_postalCode"]);
            $this->setUserName($row["customer_userName"]);
            $this->password = $row["customer_password"];
            $this->created = $row["customer_created"];
            $this->lastModified = $row["customer_lastModified"];
            
            //closing our statement
            $PDOStatement->closeCursor();
            $PDOStatement = null;
            return true;
        }
        return false;
    }
    
    /**
     * Will save the current customer if already exist otherwise create a new customer in database
     */
    public function save(){
        global $connection;
        
        //to check if we need to use insert or update procedure
        if($this->customer_uuid==""){
            $sqlQuery = "CALL customers_insert(:firstName, :lastName, :address, :city, :province, "
                    . ":postalCode, :userName, :password);";
        }else{
            $sqlQuery = "CALL customers_update(:customer_uuid, :firstName, :lastName, :address, :city, :province, "
                    . ":postalCode, :userName, :password);";
        }

        $PDOStatement = $connection->prepare($sqlQuery);
        if($this->customer_uuid != ""){
            $PDOStatement->bindParam(":customer_uuid", $this->customer_uuid);
        }
        $PDOStatement->bindParam(":firstName", $this->firstName);
        $PDOStatement->bindParam(":lastName", $this->lastName);
        $PDOStatement->bindParam(":address", $this->address);
        $PDOStatement->bindParam(":city", $this->city);
        $PDOStatement->bindParam(":province", $this->province);
        $PDOStatement->bindParam(":postalCode", $this->postalCode);
        $PDOStatement->bindParam(":userName", $this->userName);
        $PDOStatement->bindParam(":password", $this->password);

        $result = $PDOStatement->execute();
        
        //closing our statement
        $PDOStatement->closeCursor();
        $PDOStatement = null;
        return $result;
    }
    
    /**
     * will delete related customer row with current customer's uuid
     * @return boolean Return true if successfully deleted else return false
     */
    public function delete(){
        #check if you have a primay key
        if($this->customer_uuid != ""){
            global $connection;
            
            $sqlQuery = "CALL customers_delete(:customer_uuid);";
            
            $PDOStatement = $connection->prepare($sqlQuery);
            
            $PDOStatement->bindParam(":customer_uuid", $this->customer_uuid);
            
            $result = $PDOStatement->execute();
            
            //closing our statement
            $PDOStatement->closeCursor();
            $PDOStatement = null;
            return $result;
        }
        return false;
    }
}
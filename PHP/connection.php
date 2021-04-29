<?php
##DEVELOPER          DATE        COMMENTS
#Gurpreet(1911343)   15/04/2021  Created connection String for this website
#                                And declared required constants

##some constants here
define('HOST_NAME', 'localhost');
define('DATABASE_NAME', 'database-1911343');

##use root only if you are editing code
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', 'asdf1234');
        
## Other user
define('DB_USERNAME', 'user-1911343');
define('DB_PASSWORD', 'user-1911343');


#open a connection to our database  Use Root USER only if you are editing code
$connection = new PDO("mysql:host=".HOST_NAME.";dbname=".DATABASE_NAME, DB_USERNAME, DB_PASSWORD);

//this will help us to show errors if we have any in our SQL statements
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

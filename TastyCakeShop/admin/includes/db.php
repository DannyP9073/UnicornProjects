<?php
  $db_host = 'localhost';
  $db_user = 'Myuser';
  $db_password = 'SA1@123';
  $db_db = 'Cakes';

$connection = new mysqli($db_host, $db_user, $db_password, $db_db);  
 if(!$connection) {
     die("Database connection failed");
 }


?>
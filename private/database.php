<?php 
   require_once('db_credentials.php');
   function db_connect(){
       $connnection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
       return $connnection;
   } 
   function db_disconnect($connection){
       if(isset($connection))
            mysqli_close($connection);
   }
   function confirm_db_connect(){
       if(mysqli_connect_errno()){
        $msg="Database connection failed";
        $msg.=mysqli_connect_error();
        $msg.="(".mysqli_connect_errno().")";
        exit($msg);
       }   
   }
   function confirm_result_set($result_set){
       if(!$result_set){
           exit("Database query failed.");
       }
   }
   //Escapes SQL Injection
   function db_escape($connection, $string){
       mysqli_real_escape_string($connection, $string);
   }
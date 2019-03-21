<?php
    // Navigation constants
    // __FILE__ returns the current path to file
    // dirname() returns the path to current directory  
    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public');
    define("SHARED_PATH", PRIVATE_PATH . '/shared');
    //Site ROOT Constant
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0,$public_end);
    define("WWW_ROOT",$doc_root);
    require_once('functions.php');
    require_once('database.php');
    require_once('query_functions.php');
    require_once('validation_functions.php');
    //Every page that has initialize.php is connected to the database
    //$db global scope
    $db = db_connect();
    confirm_db_connect($db);
    $errors = [];
        

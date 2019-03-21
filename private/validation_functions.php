<?php
    /**
     * Returns bool true its empty, false not empty
     */
    function is_blank($value){
        return !isset($value) || trim($value)==='';
    }
    /**
     * Retunrs bool checks if a value is there or not.
     */
    function has_presence($value){
        //if its NOT blank
        return !is_blank($value);
    }
    /**
     * Returns bool string length more than $min
     */
    function has_length_greater_than($value,$min){
        $length = strlen($value);
        return $length > $min;
    }
    /**
     * Returns bool string length less than $max
     */
    function has_length_less_than($value,$max){
        $length = strlen($value);
        return $length < $max;
    }
    /**
     * Returns bool string length matches $exact
     */
    function has_length_exactly($value,$exact){
        $length = strlen($value);
        return $length == $exact;
    }
    /**
     * $options takes in an associative array of validation options $options ex:['min'=>1,'max'=>100]
     */
    function has_length($value,$options){
        if(isset($options['min'])&& !has_length_greater_than($value,$options['min'] - 1)){
            return false;
        }elseif (isset($options['max']) && !has_length_less_than($value,$options['max'])) {
            return false;
        }elseif (isset($options['exact'])&& !has_length_exactly($value,$options['exact'])) {
            return false;
        }else{
            return true;
        }
    }

    function has_inclusion_of($value, $set){
        return in_array($value,$set);
    }
    function has_exclusion_of($value,$set){
        return !in_array($value,$set);
    }
    function has_string($value,$required_string){
        return strpos($value,$required_string) !== false;
    }
    function has_valid_email_format($value) {
        $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
        return preg_match($email_regex, $value) === 1;
      }
    function has_unique_pages_menu_name($menu_name,$current_id="0"){
        global $db;
        $sql= "SELECT * FROM pages ";
        $sql.= "WHERE menu_name='". db_escape($db,$menu_name) . "' ";
        $sql.= "AND id!='" . db_escape($db,$current_id) . "';";
        $page_set = mysqli_query($db, $sql);
        $page_count = mysqli_num_rows($page_set);
        mysqli_free_result($page_set);
        return $page_count === 0;
    }
    function has_unique_subject_menu_name($menu_name, $current_id="0"){
        global $db;
        $sql= "SELECT * FROM subjects ";
        $sql.= "WHERE menu_name='". db_escape($db,$menu_name) . "' ";
        $sql.= "AND id!='" . db_escape($db,$current_id) . "';";
        $subject_set = mysqli_query($db, $sql);
        $subject_count = mysqli_num_rows($subject_set);
        mysqli_free_result($subject_set);
        return $subject_count ===0;
    }
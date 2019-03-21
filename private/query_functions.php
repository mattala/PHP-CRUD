<?php 
    function find_all_subjects(){
        global $db;
        $sql= "SELECT * FROM subjects ";
        $sql.= "ORDER BY position ASC;";
        //Troubleshoot code
        //echo $sql . "<br />";
        $result= mysqli_query($db,$sql);
        confirm_result_set($result);
        return $result;
    }
    function validate_subject($subject) {

      $errors = [];
      
      // menu_name
      if(is_blank($subject['menu_name'])) {
        $errors[] = "Name cannot be blank.";
      }
      if(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
        $errors[] = "Name must be between 2 and 255 characters.";
      }
      $current_id = $subject['id'] ?? '0';
      if(!has_unique_subject_menu_name($subject['menu_name'],$current_id)) {
        $errors[]="Subject name must be unique!";
      }
      // position
      // Make sure we are working with an integer
      $postion_int = (int) $subject['position'];
      if($postion_int <= 0) {
        $errors[] = "Position must be greater than zero.";
      }
      if($postion_int > 999) {
        $errors[] = "Position must be less than 999.";
      }
    
      // visible
      // Make sure we are working with a string
      $visible_str = (string) $subject['visible'];
      if(!has_inclusion_of($visible_str, ["0","1"])) {
        $errors['visible'] = "Visible must be true or false.";
      }
    
      return $errors;
    }

    function insert_subject($subject){
        global $db;
        $error=validate_subject($subject);
        if (!empty($error)) {
          return $error;
        }
        $sql="INSERT INTO subjects ";
        $sql.="(menu_name, position, visible) ";
        $sql.="VALUES (";
        $sql.= "'" . db_escape($db,$subject['menu_name']) . "',";
        $sql.="'" . db_escape($db,$subject['position']) . "',";
        $sql.="'" . db_escape($db,$subject['visible']) . "'";
        $sql.=")";
        $result = mysqli_query($db,$sql);
            
        if($result){
            $new_id = mysqli_insert_id($db);
            redirect_to(url_for('/staff/subjects/show.php?id='.$new_id));
        }else{
            //INSERT FAILED HANDLE . . .
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    }
    function find_table_by_id($table_name,$id){
        global $db;
        $sql="SELECT * FROM $table_name ";
        $sql.="WHERE id='". db_escape($db,$id) ."'";
        //echo $sql;
        $result = mysqli_query($db,$sql);
        confirm_result_set($result);
        $set = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $set;
    }
    function find_subject_by_id($id){
      global $db;
      $sql="SELECT * FROM subjects ";
      $sql.="WHERE id='". db_escape($db,$id) ."'";
      //echo $sql;
      $result = mysqli_query($db,$sql);
      confirm_result_set($result);
      $set = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $set;
  }
    function find_all_pages(){
        global $db;
        $sql= "SELECT * FROM pages ";
        $sql.="ORDER BY position ASC;";
        $result=mysqli_query($db,$sql);
        confirm_result_set($result);
        return $result;
    }
    function update_subject($subject) {
        global $db;
        $error=validate_subject($subject);
        if (!empty($error)) {
          return $error;
        }

        $sql = "UPDATE subjects SET ";
        $sql .= "menu_name='" . db_escape($db,$subject['menu_name']) . "', ";
        $sql .= "position='" . db_escape($db,$subject['position']) . "', ";
        $sql .= "visible='" . db_escape($db,$subject['visible']) . "' ";
        $sql .= "WHERE id='" . db_escape($db,$subject['id']) . "' ";
        $sql .= "LIMIT 1";

        $result = mysqli_query($db, $sql);
        // For UPDATE statements, $result is true/false
        if($result) {
            return true;
        } else {
            // UPDATE failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }

    }

    function delete_subject($id){
        global $db;
        $sql="DELETE FROM subjects ";
        $sql.="WHERE id=".db_escape($db,$id);
        $result=mysqli_query($db,$sql);
        if ($result) {
            return true;
        } else {
            //Delete failed
            echo mysqli_error($db);
            db_disconnect($db);
            exit;
        }
        
    }
    //PAGE QUERY CHALL
    function find_page_by_id($id) {
        global $db;
    
        $sql = "SELECT * FROM pages ";
        $sql .= "WHERE id='" . db_escape($db,$id) . "'";
        $result = mysqli_query($db, $sql);
        confirm_result_set($result);
        $page = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $page; 
    }
    function insert_page($page) {
        global $db;
        $error = validate_page($page);
        if(!empty($error)){
          return $error;
        }
        $sql = "INSERT INTO pages ";
        $sql .= "(subject_id, menu_name, position, visible, content) ";
        $sql .= "VALUES (";
        $sql .= "'" . db_escape($db,$page['subject_id']) . "',";
        $sql .= "'" . db_escape($db,$page['menu_name']) . "',";
        $sql .= "'" . db_escape($db,$page['position']) . "',";
        $sql .= "'" . db_escape($db,$page['visible'] ). "',";
        $sql .= "'" . db_escape($db,$page['content'] ). "'";
        $sql .= ")";
        $result = mysqli_query($db, $sql);
        // For INSERT statements, $result is true/false
        if($result) {
          return true;
        } else {
          // INSERT failed
          var_dump($sql);
          echo mysqli_error($db);
          db_disconnect($db);
          exit;
        }
      }
    function update_page($page) {
    global $db;
    $error = validate_page($page);
    if(!empty($error)){
      return $error;
    }
    $sql = "UPDATE pages SET ";
    $sql .= "subject_id='" . db_escape($db,$page['subject_id']) . "', ";
    $sql .= "menu_name='" . db_escape($db,$page['menu_name']) . "', ";
    $sql .= "position='" . db_escape($db,$page['position']) . "', ";
    $sql .= "visible='" . db_escape($db,$page['visible']) . "', ";
    $sql .= "content='" . db_escape($db,addslashes($page['content'])) . "' ";
    $sql .= "WHERE id='" . db_escape($db,$page['id']) . "' ";
    $sql .= "LIMIT 1";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }

  }


  function delete_page($id) {
      global $db;

      $sql = "DELETE FROM pages ";
      $sql .= "WHERE id='" . db_escape($db,$id) . "' ";
      $sql .= "LIMIT 1";
      $result = mysqli_query($db, $sql);

      // For DELETE statements, $result is true/false
      if($result) {
        return true;
      } else {
        // DELETE failed
        echo mysqli_error($db);
        db_disconnect($db);
        exit; 
    }
  }
  function validate_page($page){
    //Empty array to collect errors
    $errors = [];
    //Page Name Validation
    if(is_blank($page['menu_name'])){
      $errors[] = "Page name cannot be blank";
    }
    if(!has_length($page['menu_name'], ['min'=>2, 'max'=> 255])){
      $errors[] ="Page name must be between 2 and 255 characters.";
    }
    $current_id = $page['id'] ?? '0';
    if(!has_unique_pages_menu_name($page['menu_name'],$current_id)){
      $errors[] = "Menu name must be unique.";
    }
    //Content Validation
    if(is_blank($page['content'])){
      $errors[] = "Content cannot be blank";
    }
    //Position Validation
    $position_int = (int) $page['position'];
    if($position_int <= 0){
      $errors[] = "Position must be greater than 0."; 
    }
    if($position_int > 999){
      $errors[] = "Position must be less than 999.";
    }
    //Visible Validation
    $visible_str= (string) $page['visible'];
    if(!has_inclusion_of($visible_str,["0","1"])){
      $errors[] = "Visible must be true or false.";
    }
    return $errors;
  }
    
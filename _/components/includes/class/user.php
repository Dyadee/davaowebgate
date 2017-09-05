
<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once("database.php");

class User{	
	protected static $table_name="tbl_userdetail";
	protected static $register_fields = array('userID', 'firstName', 'middleName', 'lastName', 'gender', 'userPhone', 'userFax', 'userMail', 'userPassword', 'hashedPassword', 'registerDate', 'registerUpDate');
	protected static $update_fields = array('firstName', 'middleName', 'lastName', 'gender', 'userPhone', 'userFax', 'registerUpDate');
	protected static $update_login = array('userMail','userPassword', 'hashedPassword', 'registerUpDate');
	public $userID;
	public $firstName;
	public $middleName;
	public $lastName;
	public $gender;
	public $userPhone;
	public $userFax;
	public $userMail;
	public $userPassword;
	public $hashedPassword;
	public $registerDate;
	public $registerUpDate;
	//QUERIES THE DATABASE IF USER EXIST
	public static function authenticate($userMail="", $hashedPassword="") {
		global $database;
		$userMail = $database->PrepSQL($userMail);
		$hashedPassword = $database->PrepSQL($hashedPassword);

		$sql  = "SELECT * FROM tbl_userdetail ";
		$sql .= "WHERE userMail = '{$userMail}' ";
		$sql .= "AND hashedPassword = '{$hashedPassword}' ";
		$sql .= "LIMIT 1";
		$result_user_array = self::find_by_sql($sql);
			return !empty($result_user_array) ? array_shift($result_user_array) : false;
	}

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE userID={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  public static function find_by_userMail($userMail="") {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE userMail='$userMail' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$register_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	protected function attributes_update() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$update_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	protected function attributes_update_login() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$update_login as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->PrepSQL($value);
	  }
	  return $clean_attributes;
	}
	protected function sanitized_attributes_update() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes_update() as $key => $value){
	    $clean_attributes[$key] = $database->PrepSQL($value);
	  }
	  return $clean_attributes;
	}
	protected function sanitized_attributes_login() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes_update_login() as $key => $value){
	    $clean_attributes[$key] = $database->PrepSQL($value);
	  }
	  return $clean_attributes;
	}
	
	public function save() {
	  // A new record won't have an userID yet.
	  return isset($this->userID) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes(self::$register_fields);
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
		
	    $this->userID = $database->insert_ID();
		$hashedUserID = hash('sha256', $this->userID);
		$this->create_directory($hashedUserID);		
		return true;
	  } else {
	    return false;
	  }
	  
	}// END create()
	
	public function create_directory($var){
		
		if (mysql_affected_rows() == 1) { // Success!				
				
				//IF FOLDER NAMED BY $hashedUserID ALREADY EXIST, DELETE IT AND MAKE NEW FOLDER WITH THE SAME NAME				
				$directory = "uploads/$var/";
				$directory_business = "uploads/$var/Business/";
				$directory_items = "uploads/$var/Items/";
				if(file_exists($directory)){					
					$directories = scandir($directory);
					$excluded = array('.','..');
					$result_dir = array_diff($directories, $excluded);
					if(!empty($result_dir)){
						foreach(glob($directory.'*.*') as $folder){
							if (is_dir($folder)){
								$dir = "uploads/$var/$folder/";
								$dirc = scandir($dir);
								$excluded_arr = array('.','..');
								$result_dirc = array_diff($dirc, $excluded_arr);
								if(!empty($result_dirc)){
									foreach(glob($dirc.'*.*') as $file){unlink($file);}
								}rmdir($dir);
							}else {unlink($folder);}
						}rmdir($directory);
					}rmdir($directory);
					mkdir($directory, 0755);
					mkdir($directory_business, 0755);
					mkdir($directory_items, 0755);
					
				}else{
					mkdir($directory, 0755);
					mkdir($directory_business, 0755);
					mkdir($directory_items, 0755);
				} // Create directory(folder) with $hashedUserID to hold each user's uploaded images				
				$_SESSION['successRegistration'] = "Congratulations! You have successfully registered to Davao Webgate";
				//redirect_to("userRegistration.php");
				redirect_to("login.php");
		}else {return false;}
	
	}//END create_directory()

	public function update() {
	  global $database;	  
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes_update();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE userID=". $database->PrepSQL($_SESSION['userID']);	  
		if($database->query($sql)){
			if($database->affected_rows() == 1){
				$_SESSION['successUpdate'] = "Account Information successfully updated!";
				redirect_to('userUpdate.php');
			} 
			else{redirect_to('member.php');}			
		}

	}//END 	update()
	public function update_login() {
	  global $database;	  
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes_login();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE userID=". $database->PrepSQL($_SESSION['userID']);	  
		if($database->query($sql)){
			if($database->affected_rows() == 1){
				$_SESSION['successUpdateLogin'] = "Login Information successfully updated!";
				redirect_to('loginUpdate.php');
			} 
			else{redirect_to('loginUpdate.php');}			
		}

	}//END 	update()
	
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->PrepSQL($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? redirect_to('../../../member.php'): false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

}

?>
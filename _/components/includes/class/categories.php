
<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once("database.php");

class Categories{	
	protected static $table_name="tbl_businesstype";
	protected static $register_fields = array('businesstypeID', 'businessCategory', 'businessType');
	protected static $update_fields = array('businesstypeID', 'businessCategory', 'businessType');
	
	public $businesstypeID;
	public $businessCategory;
	public $businessType;
	
	//QUERIES THE DATABASE IF CATEGORIES EXIST
	public static function find_by_category($category=''){
		$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE businessCategory = '$category' ORDER BY businessType ASC");
		return !empty($result_array) ? $result_array : false;
	}
	
	
	public static function authenticate($userID="", $businessID="") {
		global $database;
		$userID = $database->PrepSQL($userID);
		$businessID = $database->PrepSQL($businessID);
		$sql  = "SELECT * FROM tbl_businesslist ";
		$sql .= "WHERE businessID = '{$businessID}' ";
		$sql .= "AND userID = '{$userID}' ";
		$sql .= "LIMIT 1";
		$result_user_array = self::find_by_sql($sql);
			return !empty($result_user_array) ? array_shift($result_user_array) : false;
	}

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_id($userID=0, $businessID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (userID={$userID} AND businessID={$businessID}) LIMIT 1");
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
	    $this->businessID = $database->insert_ID();
		$hashedUserID = hash('sha256', $this->userID);
		$hashedBusinessID = hash('sha256', $this->businessID);
		$this->create_business_directory($hashedUserID, $hashedBusinessID);
		return true;
	  } else {
	    return false;
	  }
	}// END create()
	
	public function create_business_directory($userID, $businessID){ //CHECK FOR FUNCTIONALITY
		if (mysql_affected_rows() == 1) { // Success!				
				echo "<span style = \"color:green; font-size: .9em; font-weight: bold;\">User Registration Successful!</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = \"color:gray; font-size: .9em;\">Press \"CANCEL\" to go back to your settings.</span>";
				//IF FOLDER NAMED BY $hashedUserID ALREADY EXIST, DELETE IT AND MAKE NEW FOLDER WITH THE SAME NAME				
				$directory = "../../../uploads/$userID/$businessID";
				$dot_docs =array('.', '..');
				if(file_exists($directory)){					
					$files = scandir($directory);
					$diff_dir = array_diff($files, $dot_docs);
					if(!empty($diff_dir)){
						foreach(glob($directory.'*.*') as $file){unlink($file);}
					}
					rmdir($directory);
					mkdir($directory, 0755);
					redirect_to("../../../businessRegistration.php?r=1");
				}else{mkdir($directory, 0755); // Create directory(folder) with $hashedBusinessID to hold each user's uploaded images		
					redirect_to("../../../businessRegistration.php?r=1");
				}
		}else {echo "<span style = \"color:red; font-size: .9em; font-weight: bold;\">User Registration Failed!</span>";}
	
	}//END create_business_directory()
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
		$sql .= " WHERE businessID=". $database->PrepSQL($_SESSION['businessID']);
		$sql .= " AND userID=". $database->PrepSQL($_SESSION['userID']);
		$directory = '../../../businessUpdate.php?bid='.$_SESSION['businessID'];
		//obscure the user by passing $_GET values to the url like .php?t=md5(time())&bid=businessID&q=hash(davaowebgate)
		if($database->query($sql)){
			if($database->affected_rows() == 1){
				redirect_to($directory);
			} 
			else{redirect_to($directory);}			
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
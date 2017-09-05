
<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once("database.php");

class Business{	
	protected static $table_name="tbl_businesslist";
	protected static $tbl_businesstype ="tbl_businesstype";
	protected static $register_fields = array('businessID', 'businessName', 'businessCategory', 'businessType', 'businessAddress', 'businessLocation', 'businessPhone', 'businessFax', 'businessEmail', 'businessWebsite', 'businessDescription', 'businessTags', 'businessFeatured', 'businessPostDate', 'businessUpDate', 'userID');
	protected static $update_fields = array('businessName', 'businessCategory', 'businessType', 'businessAddress', 'businessLocation', 'businessPhone', 'businessFax', 'businessEmail', 'businessWebsite', 'businessDescription', 'businessTags', 'businessUpDate');
	
	public $businessID;
	public $businessName;
	public $businessCategory;
	public $businessType;
	public $businessAddress;
	public $businessLocation;
	public $businessPhone;
	public $businessFax;
	public $businessEmail;
	public $businessWebsite;
	public $businessDescription;
	public $businessTags;
	public $businessFeatured;
	public $businessPostDate;
	public $businessUpDate;
	public $userID;
	//QUERIES THE DATABASE IF Business EXIST
	public static function authenticate($businessID="", $userID="") {
		global $database;
		$businessID = $database->PrepSQL($businessID);
		$userID = $database->PrepSQL($userID);

		$sql  = "SELECT * FROM tbl_businesslist ";
		$sql .= "WHERE businessID = '{$businessID}' ";
		$sql .= "AND userID = '{$userID}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
	}
	public static function select_categories($category="") {
		global $database;
		$category = $database->PrepSQL($category);
		$sql  = "SELECT * FROM tbl_businesstype ";
		$sql .= "WHERE businessCategory = '{$category}' ";
		$result_array = $database->query($sql);
		$record = array();
		while ($row = $database->fetch_array($result_array)) {
			array_push($record, $row);
		}
		return !empty($record) ? $record : false;
	}

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_userID($userID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE userID={$userID}");
		return !empty($result_array) ? $result_array : false;
  }
   public static function find_by_businessID($userID=0, $businessID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE (userID={$userID} AND businessID={$businessID})");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_latest($rows=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY businessPostDate DESC LIMIT $rows");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_featured() {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE businessFeatured = 'YES'");
		return !empty($result_array) ? $result_array : false;
  }
  
   public static function find_by_businessType($businessType="") {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE businessType='$businessType'");
		return !empty($result_array) ? $result_array : false;
  }
    public static function find_by_randomProduct() {
    	$businesstypeProductID = rand(1, 55);
    $result_array = self::find_by_sql("SELECT businessType FROM ".self::$tbl_businesstype." WHERE businessCategory='Products' AND businesstypeID = $businesstypeProductID LIMIT 1");
		return !empty($result_array) ? $result_array : false;
  }
	 public static function find_by_randomService() {
	 	$businesstypeServiceID = rand(56, 134);
    $result_array = self::find_by_sql("SELECT businessType FROM ".self::$tbl_businesstype." WHERE businessCategory='Services' AND businesstypeID = $businesstypeServiceID LIMIT 1");
		return !empty($result_array) ? $result_array : false;
  }
  
  //THE FOLLOWING FUNCTION COUNTS THE THE NUMBER OF ITEMS IN THE DATABASE. USE THIS INSTEAD OF find_by_businessType
  public static function count_by_businessType($businessType="") {
  	global $database;
  	$businessType_sanitized = $database->PrepSQL($businessType);
  	$sql = "SELECT COUNT(*) FROM tbl_businesslist WHERE businessType='$businessType'";
    $result_count = $database->query($sql);
		return $result_count;
  }

  public static function find_by_search_like($search="") {
	    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE businessName LIKE '%$search%' OR businessType LIKE '%$search%' OR businessAddress LIKE '%$search%' OR businessLocation LIKE '%$search%' OR businessDescription LIKE '%$search%' OR businessTags LIKE '%$search%'");
		return !empty($result_array) ? $result_array : false;
  }
    public static function find_by_search_match($search="", $businessCategory) {
	// $sql_alter = "ALTER TABLE tbl_businesslist ADD FULLTEXT(businessName, businessType, businessAddress, businessLocation, businessDescription, businessTags)"; //Database query failed: Too many keys specified; max 64 keys allowed
	// $database->query($sql_alter);	
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE MATCH(businessName, businessType, businessAddress, businessLocation, businessDescription, businessTags) AGAINST ('$search') AND businessCategory='$businessCategory'");
		return !empty($result_array) ? $result_array : false;
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
		$this->userID = $_SESSION['userID'];
		
		$hashedBusinessID = hash('sha256', $this->businessID);
		$hashedUserID = hash('sha256', $this->userID);
		
		$this->create_directory($hashedUserID, $hashedBusinessID);
		return true;
	  } else {
	    return false;
	  }
	}// END create()
	
	public function create_directory($hashedUserID='', $hashedBusinessID){
		if (mysql_affected_rows() == 1) { // Success!				
				echo "<span style = \"color:green; font-size: .9em; font-weight: bold;\">User Registration Successful!</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = \"color:gray; font-size: .9em;\">Press \"CANCEL\" to go back to your settings.</span>";
				//IF FOLDER NAMED BY $hashedUserID ALREADY EXIST, DELETE IT AND MAKE NEW FOLDER WITH THE SAME NAME				
				$directory = "uploads/$hashedUserID/Business/$hashedBusinessID";
				if(file_exists($directory)){					
					$directories = scandir($directory);
					$excluded = array('.','..');
					$result_dir = array_diff($directories, $excluded);
						if(!empty($result_dir)){
							foreach(glob($directory.'*.*') as $file){unlink($file);}
						}
					rmdir($directory);
					mkdir($directory, 0755);
					redirect_to("businessView.php");
				}else{mkdir($directory, 0755);} // Create directory(folder) with $hashedUserID to hold each user's uploaded images		
				$_SESSION['successbusinessRegistration'] = "Congratulations! You have successfully registered your business to Davao Webgate";
				redirect_to("businessView.php");
		}else {echo "<span style = \"color:red; font-size: .9em; font-weight: bold;\">Business Registration Failed!</span>";}
	
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
		$sql .= " WHERE businessID=".$database->PrepSQL($_SESSION['businessID']);
		$sql .= " AND userID=".$database->PrepSQL($_SESSION['userID']);
		if($database->query($sql)){
			if($database->affected_rows() == 1){
				$t = hash("sha512", time());
				$bid = $_SESSION['businessID'];
				$uid = hash('sha512', $_SESSION['businessID']);
				$q = hash('sha512', $_SESSION['userID']);
				$_SESSION['successbusinessUpdate'] = "Business Information successfully updated!";
				redirect_to("businessUpdate.php?t=$t&uid=$uid&bid=$bid&q=$q");
			} 
			else{redirect_to("businessUpdate.php?t=$t&uid=$uid&bid=$bid&q=$q");}			
		}

	}//END 	update()
		
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE businessID=". $database->PrepSQL($this->businessID);
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
		
		//COUNTING ENTRIES BY BUSINESS TYPE
?>
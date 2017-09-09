
<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once("database.php");

class Item{	
	protected static $table_name="tbl_marketplace";
	protected static $table_itemcategories = "tbl_itemcategories";
	protected static $itemPost_fields = array('itemCategoryID', 'itemTitle', 'itemCategory', 'itemPrice', 'itemContactInfo', 'itemDescription', 'itemTags', 'itemFeatured', 'itemPostDate', 'itemUpDate', 'userID');
	protected static $update_fields = array('itemTitle', 'itemCategory', 'itemPrice', 'itemContactInfo', 'itemDescription', 'itemTags', 'itemFeatured', 'itemUpDate');
	
	public $itemID;
	public $itemTitle;
	public $itemCategory;
	public $itemPrice;
	public $itemContactInfo;
	public $itemDescription;
	public $itemTags;
	public $itemFeatured;
	public $itemPostDate;
	public $itemUpDate;
	public $userID;
	//QUERIES THE DATABASE IF ITEM EXIST
	public static function authenticate($itemID="", $userID="") {
		global $database;
		$itemID = $database->PrepSQL($itemID);
		$userID = $database->PrepSQL($userID);

		$sql  = "SELECT * FROM tbl_marketplace ";
		$sql .= "WHERE itemID = '{$itemID}' ";
		$sql .= "AND userID = '{$userID}' ";
		$sql .= "LIMIT 1";
		$result_array = self::find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
	}
	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_userID($userID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE userID={$userID}");
		return !empty($result_array) ? $result_array : false;
  }
   public static function find_by_itemID($itemID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE itemID={$itemID}");
		return !empty($result_array) ? $result_array : false;
  }
   public static function find_by_userItemID($userID=0, $itemID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE userID='$userID' AND itemID='$itemID'");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_latest($rows=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY itemPostDate DESC LIMIT $rows");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_featured() {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE itemFeatured = 'YES'");
		return !empty($result_array) ? $result_array : false;
  }
  
   public static function find_by_itemCategory($itemCategory="") {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE itemCategory='$itemCategory'");
		return !empty($result_array) ? $result_array : false;
  }
  
    public static function find_by_similarItemCategory($itemCategory="", $itemID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE itemCategory='$itemCategory' AND itemID != '$itemID'");
		return !empty($result_array) ? $result_array : false;
  }
	   public static function find_by_randomItemCategory() {
	   	$randomItemCategoryID = rand(1, 48);
    $result_array = self::find_by_sql("SELECT itemCategory FROM ".self::$table_itemcategories." WHERE itemID='$randomItemCategoryID' LIMIT 1");
		return !empty($result_array) ? $result_array : false;
  }

  //THE FOLLOWING FUNCTION COUNTS THE THE NUMBER OF ITEMS IN THE DATABASE. USE THIS INSTEAD OF find_by_itemCategory FOR BETTER PERFORMANCE
  public static function count_by_itemCategory($itemCategory="") {
    $result_count = self::find_by_sql("SELECT COUNT(*) FROM ".self::$table_name." WHERE itemCategory='$itemCategory'");
		return !empty($result_count) ? $result_count : false;
  }

  public static function find_by_search_like($search="") {
	    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE itemTitle LIKE '%$search%' OR itemCategory LIKE '%$search%' OR itemDescription LIKE '%$search%' OR itemTags LIKE '%$search%'");
		return !empty($result_array) ? $result_array : false;
  }
    public static function find_by_search_match($search="") {
	// $sql_alter = "ALTER TABLE tbl_marketplace ADD FULLTEXT(itemTitle, itemCategory, itemDescription, itemTags)"; //Database query failed: Too many keys specified; max 64 keys allowed
	// $database->query($sql_alter);	
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE MATCH(itemTitle, itemCategory, itemDescription, itemTags) AGAINST ('$search')");
		return !empty($result_array) ? $result_array : false;
  }
  
  //BEGIN OBJECT INSTANTIATION
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
	  foreach(self::$itemPost_fields as $field) {
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
  //END OBJECT INSTANTIATION
	
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
		$attributes = $this->sanitized_attributes(self::$itemPost_fields);
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->itemID = $database->insert_ID();
		$this->userID = $_SESSION['userID'];
		
		$hashedItemID = hash('sha256', $this->itemID);
		$hashedUserID = hash('sha256', $this->userID);
		
		$this->create_directory($hashedUserID, $hashedItemID);
		return true;
	  } else {
	    return false;
	  }
	}// END create()
	
	public function create_directory($hashedUserID='', $hashedItemID=''){
		if (mysql_affected_rows() == 1) { // Success!				
				echo "<span style = \"color:green; font-size: .9em; font-weight: bold;\">User Registration Successful!</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style = \"color:gray; font-size: .9em;\">Press \"CANCEL\" to go back to your settings.</span>";
				//IF FOLDER NAMED BY $hashedUserID ALREADY EXIST, DELETE IT AND MAKE NEW FOLDER WITH THE SAME NAME				
				$directory = "uploads/$hashedUserID/Items/$hashedItemID";
				if(file_exists($directory)){					
					$directories = scandir($directory);
					$excluded = array('.','..');
					$result_dir = array_diff($directories, $excluded);
						if(!empty($result_dir)){
							foreach(glob($directory.'*.*') as $file){unlink($file);}
						}
					rmdir($directory);
					mkdir($directory, 0755);
					redirect_to("itemView.php");
				}else{mkdir($directory, 0755);} // Create directory(folder) with $hashedUserID to hold each user's uploaded images		
				$_SESSION['successItemPost'] = "Congratulations! You have successfully posted a new item to Davao Webgate";
				redirect_to("itemView.php");
		}else {echo "<span style = \"color:red; font-size: .9em; font-weight: bold;\">Item Posting Failed!</span>";}
	
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
		$sql .= " WHERE itemID=".$database->PrepSQL($_SESSION['itemID']);
		$sql .= " AND userID=".$database->PrepSQL($_SESSION['userID']);
		if($database->query($sql)){
			if($database->affected_rows() == 1){
				$t = hash("sha512", time());
				$iid = $_SESSION['itemID'];
				$uid = hash('sha512', $_SESSION['itemID']);
				$q = hash('sha512', $_SESSION['userID']);
				$_SESSION['successitemUpdate'] = "Item Details successfully updated!";
				redirect_to("itemUpdate.php?t=$t&uid=$uid&iid=$iid&q=$q");
			} 
			else{redirect_to("itemUpdate.php?t=$t&uid=$uid&iid=$iid&q=$q");}			
		}

	}//END 	update()
		
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE itemID=". $database->PrepSQL($this->itemID);
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
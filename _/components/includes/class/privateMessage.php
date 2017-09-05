
<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once("database.php");

class PrivateMessage{	
	protected static $table_name="tbl_privatemessage";
	protected static $privatemessage_fields = array('privateMessageID', 'messageSubject','privateMessage', 'privateMessagePostDate', 'itemID', 'fromUserID', 'toUserID', 'fromUserMail');
		
	public $privateMessageID;
	public $messageSubject;
	public $privateMessage;
	public $privateMessagePostDate;
	public $itemID;
	public $fromUserID; //used in $_SESSION['userID']
	public $toUserID; //$userID
	public $fromUserMail;

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
  
  public static function find_by_receiver($toUserID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE toUserID={$toUserID} ORDER BY privateMessagePostDate DESC");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_sender($fromUserID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE fromUserID={$fromUserID} ORDER BY privateMessagePostDate DESC");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_userMail($fromUserMail=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE fromUserMail={$fromUserMail}");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_itemID($itemID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE itemID={$itemID}");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_latest($rows=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY privateMessagePostDate DESC LIMIT $rows");
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
	  foreach(self::$privatemessage_fields as $field) {
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

  //END OBJECT INSTANTIATION
	
	public function save() {
	  // A new record won't have an userID yet.
	  return isset($this->userID) ? $this->update() : $this->create();
	}
	
	public function sendPrivateMessage() {
		global $database;
		$attributes = $this->sanitized_attributes(self::$privatemessage_fields);
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($database->query($sql)) {
			$this->privateMessageID = $database->insert_ID();
			return true;
		}else {return false;}
	}// END sendPrivateMessage()

		
	public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE privateMessageID=". $database->PrepSQL($this->privateMessageID);
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
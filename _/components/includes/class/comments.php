<?php
require_once("database.php");

class Comments{	
	protected static $table_name="tbl_itemcomments";
	protected static $comment_fields = array('commentID', 'comment', 'commentPostDate', 'itemID', 'userID', 'userName');
		
	public $commentID;
	public $comment;
	public $commentPostDate;
	public $itemID;
	public $userID;
	public $userName;
	

	// Common Database Methods
	public static function find_all() {
		return self::find_by_sql("SELECT * FROM ".self::$table_name);
  }
  
  public static function find_by_userID($userID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE userID={$userID}");
		return !empty($result_array) ? $result_array : false;
  }
   public static function find_by_itemID($itemID=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE itemID={$itemID} ORDER BY commentPostDate DESC");
		return !empty($result_array) ? $result_array : false;
  }
  public static function find_by_latest($rows=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY commentPostDate DESC LIMIT $rows");
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
	  foreach(self::$comment_fields as $field) {
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
	//BEGIN INSERTING COMMENT
	public function create() {
		global $database;
		$attributes = $this->sanitized_attributes(self::$comment_fields);
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= join(", ", array_keys($attributes));
	  $sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
	  if($database->query($sql)) {
	    $this->commentID = $database->insert_ID();
		$this->userID = $_SESSION['userID'];
		
		$hashedCommentID = hash('sha256', $this->commentID);
		$hashedUserID = hash('sha256', $this->userID);
		return true;
	  } else {
	    return false;
	  }
	}// END create()

	//BEGIN UPDATING COMMENT
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
				$bid = $_SESSION['itemID'];
				$uid = hash('sha512', $_SESSION['itemID']);
				$q = hash('sha512', $_SESSION['userID']);
				$_SESSION['successcommentUpdate'] = "Comment successfully updated!";
				
				//FIND A BETTER WAY TO USE THIS FUNCTION FOR COMMENT MANIPULATION
				redirect_to("businessUpdate.php?t=$t&uid=$uid&bid=$bid&q=$q");
			} 
			else{redirect_to("businessUpdate.php?t=$t&uid=$uid&bid=$bid&q=$q");}			
		}

	}//END 	update()
		
	public function delete() {
		global $database;

	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE businessID=". $database->PrepSQL($this->businessID);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? redirect_to('../../../member.php'): false;
	
	}//END DELETE
	


}//END CLASS COMMENT

		

?>
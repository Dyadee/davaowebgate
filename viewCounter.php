<?php  
// include your MySQL database connection script here 
require_once "connect_to_mysql.php"; 
// Build sql command 
$sqlCommand = "UPDATE myTable SET views=(views + 1) WHERE id='$this_page_id'";  
// Execute the query here now to add one to the page view count  
$query = mysql_query($sqlCommand) or die (mysql_error());  
?>
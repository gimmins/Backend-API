<?php
namespace Database;

class DB {
  var $link;
  var $db;

  function __construct() {
    // connect to the mysql database
    $hostname = "gimminsTask.db.2298391.hostedresource.com";
	$username = "gimminsTask";
	$dbname = "gimminsTask";
	
	$password = "Rheoel1978!";
	$usertable = "your_tablename";
	$yourfield = "your_field";
	
    $this->link = mysql_connect($hostname, $username, $password) OR DIE ("Unable to connect to database! Please try again later.");
	mysql_select_db($dbname, $this->link) or die(mysql_error());

    mysql_set_charset('utf8', $this->link);
  }

  public function query($sql) {
    $result = mysql_query($sql, $this->link);
    return $result;
  }

  public function close() {
    mysql_close($this->link);
  }
}

<?php
namespace RESTfulApi;

class ThreadsController
{
  public $db;

  function __construct($db) {
    $this->db = $db;
  }

  // URL Pattern: /topics/{id}/threads
  // METHOD:	  GET
  public function getAction($table, $id) {
    if (strcmp($table, 'threads') == 0) {
      $sql = "SELECT * FROM `$table` WHERE `thread_topic`=$id";
      return $this->db->query($sql);
    }

    return null;
  }

  // URL Pattern: /topics/{id}/threads
  // METHOD: 	  POST
  // BODY:		  user, thread
  public function setAction($table, $id, $body) {
  	$user_id = $body['user'];
	$thread_subject = $body['thread'];
	
    if (strcmp($table, 'threads') == 0) {
      $sql = 'INSERT INTO `threads` (`thread_subject`, `thread_by`, `thread_topic`)';
      $values = " VALUES ('$thread_subject', '$user_id', '$id')";
	  
	  $result = $this->db->query($sql . $values);
	  
	  if ($result) {
	  	$sql = "SELECT * FROM $table ORDER BY `thread_id` DESC LIMIT 1";
		  
		return $this->db->query($sql);
	  }
    }
  }
}

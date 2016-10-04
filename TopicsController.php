<?php
namespace RESTfulApi;

class TopicsController
{
  public $db;

  function __construct($db) {
    $this->db = $db;
  }

  // URL Pattern: /topics
  // METHOD:	  GET
  public function getAction($table) {
    if (strcmp($table, 'topics') == 0) {
      $sql = "SELECT * FROM `$table`";
      return $this->db->query($sql);
    }

    return null;
  }

  // URL Pattern: /topics
  // METHOD: 	  POST
  // BODY:		  user, topic
  public function setAction($table, $body) {
  	$user_id = $body['user'];
	$topic_subject = $body['topic'];
		
    if (strcmp($table, 'topics') == 0) {
      $sql = 'INSERT INTO `topics` (`topic_subject`, `topic_by`)';
      $values = " VALUES ('$topic_subject', '$user_id')";
	  
	  $result = $this->db->query($sql . $values);
	  
	  if ($result) {
	  	$sql = "SELECT * FROM $table ORDER BY `topic_id` DESC LIMIT 1";
		  
		return $this->db->query($sql);
	  }
    }
  }
}

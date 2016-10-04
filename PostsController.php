<?php
namespace RESTfulApi;

class PostsController
{
  public $db;

  function __construct($db) {
    $this->db = $db;
  }

  // URL Pattern: /topics/{topic_id}/threads/{thread_id}/posts
  // METHOD:	  GET
  public function getAction($table, $id) {
  	if (strcmp($table, 'posts') == 0) {
      $sql = "SELECT * FROM `$table` WHERE `post_thread`=$id";
      return $this->db->query($sql);
    }

    return null;
  }

  // URL Pattern: /topics/{topic_id}/threads/{thread_id}/posts
  // METHOD:	  POST
  // BODY:		  user, post
  public function setAction($table, $id, $body) {
  	$user_id = $body['user'];
	$post_subject = $body['post'];
	
    if (strcmp($table, 'posts') == 0) {
      $sql = 'INSERT INTO `posts` (`post_content`, `post_by`, `post_thread`)';
      $values = " VALUES ('$post_subject', '$user_id', '$id')";
	  
	  $result = $this->db->query($sql . $values);
	  
	  if ($result) {
	  	$sql = "SELECT * FROM $table ORDER BY `post_id` DESC LIMIT 1";
		  
		return $this->db->query($sql);
	  }
    }
  }

	// /tasks POST
  public function setReply($table, $id, $body) {
  	$user_id = $body['user'];
	$reply_subject = $body['reply'];
	$reply_date = $body['date'];
	
	// Sanity check
    if (strcmp($table, 'posts') == 0) {
      $sql = 'INSERT INTO `replies` (`reply_content`, `reply_date`, `reply_by`, `reply_post`)';
      $values = " VALUES ('$reply_subject', '$reply_date', '$user_id', '$id')";
	  $result = $this->db->query($sql . $values);
    }
  }

// url = '/tasks' method = GET
  public function getReplies($table, $id) {
  	if (strcmp($table, 'posts') == 0) {
      $sql = "SELECT * FROM `replies` WHERE `reply_post`=$id";
	  return $this->db->query($sql);
    }

    return null;
  }
}

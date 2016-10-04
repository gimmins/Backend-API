<?php
namespace RESTfulApi;

class AnalyticsController
{
  public $db;

  function __construct($db) {
    $this->db = $db;
  }

  // url = '/tasks' method = GET
  public function getAction($request) {
  	if (strcmp($request, 'total') == 0) {
      $sql1 = "SELECT `post_date`, COUNT(`post_date`) FROM `posts` GROUP BY `post_date`";
      $res1 = $this->db->query($sql1);
	  $sql2 = "SELECT `reply_date`, COUNT(`reply_date`) FROM `replies` GROUP BY `reply_date`";
	  $res2  = $this->db->query($sql2);

	  return array_merge($res1->fetch_all(), $res2->fetch_all());
    }

    return null;
  }
}

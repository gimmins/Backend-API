<?php
namespace Database;

class ForumsDB {
  var $link;

  function __construct() {
    // connect to the mysql database
    $this->link = mysqli_connect('localhost', 'root', 'sofasession', 'forum');
    mysqli_set_charset($this->link, 'utf8');
  }

  public function query($sql) {
    $result = mysqli_query($this->link, $sql);
    return $result;
  }

  public function close() {
    mysqli_close($this->link);
  }
}

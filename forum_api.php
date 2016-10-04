<?php
namespace Api;

include 'AnalyticsController.php';
include 'TopicsController.php';
include 'TopicsBuilder.php';
include 'ThreadsController.php';
include 'ThreadsBuilder.php';
include 'PostsController.php';
include 'PostsBuilder.php';
include 'ForumsDB.php';

use RESTfulApi;
use JSONFormatter;
use Database;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// get the HTTP method, path and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

$db = new \Database\ForumsDB();
$analytics_controller = new \RESTfulApi\AnalyticsController($db);
$topics_controller = new \RESTfulApi\TopicsController($db);
$topics_builder = new \JSONFormatter\TopicsBuilder();
$threads_controller = new \RESTfulApi\ThreadsController($db);
$threads_builder = new \JSONFormatter\ThreadsBuilder();
$posts_controller = new \RESTfulApi\PostsController($db);
$posts_builder = new \JSONFormatter\PostsBuilder();

switch ($method) {
  case 'GET':
	if(is_array($request) && count($request) == 3) {
		$res = $threads_controller->getAction($request[2], $request[1]);
		$topics_builder->toJson($res);
	}
	else if(count($request) == 5) {
		$res = $posts_controller->getAction($request[4], $request[3]);
		$topics_builder->toJson($res);
	} 
	else if(count($request) == 6) {
		$res = $posts_controller->getReplies($request[4], $request[5]);
		$topics_builder->toJson($res);
	} 
	else {
		if ($request[0] == 'analytics') {
			$res = $analytics_controller->getAction($request[1]);
			$i = 0;
			echo '[';
			foreach($res as $r) {
				echo ($i>0?',':'').json_encode($r);
				$i++;
			}
			echo ']';
		} else {
			$res = $topics_controller->getAction($request[0]);
			$topics_builder->toJson($res);
		}
	}
    break;
  case 'POST':
	if(is_array($request) && count($request) == 3) {
		$res = $threads_controller->setAction($request[2], $request[1], $input);
		$threads_builder->toJson($res);
	}
	else if(count($request) == 5) {
		$res = $posts_controller->setAction($request[4], $request[3], $input);
		$posts_builder->toJson($res);
	}
	else if(count($request) == 6) {
		$res = $posts_controller->setReply($request[4], $request[5], $input);
	} 
	else {
		$res = $topics_controller->setAction($request[0], $input);
		$topics_builder->toJson($res);
	}
    break;
  case 'PATCH':
    $res = $topics_controller->patchAction($request[0], $request[1], $input);
    break;
}

$db->close();

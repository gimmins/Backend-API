<?php
namespace Api;

set_include_path('.;C:\php\pear');
include 'TasksController.php';
set_include_path('.;C:\php\pear');
include 'TasksBuilder.php';
include 'DB.php';

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

$db = new \Database\DB();
$tasks_controller = new \RESTfulApi\TasksController($db);
$tasks_builder = new \JSONFormatter\TasksBuilder();

switch ($method) {
  case 'GET':
    $res = $tasks_controller->getAction($request);
	$tasks_builder->toJson($res);
    break;
  case 'POST':
    $res = $tasks_controller->setAction($request, $input);
    break;
  case 'PATCH':
    $res = $tasks_controller->patchAction($request[0], $request[1], $input);
    break;
}

$db->close();

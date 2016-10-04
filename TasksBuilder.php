<?php
namespace JSONFormatter;

class TasksBuilder 
{
	public function toJson($tasks) {
		if($tasks) {
			echo '[';
		for ($i=0; $i<mysql_num_rows($tasks); $i++) {
	    	echo ($i>0?',':'').json_encode(mysql_fetch_object($tasks));
	  	}
		echo ']';	
		}
	}
	
	public function toError() {
		
	}
}

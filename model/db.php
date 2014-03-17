<!--db.php-->
<?php

require_once("../config/config.inc");


function db_connect() {
	$dbconn = pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DB_NAME." user=".DB_USERNAME." password=".DB_PASSWORD);
	if(!$dbconn){
		echo("Can't connect to the database");	
		exit;
	}
	return $dbconn;
}


















?>
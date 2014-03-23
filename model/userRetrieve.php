<?php
	require_once("db.php");
	require_once("../config/config.inc");
	session_save_path(SESSION_SAVED);
	session_start();
	header('Content-Type: application/json');

	$reply = array();

    $reply['receive'] = true;

	if (isset($_SESSION['valid_user'])) {
		$user = array();
		$reply['status'] = "Success";
		$name = $_SESSION['valid_user'];

		//connect and query the database
		$dbconn = db_connect();
		$result = pg_prepare($dbconn, "", 'SELECT * FROM users WHERE name = $1');
		$result = pg_execute($dbconn, "", array("$name"));
		
		if (!$result) {
			$reply['status'] = "Error";
			goto end;
		}

		//check the database's return result
		while ($row = pg_fetch_array($result)) {
			$user['id'] = $row['id'];
			$user['name'] = $name;
			$user['level'] = $row['level'];
			$user['exp'] = $row['exp'];
			$user['email'] = $row['email'];
		}

		$reply['user'] = $user;
		
	} else {
		$reply['status'] = "Error";
	}		
		
	
	end:
	echo json_encode($reply);
?>
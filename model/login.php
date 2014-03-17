<?php
	require_once("db.php");
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	$reply = array();
	if (isset($_REQUEST['username']) && (isset($_REQUEST['password']))) {
		$name = $_REQUEST['username'];
		$pwd = $_REQUEST['password'];

		$dbconn = db_connect();
		$result = pg_prepare($dbconn, "", 'SELECT * FROM users WHERE name = $1');
		$result = pg_execute($dbconn, "", array("$name"));

		while ($row = pg_fetch_array($result)) {
			if ($row['password'] == md5($pwd)) {
				$reply['valid_user'] = $name;
				$reply['status'] = "ok"; //success
			} else {
				$reply['status'] = "Error: invalid password";
			}
		}

		if (!isset($reply['status'])) {
			$reply['status'] = "Error: user does not exist";
		}
	} else {
		$reply['status'] = "no user";
	}
	
	print json_encode($reply);

?>
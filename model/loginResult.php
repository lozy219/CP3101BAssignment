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
				// $reply['valid_user'] = $name;
				$_SESSION['valid_user'] = $name;
				$reply['status'] = "Success"; //success
			} else {
				$reply['status'] = 'Error';
				$reply['message'] = 'Invalid password';
			}
		}

		if (!isset($_SESSION['valid_user']) && !isset($reply['status'])) {
			$reply['status'] = 'Error';
			$reply['message'] = 'User does not exist';
		}
	} 
	
	print json_encode($reply);

?>
<?php
	require_once("db.php");
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	$reply = array();
	$reply['receive'] = false;

	if (isset($_REQUEST['login'])) {
		$reply['receive'] = true;
		$data = json_decode($_REQUEST['login'], true);
		// get the login data
		$name = $data['name'];
		$pwd = $data['password'];

		$reply['name'] = $name;
		$reply['password'] = $pwd;
		// //connect and query the database
		$dbconn = db_connect();
		$result = pg_prepare($dbconn, "", 'SELECT * FROM users WHERE name = $1');
		$result = pg_execute($dbconn, "", array("$name"));

		// //check the database's return result
		while ($row = pg_fetch_array($result)) {
			if ($row['password'] == sha1($pwd)) {
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
	
	echo json_encode($reply);

?>
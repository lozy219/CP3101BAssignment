<?php
	require_once("db.php");
	require_once("../config/config.inc");
	session_save_path(SESSION_SAVED);
	session_start();
	header('Content-Type: application/json');

	$reply = array();
	$reply['receive'] = false;

	if (isset($_REQUEST['login'])) {
		$reply['receive'] = true;
		$reply['message'] ='';
		$data = json_decode($_REQUEST['login'], true);
		// get the login data
		$name = $data['name'];
		$pwd = $data['password'];
		//connect and query the database
		$dbconn = db_connect();
		$result = pg_prepare($dbconn, "", 'SELECT * FROM users WHERE name = $1');
		$result = pg_execute($dbconn, "", array("$name"));

		//check the database's return result
		while ($row = pg_fetch_array($result)) {
			if ($row['password'] == sha1($pwd)) {
				$_SESSION['valid_user'] = $name;
				$_SESSION['valid_id'] = $row['id'];
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
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
		$data = json_decode($_REQUEST['regi'], true);
		// get the user info
		$name = $data['name'];
		$pwd = $data['password'];
		$email = $data['email'];
		// //connect and query the database
		$dbconn = db_connect();		
		$result = pg_prepare($dbconn, "", 'INSERT INTO tasks VALUES(nextval(\'user_id_seq\'), $1 , $2 , $3, $4, $5)');
		$result = pg_execute($dbconn, "", array($name, sha1($pwd), 1, 0, $email));

		if ($result) {
			$reply['status'] = "Success";
		} else {
			$reply['status'] = "Error";
		}
		
		// login
		$_SESSION['valid_user'] = $name;
	}

	echo json_encode($reply);
?>
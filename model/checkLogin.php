<?php
	require_once("db.php");
	require_once("../config/config.inc");
	session_save_path(SESSION_SAVED);
	session_start();
	header('Content-Type: application/json');

	$reply = array();
	if (isset($_SESSION['valid_user'])) {
		$reply['status'] = "true";
	} else {
		$reply['status'] = "false";
	}
	
	print json_encode($reply);

?>
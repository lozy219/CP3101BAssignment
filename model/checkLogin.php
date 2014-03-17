<?php
	require_once("db.php");
	session_save_path("sess");
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
<?php
	require_once("../config/config.inc");

	session_save_path(SESSION_SAVED);
	session_start();
	header('Content-Type: application/json');

	$reply = array();
	if (isset($_REQUEST['logout'])) {
		//destroy session, log out
		unset($_SESSION['valid_user']);
		unset($_SESSION['valid_id']);
		$reply['status'] = 'Success';
	} else {
		$reply['status'] = 'Error';
		$reply['message'] = 'Wrong log out request';
	}
	print json_encode($reply);

?>
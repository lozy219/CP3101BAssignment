<?php
	session_save_path("sess");
	session_start();
	header('Content-Type: application/json');

	$reply = array();
	// if (isset($_REQUEST['logout'])) {
	// 	//destroy session, log out
	// 	unset($_SESSION['valid_user']);
	// 	$reply['status'] = 'Success';
	// } else {
	// 	$reply['status'] = 'Error';
	// 	$reply['message'] = 'Wrong log out request';
	// }
unset($_SESSION['valid_user']);
	print json_encode($reply);

?>
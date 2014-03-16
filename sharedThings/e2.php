<?php
	session_start(); 
	header('Content-Type: application/json');


	// receive the ajax get request
	if (isset($_REQUEST['state'])) {

		//decode the data and store in the session
		$get = json_decode($_REQUEST['state']);
		$_SESSION['data'] = $get;
	}

	//return back the encode json data
	echo json_encode($_SESSION['data']);

?>
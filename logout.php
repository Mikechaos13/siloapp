<?php 
	require_once 'framework/models/user.php';
	session_start();

	$_SESSION['user'] = array();
	session_destroy();

	header('location: /');
	die();
 ?>
<?php
	include '../../models/user.php';
	session_start();
	if( $utilisateur = (new User())->authentificate_user( $_REQUEST['user'], $_REQUEST['password'] ) ) {
		$_SESSION['user'] = $utilisateur;

		header('location: / ');
	} else {
		header('location: /?page=login&error=1');
	}
?>
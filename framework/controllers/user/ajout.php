<?php 
	include '../../models/user.php';
	error_log('USER AJOUT -->'.$_POST['name']);
	if( !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['validation']) ) {
		if((new User())->register_user( $_POST['name'], $_POST['type'], $_POST['password'], $_POST['validation'] ))
			header('location: /?page=utilisateurs ');
		else
			header('location: /?page=utilisateurs&error=2 ');
	}else {
		header('location: /?page=utilisateurs&error=1 ');
	}
 ?>
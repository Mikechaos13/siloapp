<?php 
	include '../../models/user.php';

	if( !empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['validation']) ) {
		$user = (new User())->_find($_POST['utilisateur']);
		if( $_POST['password'] == $_POST['validation']) {
			$user->_update( array( "name" => $_POST['name'], "type_id"=>$_POST['type'], "password" => sha1(md5($_POST['password'])) ) );
			header('location: /?page=utilisateurs ');
		}
		else
			header('location: /?page=utilisateurs&edit='.$_POST['utilisateur'].'&error=2 ');
	}else {
		header('location: /?page=utilisateurs&edit='.$_POST['utilisateur'].'&error=1 ');
	}
 ?>
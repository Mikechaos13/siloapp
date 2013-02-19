<?php 
	include '../../models/user.php';

	if( isset($_POST['id']) ) {
		$user = (new User())->_find($_POST['id'])->_delete();
		if( $user ) {
			echo '0';
		}
		else
			echo "1";
	}else {
		echo "1";
	}
 ?>
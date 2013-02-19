<?php
	require_once '../../models/affectation.php';
	require_once '../../models/distribution.php';
	require_once '../../models/user.php';
	session_start();

	if(isset($_POST['employees_choisi'])) {
		$affectation = (new Affectation())->_nouvelle_affectation( $_POST['job'], $_POST['superviseur'], $_POST['employees_choisi'], $_POST['date'] );
 		
 		if($affectation){
 			header('location: /?date='.$_POST['date']);
 			die();
 		}
 		else {
 			header('location: /?date='.$_POST['date'].'&error=2');
 			die();
 		}
 	}
 	
 	header('location: /?date='.$_POST['date'].'&error=1');
 ?>
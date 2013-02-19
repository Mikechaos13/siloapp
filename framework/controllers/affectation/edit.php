<?php
	require_once '../../models/affectation.php';
	require_once '../../models/distribution.php';

	if(!isset($_POST['employees_choisi'])) {
		$_POST['employees_choisi'] = array();
	}
		$affectation = (new Affectation())->_edit_affectation( $_POST['id'], $_POST['job'], $_POST['superviseur'],$_POST['employees_choisi'] );
 	
 	header('location: /?date='.$_POST['date']);
 ?>
<?php 
	require_once '../../models/affectation.php';
	require_once '../../models/distribution.php';

	if(isset($_POST['id'])) {
		$affectation = (new Affectation())->_delete_affectation( $_POST['id'] );
	}
 ?>
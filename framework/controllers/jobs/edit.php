<?php 
	include '../../models/job.php';

	if( !empty($_POST['name']) && !empty($_POST['job']) ) {
		$job = (new Job())->_find($_POST['job']);
		$job->_update( array( "name" => $_POST['name'], "client" => $_POST['client'] ) );
			header('location: /?page=jobs ');
	}else {
		header('location: /?page=jobs&edit='.$_POST['job'].'&error=1 ');
	}
 ?>
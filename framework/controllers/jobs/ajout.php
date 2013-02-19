<?php 
	include '../../models/job.php';

	if( !empty($_POST['name']) && !empty($_POST['client']) )
		$job = (new Job())->_create( array("name" => $_POST['name'], "client" => $_POST['client']) );
	else
		header('location: /?page=jobs&error=1 ');

	if($job)
		header('location: /?page=jobs ');
	else
		header('location: /?page=jobs&error=1 ');
 ?>
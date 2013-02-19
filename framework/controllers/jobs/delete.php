<?php 
	include '../../models/job.php';

	if( isset($_POST['id']) ) {
		$job = (new Job())->_find($_POST['id'])->_delete();
		if( $job ) {
			echo '0';
		}
		else
			echo "1";
	}else {
		echo "1";
	}
 ?>
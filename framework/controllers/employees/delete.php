<?php 
	include '../../models/employee.php';

	if( isset($_POST['id']) ) {
		$employe = (new Employee())->_find($_POST['id'])->_delete();
		if( $employe ) {
			echo '0';
		}
		else
			echo "1";
	}else {
		echo "1";
	}
 ?>
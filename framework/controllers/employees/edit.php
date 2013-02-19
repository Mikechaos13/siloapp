<?php 
	include '../../models/employee.php';

	if( !empty($_POST['name']) && !empty($_POST['type_id']) ) {
		$employee = (new Employee())->_find($_POST['employee']);
		$employee->_update( array( "name" => $_POST['name'], "type_id" => $_POST['type_id'] ) );
			header('location: /?page=employes ');
	}else {
		header('location: /?page=employes&edit='.$_POST['employee'].'&error=1 ');
	}
 ?>
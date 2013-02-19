<?php 
	include '../../models/employee.php';
	
	if( !empty($_POST['name']) && !empty($_POST['type_id']) )
		$employee = (new Employee())->_create( array("name" => $_POST['name'], "type_id" => $_POST['type_id']) );
	else
		header('location: /?page=employes&error=1 ');

	if($employee)
		header('location: /?page=employes ');
	else
		header('location: /?page=employes&error=2 ');
 ?>
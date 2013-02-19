<?php 
	/**
	* 
	*/
	require_once 'model.php';
	class Employee extends Model
	{
		protected $id;
		protected $name;
		protected $type_id;

		function __construct() {
			$this->link('Employees');
		}

		function type_user($other_type_id = null) {
			$type = [
						"1" => "Contre-Maître",
						"2" => "Senior",
						"3" => "Junior"
					];

			return ( isset($type[$other_type_id]) ? $type[$other_type_id] : $type[$this->type_id] );
		}

		function return_type_user() {
			$type = [
						"1" => "Contre-Maître",
						"2" => "Senior",
						"3" => "Junior"
					];

			return $type;
		}
	}
 ?>
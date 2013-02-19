<?php 
	/**
	* 
	*/
	require_once 'model.php';
	class Distribution extends Model
	{
		protected $id;
		protected $affectation_id;
		protected $employee_id;

		function __construct()
		{
			$this->link('Distributions');
			$this->belongs_to('Affectations', 'affectation_id');
			$this->belongs_to('Employees', 'employee_id');
			//$this->has_many('delegation', 'affectation');
		}
	}
 ?>
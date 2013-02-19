<?php 
	/**
	* 
	*/
	include 'model.php';
	class Job extends Model
	{
		protected $id;
		protected $name;
		protected $client;

		function __construct()
		{
			$this->link('Jobs');
		}
	}
 ?>
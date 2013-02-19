<?php 
	/**
	* 
	*/
	require_once 'model.php';
	class Affectation extends Model
	{
		protected $id;
		protected $job_id;
		protected $superviseur_id;
		protected $date;
		protected $comment;
		protected $user_id;

		function __construct()
		{
			$this->link('Affectations');
			$this->belongs_to('Jobs', 'job_id');
			$this->belongs_to('Employees', 'superviseur_id');
			$this->has_many('Distributions', 'affectation_id');
		}

		function _nouvelle_affectation( $job_id = null, $superviseur_id = null, $employees = array(), $date = null ) {
			if( !is_null($job_id) && !is_null($superviseur_id) && !empty($employees) ) {
				if( is_null($date) ) {
					$date = date('Y-m-d');
				}

				$affectation = $this->_create( array("job_id"=>$job_id, "superviseur_id"=>$superviseur_id, "date"=>$date, "user_id"=>$_SESSION['user']->id ) );
		 		foreach ($employees as $employe) {
		 			$distrib = (new Distribution())->_create( ["affectation_id"=>$affectation->id, "employee_id"=>$employe] ); 			
		 		}

		 		return true;
			}

			return false;
		}

		function _edit_affectation( $id =null, $job_id = null, $superviseur_id = null, $employees_choisi = array() ) {
			if( !is_null($id) && !is_null($job_id) && !is_null($superviseur_id) ) {
				$affectation = $this->_find($id);

				$employee_courant = array();
				foreach($affectation->_map('distribution') as $distribution)
				{
					$employee_courant[] = $distribution->employee_id;
				}
				$to_add    = array_diff($employees_choisi, $employee_courant);
				$to_delete = array_diff($employee_courant, $employees_choisi);

				foreach($to_add as $value){
					$new_employee = (new Distribution())->_create(["affectation_id"=>$id, "employee_id"=>$value]);
				}

				foreach($to_delete as $value){
					$delete_employee = (new Distribution())->_where(["affectation_id"=>$id, "employee_id"=>$value])->_first()->_delete();
				}

				$affectation->_update(["job_id"=>$job_id, "superviseur_id"=>$superviseur_id]);
				
			}
		}

		function _delete_affectation( $id = null ) {
			if( !is_null($id) ){
				$affectation = $this->_find($id);

				foreach( $affectation->_map('distribution') as $distribution ) {
					$distribution->_delete();
				}  

				$affectation->_delete();
			}
		}
	}
 ?>
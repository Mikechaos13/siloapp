<?php 
	/**
	* 
	*/
	require_once 'model.php';
	class User extends Model
	{
		protected $id;
		protected $name;
		protected $password;
		protected $type_id;

		function __construct() {
			$this->link('Users');
		}

		function authentificate_user( $user = null, $pass = null ) {
			if( !is_null( $user ) && !is_null( $pass )) {
				$user = $this->_where( array( 'name' => $user, 'password' => sha1(md5($pass)) ) );

				if( !empty($user->_first()->id)  ) {
					return $user->_first()->_values( array( 'password' => '' ) );
				}
				else { return false; }
			}

			return false;
		}

		function register_user( $user = null, $type = 1, $pass = null, $pass_verif ) {
			if( !is_null( $user ) && !is_null( $pass ) && !is_null( $pass_verif ) && $pass == $pass_verif ) {
				$return = $this->_create( array('name' => $user, 'type_id'=>$type ,'password' => sha1(md5($pass)) ) );
				if( $return ) {
					return true;
				}
			}	

			return false;
		}

		function type_user($other_type_id = null) {
			$type = [
						"1" => "Administrateur",
						"2" => "Dispatch",
						"3" => "Secrétaire"
					];

			return ( isset($type[$other_type_id]) ? $type[$other_type_id] : $type[$this->type_id] );
		}

		function return_type_user() {
			$type = [
						"1" => "Administrateur",
						"2" => "Dispatch",
						"3" => "Secrétaire"
					];

			return $type;
		}

	}
 ?>
<?php
 abstract class Model
 {
	 private $the_query;
	 private $map = array();
	 private $link_to;

	 

	 function __construct() {;}

	 public static function _new(){
	 	$obj = self::new_object();
		foreach( get_class_vars( get_class( $obj ) ) as $key => $value ) {
			 $obj->$key = $value;
		}
		
		return $obj;
	 }

	 function _save() {
	 	if( isset($this->id) ) {
		 	$this->update_object();
	 	}
	 	else {
		 	$this->add_object();
	 	}

	 	return $this;
	 }

	 function _all() {
		 $objects = $this->all_objects();

		 return $objects;
	 }

	 function _find() {
	 	 $ids = func_get_args();

	 	 if( sizeof($ids) > 1 ) {
		 	 return $this->specific_objects( $ids );
	 	 }
	 	 else {
		 	 $id = $ids[0];
		 	 return $this->single_object( $id );
	 	 }

	 }
	 function _where( $array = array() ) {
		$CLASS_NAME = $this->link_to;

	 	if(!empty($array)) {
	 		$where = 'WHERE ';
	 		foreach( $array as $key=>$value) {
	 			$where.=$key.' = "'.$value.'" AND ';
	 		}

	 		$where = substr($where, 0, -4);

	 		$query = 'SELECT '.$CLASS_NAME.'.* FROM '.$CLASS_NAME.' '.$where;
	 		$this->the_query = $query;
			return $this->multiple_objects( $query );
	 	}
	 	else {
	 		throw new Exception("You need to enter parameter", 1);
	 	}
	 }

	 function _query( $query = null ) {
	 	if( !is_null($query) ){
	 		return $this->multiple_objects($query);
	 	}
	 }

	 function _sql( $array = array() ) {
	 	if(!empty($array)) {
	 		$where = '';
	 		$order = '';
	 		$limit = '';

	 		if(isset($array['where'])) {
		 		$where = 'WHERE ';
		 		foreach( $array['where'] as $value) {
		 			$where .= $value['key'].' '.$value['compare'].' "'.$value['value'].'" AND ';
		 		}

		 		$where = substr($where, 0, -4);
		 	}
		 	if( isset($array['order']) ){
		 		$orderby = (isset($array['order']['by'])?$array['order']['by']:'DESC');
		 		$order = 'ORDER BY '.$array['order']['key'].' '.$orderby;
		 	}
		 	if( isset($array['limit']) ){
		 		$limit = 'LIMIT '.$array['limit']['x'];
		 		if( $array['limit']['y'] ){
		 			$limit .= ', '.$array['limit']['y'];
		 		}
		 	}
		 	$CLASS_NAME = $this->link_to;

	 		$query = 'SELECT '.$CLASS_NAME.'.* FROM '.$CLASS_NAME.' '.$where.' '.$order.' '.$limit;
	 		$thi->the_query = $query;
			return $this->multiple_objects( $query );
	 	}
	 	else {
	 		throw new Exception("You need to enter parameter", 1);
	 	}
	 }

	 function _limit( $nombre = 10, $paged = 1 ) {
	 	$CLASS_NAME = $this->link_to;
 		$start = $nombre * ($paged - 1);
 		$query = 'SELECT '.$CLASS_NAME.'.* FROM '.$CLASS_NAME.' LIMIT '.$start.','.$nombre;
 		$this->the_query = $query;
 		return $this->multiple_objects( $query );
	 }

	

	 function _order( $order_by = array() ) {
	 	$CLASS_NAME = $this->link_to;
	 	if( !empty($order_by) ) {
	 		foreach( $order_by as $key=>$value) {
	 			$order = ( !is_int($key) ? $value : 'ASC' );
	 			$order_by = ( !is_int($key) ? $key : $value );
	 			$by.=$order_by.' '.$order.',';
	 		}
	 		$sort = substr($by, 0, -1);
	 		$query = 'SELECT '.$CLASS_NAME.'.* FROM '.$CLASS_NAME.' ORDER BY '.$sort;
	 		$this->the_query = $query;
	 		return $this->multiple_objects( $query );
	 	}
	 	else{
	 		throw new Exception("You need to enter a value to sort by", 1);
	 		
	 	}
	 }	

	 function _create() {
		 $values = func_get_args();
		 if( isset($values) ){
		 	 $sets = '';
			 foreach( $values[0] as $key=>$value ) {
			 	$this->$key = $value;
			 }
			 if($this->add_object())
			 	return $this;

			 return false;
		 }
	 }

	 function _values() {
		 $values = func_get_args();
		 if( isset($values) ){
			 foreach( $values[0] as $key=>$value ) {
			 	$this->$key = $value;
			 }
		 }
		 return $this;
	 }

	 function _count() {
	 	 $CLASS_NAME = $this->link_to;
		 $query = 'SELECT COUNT(id) AS count FROM '.$CLASS_NAME;
		 $STH = Connection::prepare()->query($query);
		 $count = $STH->fetch();

		 return $count['count'];
	 }

	 function _update() {
		 $values = func_get_args();
		 if( isset($values) ){
		 	 $sets = '';
			 foreach( $values[0] as $key=>$value ) {
			 	$this->$key = $value;
			 }
			 $this->update_object();
		 }

		 return $this;
	 }

	 function _delete() {
		 if( isset($this->id) ) {
			 $query = 'DELETE FROM '.$this->link_to.' WHERE id='.$this->id;
			 try {
			 	 $STH = Connection::prepare()->query($query);
				 if( $STH ) {
				 	 unset( $this );
					 return true;
				 }
				 else {
					 return false;
				 }
			 } catch (PDOException $e) {
		  		echo $e->getMessage();
		  	}
		 }
		 else {
			 throw new Exception('You need to delete a specific '.$this->link_to);
		 }
	 }

	 function link( $link ){
	 	$this->link_to = $link;
	 }

	 function _map( $object = null ) {
	 	$CLASS_NAME = $this->link_to;

	 	if( isset($object) )  {
	 		$search = $object::new_object()->link_to;
	 		if( $this->search_for_link($search, "belongs_to") ) {
	 			error_log('BELONGS TO '.$object);
	 			$link = $this->search_for_link($search, "belongs_to");
	 			$query = "SELECT $search.* FROM $search JOIN $CLASS_NAME ON $CLASS_NAME.$link = $search.id WHERE $CLASS_NAME.id = $this->id";
	 			error_log($query);
	 			$new_object = $object::new_object()->single_object_query($query);
	 			
	 			return $new_object;
	 		}
	 		elseif( $this->search_for_link($search, 'has_many') ) {
	 			$link = $this->search_for_link($search, 'has_many');
	 			$query = "SELECT $search.* FROM $search JOIN $CLASS_NAME ON $search.$link = $CLASS_NAME.id WHERE $CLASS_NAME.id = $this->id";

	 			$new_objects = $object::new_object()->multiple_objects($query);

	 			return $new_objects;
	 		}
	 	}
	 }

	 private function search_for_link($object, $link) {
	 	$find = false;
	 	if(isset($this->map[$link]) && !empty($this->map[$link])) {
	 		foreach($this->map[$link] as $specific) {
		 		if(array_search($object, $specific)) {
		 			$find = $specific['link'];	
		 			error_log('FIND--> '.$find);
		 		} 
		 	}
	 	}
	 	
	 	return $find;
	 }

	 function have_one( $object = null, $link = null ) {
	 	if( !is_null($object) && !is_null($link) ) {
	 		$this->map['have_one'][] = array( 'object' => $object, 'link' => $link );
	 	}
	 }

	 function belongs_to( $object = null, $link = null ) {
	 	if( !is_null($object) && !is_null($link) ) {
	 		$this->map['belongs_to'][] = array( 'object' => $object, 'link' => $link );
	 	}
	 }

	 function has_many( $object = null, $link = null ) {
	 	if( !is_null($object) && !is_null($link) ) {
	 		$this->map['has_many'][] = array( 'object' => $object, 'link' => $link );
	 	}
	 }

	 function _first() {
	 	$CLASS_NAME = $this->link_to;
		return $this->single_object_query( 'SELECT '.$CLASS_NAME.'.* FROM '.$CLASS_NAME.' ORDER BY id ASC LIMIT 1' );
	 }	

	 function _last() {
	 	$CLASS_NAME = $this->link_to;
		return $this->single_object_query( 'SELECT '.$CLASS_NAME.'.* FROM '.$CLASS_NAME.' ORDER BY id DESC LIMIT 1' );
	 }

	 function __get( $key ) {
		 if( isset( $key ) ) {
			 return ( isset($this->$key) ? $this->$key : '' );
		 }
		 else {
			 throw new Exception('WOOT nothing found');
		 }
	 }
	 function __set( $key, $value ) {
		 if( isset( $key ) && isset( $value )) {
			 $this->$key = $value;
		 }
		 else {
			 throw new Exception('WOOT You need to modify a specific value');
		}
	 }

	 private function single_object( $id = null ){
		  if( isset( $id ) ) {
		  	$table_name = $this->link_to;
		  	  
		  	try {
		  		$STH = Connection::prepare()->query('SELECT '.$table_name.'.* FROM '.$table_name.' WHERE id='.$id);
		  		$STH->setFetchMode(PDO::FETCH_ASSOC);	

		  		foreach( $STH->fetch() as $key=>$value ) {
						$this->$key = $value;
					}

					return $this;
		  	} catch (PDOException $e) {
		  		echo $e->getMessage();
		  	}
		 }
	 }

	 private function single_object_query( $query = null ) {
	 	if( isset( $query ) ) {
	 		$table_name = $this->link_to;
	 		
	 		try {
		  		$STH = Connection::prepare()->query($query);
		  		$STH->setFetchMode(PDO::FETCH_ASSOC);	

		  		foreach( $STH->fetch() as $key=>$value ) {
						$this->$key = $value;
					}

					return $this;
	  	} catch (PDOException $e) {
	  		echo $e->getMessage();
	  	}
	 	}
	 } 

	 private function specific_objects( $ids = null ){
		  if( isset( $ids ) ){
			 $objects = array();
			 $value = '';
			 foreach( $ids as $id ){
				 $value .= 'id='.$id.' OR ';
			 }
			 $table_name = $this->link_to;
			 $value = substr( $value, 0, strlen($value)-3 );

			 $query = 'SELECT '.$table_name.'.* FROM '.$table_name.' WHERE '.$value;
			 error_log('SELECT '.$table_name.'.* FROM '.$table_name.' WHERE '.$value);
			 return $this->multiple_objects( $query );
		 }
		 else {
			 throw new Exception('Enter valid ID');
		 }
	 }

	 private function all_objects(){
		$query = 'SELECT '.$this->link_to.'.* FROM '.$this->link_to;

		return $this->multiple_objects( $query );
	 }

	 function multiple_objects( $query ){
	 	 $CLASS_NAME = $this->link_to;
		 if( $query ){
		 	$objects = array();
		 	$obj_vide = self::new_object();


	 		try {
	  		$STH = Connection::prepare()->query($query);
	  		$STH->setFetchMode(PDO::FETCH_ASSOC);	

	  		while( $object = $STH->fetch() ){
	  			$obj = self::new_object();
					 foreach( $object as $key => $value ){
						 $obj->$key = $value;
					 }
					 $objects[$obj->id] = $obj;
	  		}

	  		$objects_array = new Model_array($objects);
			 	$objects_array->query($query);
			 	$objects_array->obj($obj_vide);

				return $objects_array;

	  	} catch (PDOException $e) {
	  		echo $e->getMessage();
	  	}
		 }
		 else {
			 throw new Exception('An eror happen when you try to find many '.$CLASS_NAME);
		 }

	 }

	 private function add_object() {
		$keys   = '';
	 	$values = '';
	 	$table_name = $this->link_to;
		foreach( get_class_vars( get_class( $this ) ) as $key=>$value ) {
		 	if( isset( $this->$key ) && $key != 'class_name' && $key != 'map' && $key != 'comment' && $key != 'link_to') {
			 	$keys .= $key.',';
			 	$values .= '\''.$this->$key.'\',';
		 	}
	 	}
	 	$keys = substr($keys, 0, strlen($keys)-1 );
	 	$values = substr($values, 0, strlen($values)-1 );
	 	$query = 'INSERT INTO '.$table_name.' ('.$keys.') VALUES('.$values.')';
	 	$pdo_object = Connection::prepare();
	 	$STH = $pdo_object->query($query);
	 	if( $STH ) {
		 	$this->id = $pdo_object->lastInsertId();
		 	return true;
	 	}
	 	else
	 	{
		 	return false;
	 	}
	 }

	 private function update_object() {
		$sets = '';
		foreach( get_class_vars( get_class( $this ) ) as $key=>$value ) {
		 	if( isset( $this->$key ) && $key != 'class_name' && $key != 'map' && $key != 'comment' && $key != 'link_to' ) {
			 	$sets .= $key.'= \''. $this->$key.'\',';
		 	}
	 	}
	 	$sets = substr($sets, 0, strlen($sets)-1 );
	 	$query = 'UPDATE '.$this->link_to.' SET '.$sets.'WHERE id='.$this->id;
	 	$STH = Connection::prepare()->query($query);

	 	if( $STH ) {
		 	return true;
	 	}
	 	else {
		 	return false;
	 	}
	 }

	 private static function new_object() {
		 return new static();
	 }
 }

 class Model_array extends ArrayObject 
 {	
 	private $query;
 	private $obj;
 	function __construct( $array_data ) {
 		parent::__construct($array_data,ArrayObject::ARRAY_AS_PROPS);
 	}

 	function query($query){
 		$this->query = $query;
 	}

 	function obj($obj) {
 		$this->obj = $obj;
 	}

 	function _find( $id = null )
 	{
 		if( isset($id) ) {
 			$data = $this->getArrayCopy();

 			return $data[$id];
 		}
 	}

 	function _first() {
 		$data = $this->getArrayCopy();
 		$first_element = array_shift($data);

 		return $first_element;
 	}

 	function _last() {
 		$data = $this->getArrayCopy();
 		$last_element = end($data);

 		return $last_element;
 	}

 	function _order($order_by = array()) {
 		$args = func_get_args();
 		$by = '';
 		foreach( $order_by as $key=>$value) {
 			$order = ( !is_int($key) ? $value : 'ASC' );
 			$order_by = ( !is_int($key) ? $key : $value );
 			$by.=$order_by.' '.$order.',';
 		}
 		$sort = substr($by, 0, -1);
 		$query = $this->query.' ORDER BY '.$sort;
 
 		return $this->obj->multiple_objects( $query );
 	}

 	 function _limit( $nombre = 10, $paged = 1 ) {
 		$start = $nombre * ($paged - 1);
 		$query = $this->query.' LIMIT '.$start.','.$nombre;
 		$obj->the_query = $query;

 		return $this->obj->multiple_objects( $query );
	 }
 }
 class Connection
	{
		static function prepare()
		{
      /*$env = json_decode(file_get_contents("/home/dotcloud/environment.json"), true);
      error_log(json_encode($env));
      $user = $env->DOTCLOUD_DB_MYSQL_LOGIN;
			$password = $env->DOTCLOUD_DB_MYSQL_PASSWORD; 
			$host = $env->DOTCLOUD_DB_MYSQL_HOST;
			$port = $env->DOTCLOUD_DB_MYSQL_PORT;*/
			try {  
			  $DBH = new PDO("mysql:host=localhost;dbname=silo", 'root', '');  
			  
			  $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
				
				return $DBH;
			}  
			catch(PDOException $e) {  
		    echo $e->getMessage();  
			}
		}
	} 
 ?>
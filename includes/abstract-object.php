<?php

abstract class AbstractObject
{
	/**
	 * @static
	 * @var string MySQL table
	 */
	protected static $tableName ;
	
	/**
	 * @static
	 * @var array MySQL columns for $table_name
	 */
	protected static $tableColumns ;
	
	/**
	 * @static
	 * @return mixed
	 */
	public static function getAll(  )
	{
		return static::getBySql( "
			SELECT * FROM " . static::$tableName 
		) ;
	}
	
	/**
	 * @static
	 * @param int $id
	 * @return mixed|bool
	 */
	public static function getById( $id = 0 )
	{
		$db = MySqlDatabase::getInstance(  ) ;

		$result = static::getBySql( "
			SELECT * FROM " . static::$tableName .
			" WHERE id = " .
			$db->db_escape( $id ) . 
			" LIMIT 1
		" ) ;

		return !empty( $result ) ? array_shift( $result ) : false ;
	}
	
	/**
	 * @static 
	 * @param string MySQL syntax $sql
	 * @return array
	 */
	public static function getBySql( $sql = "" )
	{
		$db = MySqlDatabase::getInstance(  ) ;

		$result = $db->db_query( $sql ) ;
		$objArray = array(  ) ;
		
		while( $row = $db->db_fetch( $result ) ) :
			$objArray[] = static::initialize( $row ) ;
		endwhile ;
		
		return $objArray ;
	}
	
	/**
	 * @static
	 * @param object $getObj
	 * @return object
	 */
	private static function initialize( $getObj )
	{
		$obj = new static ;
		
		foreach( $getObj AS $attribute => $value ) :
			if( $obj->checkColumn( $attribute ) ) :
				$obj->$attribute = $value ;
			endif ;
		endforeach ;
		
		return $obj ;
	}
	
	/**
	 * @param string $attribute
	 * @return bool
	 */
	private function checkColumn( $attribute )
	{
		$objVars = $this->getColumns(  ) ;
		return array_key_exists( $attribute, $objVars ) ;
	}
	
	/**
	 * @return array
	 */
	protected function getColumns(  )
	{
		$columns = array(  ) ;
		foreach( static::$tableColumns AS $column => $type ) :
			if( property_exists( $this, $column ) ) :
				$columns[$column] = $this->$column ;
			endif ;
		endforeach ;
		
		return $columns ;
	}
	
	/**
	 * @return array
	 */
	protected function getSanitizedVal(  )
	{
		$db = MySqlDatabase::getInstance(  ) ;
		
		$sanitize = array(  ) ;
		foreach( $this->getColumns(  )  AS $key => $val ) :
			$sanitize[$key] = $db->db_escape( $val ) ;
		endforeach ;
		
		return $sanitize ;
	}
	
	/**
	 * @method INSERT INTO
	 * @return bool
	 */
	protected function insertInto(  )
	{
		$db = MySqlDatabase::getInstance(  ) ;
		$attributes = $this->getSanitizedVal(  ) ;
		$sql = "INSERT INTO " . static::$tableName . " ( " ;
		$sql.= join( ", ", array_keys( $attributes ) ) ;
		$sql.= " ) VALUES ( '" ;
		$sql.= join( "', '", array_values( $attributes ) ) ;
		$sql.= "' )" ;
		
		if( $db->db_query( $sql ) ) :
			$this->id = $db->db_insert_id(  ) ;
			return true ;
		else :
			return false ;
		endif ;
	}
	
	/**
	 * @method UPDATE
	 * @return bool
	 */
	protected function update(  )
	{
		$db = MySqlDatabase::getInstance(  ) ;
		
		$attributes = $this->getSanitizedVal(  ) ;
		$pairs = array(  ) ;
		
		foreach( $attributes AS $key => $val )  :
			$pairs[] = "{$key}='{$val}'" ;
		endforeach ;
		
		$sql = "UPDATE " . static::$tableName . " SET " ;
		$sql.= join( ", ", $pairs ) ;
		$sql.= " WHERE id=" . $db->db_escape( $this->id ) ;
		$db->db_query( $sql ) ;
		
		return( $db->db_affected_rows(  ) == 1 ) ? true : false ;
	}
	
	/**
	 * @return method
	 */
	public function save(  )
	{
		return isset( $this->id ) ? $this->update(  ) : $this->insertInto(  ) ;
	}

	/**
	 * @return bool
	 */	
	public function delete(  )
	{
		$db = MySqlDatabase::getInstance(  ) ;
		
		$sql = "DELETE FROM " . static::$tableName . " WHERE id=" . $db->db_escape( $this->id ) . " LIMIT 1" ;
		$db->db_query( $sql ) ;

		return ( $db->db_affected_rows(  ) == 1 ) ? true : false ;
	}
	
	/**
	 * @static
	 * @return int
	 */
	public static function countAll(  )
	{
		$db = MySqlDatabase::getInstance(  ) ;
		
		$sql = "SELECT COUNT(*) FROM " . static::$tableName ;
		$result = $db->db_query( $sql ) ;
		$row = $db->db_fetch( $result ) ;
		
		return array_shift( $row ) ;
	}
}

?>

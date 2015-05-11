<?php

interface InterfaceDatabase {
	/**
	 * open a new Database connection
	 * @const DB_SERVER
	 * @const DB_USER
	 * @const DB_PASSWORD
	 * @const DB_NAME
	 * @throw \Exception
	 */
	public function db_open(  ) ;
	
	/**
	 * select query
	 * @param mixed $sql
	 * @return mixed|null $result
	 */
	public function db_query( $sql ) ;
	
	/**
	 * fetch array 
	 * @param mixed $result
	 * @return mixed $result
	 */
	public function db_fetch( $result ) ;
	
	/**
	 * num rows
	 * @param mixed $result
	 * @return mixed $result
	 */
	public function db_num_rows( $result ) ;
	
	/**
	 * insert id
	 * @param $connection
	 * @return $connection
	 */
	public function db_insert_id(  ) ;
	
	/**
	 * affected rows
	 * @param $connection
	 * @return $connection
	 */
	public function db_affected_rows(  ) ;
	
	/**
	 * result
	 * @param $result
	 * @throw \Exception
	 */
	public function db_result( $result ) ;
	
	/**
	 * real escape 
	 * @param string $string
	 * @return string
	 */
	public function db_escape( $string ) ;
	
	/**
	 * @param $connection
	 */
	public function db_close(  ) ;
}

?>

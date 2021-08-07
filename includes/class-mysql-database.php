<?php

include_once( 'config.php' ) ;
include_once( 'interface-database.php' ) ;

class MySqlDatabase implements InterfaceDatabase {
	/**
	 * @var Connection
	 */
	private $connection ;
	
	/**
	 * @var mixed|null
	 * @static
	 */
	private static $instance = null ;
	
	/**
	 * Singleton pattern method
	 */
	private function __construct(  ) {
		$this->db_open(  ) ;
	}
	
	/**
	 * @static
	 * @return Database $instance
	 */
	public static function getInstance(  ) {
		if( self::$instance == null ) :
			self::$instance = new self ;
		endif ;
		
		return self::$instance ;
	}
	
	/**
	 * @const DB_SERVER
	 * @const DB_USER
	 * @const DB_PASSWORD
	 * @const DB_NAME
	 * @return void 
	 */
	public function db_open(  ) {
		$this->connection = mysqli_connect( DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME ) ;
		if( $this->connection->connect_errno(  ) ) :
			throw new \Exception( "Database connection failed: " .
				$this->connection->connect_error(  ) .
				" ( " . $this->connection->connect_errno(  ) . " ) "
			) ;
		endif ;
	}
	
	public function db_query( $sql ) {
		$result = mysqli_query( $this->connection, $sql ) ;
		$this->db_result( $result) ;
		return $result ;
	}
	
	public function db_fetch( $result ) {
		return mysqli_fetch_array( $result ) ;
	}
	
	public function db_num_rows( $result ) {
		return mysqli_num_rows( $result ) ;
	}
	
	public function db_insert_id(  ) {
		return mysqli_affected_rows( $this->connection ) ;
	}
	
	public function db_affected_rows(  ) {
		return mysqli_affected_rows( $this->connection ) ;
	}
	
	public function db_result( $result ) {
		if( !$result ) :
			throw new \Exception( "Database query failed!" ) ;
		endif ;
	}
	
	public function db_escape( $string ) {
		$realString = mysqli_real_escape_string( $this->connection, $string ) ;
		return $realString ;
	}
	
	public function db_close(  ) {
		if( isset( $this->connection ) ) :
			mysqli_close( $this->connection ) ;
			unset( $this->connection ) ;
		endif ;
	}
}

$db = MySqlDatabase::getInstance(  ) ;

?>

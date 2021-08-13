<?php

class User extends AbstractObject 
{
	/**
	 * @var int
	 */
	public $id ;
	
	/**
	 * @var string
	 */
	public $username ;
	
	/**
	 * @var string
	 */
	public $password ;
	
	/**
	 * @var string
	 */
	public $firstName ;
	
	/**
	 * @var string
	 */
	public $lastName ;
	
	/**
	 * @var string
	 */
	public $timezone ;
	
	/**
	 * @var string
	 */
	public $email ;
	
	/**
	 * @var string
	 */
	public $startOfWeek ;
	
	/**
	 * @var string
	 */
	protected static $tableName = 'users' ;
	
	/**
	 * @var array
	 */
	protected static $tableColumns = array( 
		'id'          =>	'i',
		'username'    =>	's',
		'password'    =>	's',
		'firstName'   =>	's',
		'lastName'    =>	's',
		'timezone'    =>	's',
		'email'       =>	's',
		'startOfWeek' => 	's'
	) ;

	/**
	 * @return string|null
	 */	
	public function getFullName(  )
	{
		if( isset( $this->firstName ) && isset( $this->lastName ) ) :
			return $this->firstName . " " . $this->lastName ;
		else :
			return "" ;
		endif ;
	}
	
	/**
	 * @param string $username
	 * @param string $password
	 * @return result|bool
	 */
	public static function authenticate( $username = "", $password = "" )
	{
		$db = MySqlDatabase::getInstance(  ) ;
		$password = crypt( $password, '$2x$' ) ;
			
		$sql = "SELECT * FROM users " ;
		$sql.= "WHERE username = '" . $db->db_escape( $username ) . "' " ;
		$sql.= "AND password = '" . $db->db_escape( $password ) . "' " ;
		$sql.= "LIMIT 1" ;
		$result = self::getBySql( $sql ) ;
		
		return !empty( $result ) ? array_shift( $result ) : false ;
	}
}

?>

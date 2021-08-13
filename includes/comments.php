<?php

class Comments extends AbstractObject
{
	/**
	 * @var int
	 */
	public $id ;
	
	/**
	 * @var int
	 */
	public $photograph_id ;
	
	/**
	 * @var int
	 */
	public $created ;
	
	/**
	 * @var string
	 */
	public $author ;
	
	/**
	 * @var string
	 */
	public $body ; 
	 
	/**
	 * @static
	 * @var string
	 */
	protected static $tableName = 'comments' ;
	
	/**
	 * @static
	 * @var array
	 */
	protected static $tableColumns = array( 
		'id'            => 'i',
		'photograph_id' => 'i',
		'created'       => 's',
		'author'        => 's',
		'body'          => 's'
	) ;
	
	/**
	 * @param int $photo_id
	 * @param string $author
	 * @param string $body
	 * @return object|bool
	 */
	public static function setComment( $photo_id, $author, $body )
	{
		if( !empty( $photo_id ) OR !empty( $author ) AND !empty( $body ) ) :
			$comment = new Comments(  ) ;
			$comment->photograph_id = (int) $photo_id ;
			$date = new DateTime(  ) ;
			$comment->created = $date->format( 'Y-m-d H:i:s' ) ;
			$comment->author = $author ;
			$comment->body = $body ;
			return $comment ;
		else :
			return false ;
		endif ;
	}
	
	/**
	 * @param int $photo_id
	 * @return object
	 */
	public static function getComments( $photo_id = 0 )
	{
		$db = MySqlDatabase::getInstance(  ) ;
		
		$sql = "SELECT * FROM " . static::$tableName ;
		$sql.= " WHERE photograph_id = " . $db->db_escape( $photo_id ) ;
		$sql.= " ORDER BY created ASC" ;
		
		return static::getBySql( $sql ) ;
	}
}

?>

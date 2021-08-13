<?php

class Session
{
	/**
	 * @var bool
	 */
	private $loggedIn = false ;
	
	/**
	 * @var int
	 */
	public $userid ;
	
	/**
	 * @var string
	 */
	public $message ;
	
	/**
	 * @method getMessage
	 * @method getLogin
	 */
	public function __construct(  )
	{
		session_start(  ) ;
		$this->getMessage(  ) ;
		$this->getLogin(  ) ;
	}
	
	/**
	 * @return bool
	 */
	public function isLoggedIn(  )
	{
		return $this->loggedIn ;
	}
	
	/**
	 * @param User object
	 */
	public function login( $user )
	{
		if( $user ) :
			$this->userid = $_SESSION['userid'] = $user->id ;
			$_SESSION['username'] = $user->username ;
			$this->loggedIn = true ;
		endif ;
	}
	
	/**
	 * @return void
	 */
	public function logout(  )
	{
		unset( $_SESSION['userid'] ) ;
		unset( $_SESSION['username'] ) ;
		unset( $_SESSION['message'] ) ;
		unset( $this->userid ) ;
		$this->loggedIn = false ;
	}
	
	/**
	 * @param string $msg
	 * @return string|void
	 */
	public function message( $msg = "" )
	{
		if( !empty( $msg ) ) :
			$_SESSION['message'] = $msg ;
		else :
			return $this->message ;
		endif ;
	}
	
	/**
	 * @return void
	 */
	private function getLogin(  )
	{
		if( isset( $_SESSION['userid'] ) ) :
			$this->userid = $_SESSION['userid'] ;
			$this->loggedIn = true ;
		else :
			unset( $this->userid ) ;
			$this->loggedIn = false ;
		endif ;
	}
	
	/**
	 * @return void
	 */
	private function getMessage(  )
	{
		if( isset( $_SESSION['message'] ) ) :
			$this->message = $_SESSION['message'] ;
			unset( $_SESSION['message'] ) ;
		else :
			$this->message = "" ;
		endif ;
	}
	
	/**
	 * @static
	 * @return string
	 */
	static public function formatMessage( $message = '', $alert = 'warning' )
	{
		if( !empty( $message ) ) :
			return '	<section class="alert alert-' . $alert . ' fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<p><span class="glyphicon glyphicon-envelope"> ' . $message . '</p>
	</section>' ;
		else :
			return '' ;
		endif ;
	}
}

$session = new Session(  ) ;
$message = $session->message(  ) ;

?>

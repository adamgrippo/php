<?php

/**
 * Working around a bug that isn't present on local server...
 * Assumed it was eventually fixed in an updated PHP version
 * @https://bugs.php.net/bug.php?id=42355
 */
define( 'SITE_PATH', realpath( $_SERVER['DOCUMENT_ROOT'] . '/grippo' ) ) ;
// define( 'SITE_PATH', realpath( $_SERVER['DOCUMENT_ROOT'] ) ) ;
define( 'LIB_PATH', SITE_PATH . DIRECTORY_SEPARATOR . 'includes' ) ;
define( 'ADMIN_PATH', SITE_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'admin-cp' ) ;
define( 'IMAGE_DIR', 'images' ) ;
define( 'TEMPLATE_DIR', SITE_PATH . DIRECTORY_SEPARATOR . 'templates' ) ;

class Template
{
	/**
	 * @const string
	 */
	const DS = DIRECTORY_SEPARATOR ;
	
	/**
	 * @const string
	 */
	const SITE_PATH = SITE_PATH ;
	
	/**
	 * @const string
	 */
	const LIB_PATH = LIB_PATH ;
	
	/**
	 * @const string
	 */
	const ADMIN_PATH = ADMIN_PATH ;
	
	/**
	 * @const string
	 */
	const IMAGE_DIR = IMAGE_DIR ;
	
	/**
	 * @const string
	 */
	const TEMPLATE_DIR = TEMPLATE_DIR ;
	
	
	/**
	 * @static
	 * @param string $template
	 */
	public static function getTemplate( $template = "" )
	{
		$path = self::TEMPLATE_DIR . self::DS . "{$template}" ;
		if( file_exists( $path ) ) :
			include_once( $path ) ;
		else :
			echo "Failed{$path}" ;
		endif ;
	}
	
	/**
	 * @static
	 * @param string|null
	 */
	public static function redirectTo( $location = null )
	{
		if( $location != null ) :
			header( "Location: {$location}" ) ;
			exit ;
		else :
			$location = self::SITE_PATH . self::DS . 'public' . self::DS . 'index.php' ;
			header( "Location: {$location}" ) ;
			exit ;
		endif ;
	}
}

?>

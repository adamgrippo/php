<?php

error_reporting( E_ALL ) ;

/**
 * @load class template
 */
require_once( "class-template.php" ) ;

/**
 * @load server config {@file config.php}
 */
require_once( Template::LIB_PATH . Template::DS . "config.php" ) ;

/**
 * @load class session
 */
require_once( Template::LIB_PATH . Template::DS . "session.php" ) ;

/**
 * @load database interface and class
 */
require_once( "interface-template.php" ) ;
require_once( Template::LIB_PATH . Template::DS . "interface-database.php" ) ;
require_once( Template::LIB_PATH . Template::DS . "class-mysql-database.php" ) ;
require_once( "datetimeplus.php" ) ;
require_once( Template::LIB_PATH . Template::DS . "calendar.php" ) ;

/**
 * @load core abstract class and database mapping classes 
 */
require_once( Template::LIB_PATH . Template::DS . "abstract-object.php" ) ;
require_once( Template::LIB_PATH . Template::DS . "user.php" ) ;
require_once( Template::LIB_PATH . Template::DS . "comments.php" ) ;
require_once( Template::LIB_PATH . Template::DS . "photograph.php" ) ;

/**
 * @load additional core classes
 */
require_once( Template::LIB_PATH . Template::DS . "pagination.php" ) ;

?>

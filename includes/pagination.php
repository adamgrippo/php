<?php

class Pagination
{
	/**
	 * @var int
	 */
	public $currentPage ;
	
	/**
	 * @var int
	 */
	public $perPage ;
	
	/**
	 * @var int
	 */
	public $totalCount ;
	
	/**
	 * @param int $page
	 * @param int $perPage 
	 * @param int $totalCount
	 */
	public function __construct( $page = 1, $perPage = 20, $totalCount = 0 )
	{
		$this->currentPage 	= (int) $page ;
		$this->perPage		= (int) $perPage ;
		$this->totalCount	= (int) $totalCount ;
	}
	
	/**
	 * @return int
	 */
	public function offset(  )
	{
		return ( $this->currentPage - 1 ) * $this->perPage ;  
	}
	
	/**
	 * @return int
	 */
	public function totalPages(  )
	{
		return ceil( $this->totalCount / $this->perPage ) ;
	}
	
	/**
	 * @return int
	 */
	public function previousPage(  )
	{
		return $this->currentPage - 1 ;
	}
	
	/**
	 * @return int
	 */
	public function nextPage(  )
	{
		return $this->currentPage + 1 ;
	}
	
	/**
	 * @return bool
	 */
	public function hasPrevious(  )
	{
		return $this->previousPage(  ) >= 1 ? true : false ;
	}
	
	/**
	 * @return bool
	 */
	public function hasNext(  )
	{
		return $this->nextPage(  ) <= $this->totalPages(  ) ? true : false ;
	}
	
	/**
	 * @param string $href
	 * @param array $attributes
	 * @param string $hrefTitle
	 * @return string
	 */
	static public function buildLink( $href, $attributes = array(  ), $hrefTitle )
	{
		$pairs = array(  ) ;
		
		foreach( $attributes AS $key => $val )  :
			$pairs[] = "{$key}='{$val}'" ;
		endforeach ;
	
		return '<a href="' . $href . '?' . join( "&", $pairs ) . '">' . $hrefTitle . '</a>' ;
	}
}

?>

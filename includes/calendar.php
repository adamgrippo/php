<?php

class Calendar {
	/**
	 * @var string
	 */
	public $startofweek = 'Sunday' ;
	
	/**
	 * @var int
	 */
	public $day ;
	
	/**
	 * @var int
	 */
	public $month ;
	
	/**
	 * @var int
	 */
	public $year ;
	
	/**
	 * @var int
	 */
	public $daysInMonth ;
	
	/**
	 * @var array
	 */
	public $weeklist = array(
		'Sunday',
		'Monday',
		'Tuesday',
		'Wednesday',
		'Thursday',
		'Friday',
		'Saturday',
	) ;
	
	/**
	 * @var int
	 */
	public $onDay = 1 ;
	
	/**
	 * @var object
	 */
	public $date ;
	
	/**
	 * @var string
	 */
	public $firstDay ;
	
	/**
	 * @var int
	 */
	public $colspan ;
	
	/**
	 * @var int
	 */
	public $weeks ;
	
	/**
	 * @var int
	 */
	public $modulus ;
	
	/**
	 * @param string $timezone
	 * @return void
	 */
	public function __construct( $timezone = 'America/New_York', $date = 'now' )
	{
		$this->date = new DateTime( $date, new DateTimeZone( $timezone ) ) ;
	}
	
	/**
	 * @param object DateTime $date
	 */
	public function calSetup( $date )
	{
		$this->day 		= $date->format( 'd' ) ;
		$this->month 	= $date->format( 'm' ) ;
		$this->year 	= $date->format( 'Y' ) ;
		$this->daysInMonth = $this->calGetDays(  ) ;
		$this->calSetupDays(  ) ;
		$this->calGetFirst(  ) ;
	}
	
	/**
	 * @return int
	 */
	public function calGetDays(  )
	{
		return cal_days_in_month( CAL_GREGORIAN, $this->month, $this->year ) ;
	}

	public function calSetupDays(  )
	{
		do {
			array_push( $this->weeklist, current( $this->weeklist ) ) ;
			array_shift( $this->weeklist ) ;
		} while ( current( $this->weeklist ) != $this->startofweek ) ;
	}

	public function calGetFirst(  )
	{
		$newDate = new DateTime( $this->year . '-' . $this->month . '-' . $this->day ) ;
		$firstDay = $newDate->setDate( $this->year, $this->month, 1 ) ;
		$this->firstDay = $firstDay->format( 'l' ) ;
		$this->colspan = array_search( $this->firstDay, $this->weeklist ) ;
	}
	
	/**
	 * @static
	 */
	public function calGetWeeks(  )
	{
		$this->weeks = floor( ( $this->daysInMonth - $this->onDay + 1 ) / 7 ) ;
		$this->modulus = ( $this->daysInMonth -  $this->onDay + 1 ) % 7 ;
	}

	/**
	 * @return string
	 */
	private function calLastYear(  )
	{
		$lastYear = new DateTime( ( $this->year - 1 ) . '-' . $this->month ) ;
		return $lastYear->format( 'F-m-Y' ) ;
	}

	/**
	 * @return string
	 */
	private function calNextYear(  )
	{
		$nextYear = new DateTime( ( $this->year + 1 ) . '-' . $this->month ) ;
		return $nextYear->format( 'F-m-Y' ) ;
	}

	/**
	 * @return string
	 */
	private function calLastMonth(  )
	{
		if( $this->month == 01 ) :
			$this->month = 13 ;
			$this->year-- ;
		endif ;
	
		$lastMonth = new DateTime( $this->year . '-' . ( $this->month - 1 ) ) ;

		if( $this->month == 13 ) :
			$this->month = 01 ;
			$this->year++ ;
		endif ;
		
		return $lastMonth->format( 'F-m-Y' ) ;
	}

	/**
	 * @return string
	 */
	private function calNextMonth(  )
	{	
		if( $this->month == 12 ) :
			$this->month = 0 ;
			$this->year++ ;
		endif ;

		$nextMonth = new DateTime( $this->year . '-' . ( $this->month + 1 ) ) ;
		
		if( $this->month == 0 ) :
			$this->month = 12 ;
			$this->year-- ;
		endif ;
		
		return $nextMonth->format( 'F-m-Y' ) ;
	}

	/**
	 * @return array
	 */	
	public function calPagination(  )
	{
		$nav['lastYear'] = $this->calLastYear(  ) ;
		$nav['lastMonth'] = $this->calLastMonth(  ) ;
		$nav['nextMonth'] = $this->calNextMonth(  ) ;		
		$nav['nextYear'] = $this->calNextYear(  ) ;
		return $nav ;
	}
	
	/**
	 * @param string $day
	 * @return string
	 */
	public function calFormatDay( $day )
	{
		if( $day == $this->day ) :
			return '<td class="today">' . $day . '</td>' ;
		else :
			return '<td>' . $day . '</td>' ;
		endif ;
	}
	
	/**
	 * @return string
	 */
	public function calYesterday(  )
	{
		$yesterday = new DateTime( $this->year . '-' . $this->month . '-' . $this->day ) ;
		$yesterday->sub( new DateInterval( 'P1D' ) ) ;
		return '<a href="calendar.php?y=' . $yesterday->format( 'Y' ) . '&m=' . $yesterday->format( 'm' ) . '&d=' . $yesterday->format( 'd' ) . '">Yesterday</a>' ;		
	}

	/**
	 * @return string
	 */	
	public function calTomorrow(  )
	{
		$tomorrow = new DateTime( $this->year . '-' . $this->month . '-' . $this->day ) ;
		$tomorrow->add( new DateInterval( 'P1D' ) ) ;
		return '<a href="calendar.php?y=' . $tomorrow->format( 'Y' ) . '&m=' . $tomorrow->format( 'm' ) . '&d=' . $tomorrow->format( 'd' ) . '">Tomorrow</a>' ;		
	}
}
		
?>

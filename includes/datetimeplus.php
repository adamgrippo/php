<?php

class DateTimePlus extends DateTimeZone {
	/**
	 * @param string $tzName
	 * @return string
	 */
	static public function timezoneFormat( $tzName )
	{
		$format = str_replace( "/", " ", $tzName ) ;
		$format = str_replace( "_", " ", $format ) ;
		return $format ;
	}

	/**
	 * @param string $timezone
	 * @param string $format @date
	 * @param string|null $date
	 * @return string
	 */	
	static public function dateFormat( $timezone = 'America/New_York', $format = 'g:ia \o\\n l F jS Y', $date = null )
	{

		if( $date == null ) :
			$newDate = new DateTime(  ) ;
		else :
			$newDate = new DateTime( $date ) ;
		endif ;
		
		$newDate->setTimezone( new DateTimeZone( $timezone ) ) ;		
		$dateNow = $newDate->format( $format ) ;

		return $dateNow ;
	}
	
	/**
	 * @param string $timezone
	 * @return array 
	 */
	static public function getTimezones(  )
	{
		$topList = array(  ) ;
		$bottomList = array(  ) ;
		$timezone = DateTimeZone::listIdentifiers( DateTimeZone::ALL ) ;

		array_walk( $timezone, function( $tz, $index ) use ( &$topList, &$bottomList )
		{
			if( stristr( $tz, 'America' ) ) :
				$topList[] = $tz ;
			else :
				$bottomList[] = $tz ;
			endif ;
		}) ;
				
		return array_merge( $topList, $bottomList ) ;
	}		 
}

?>

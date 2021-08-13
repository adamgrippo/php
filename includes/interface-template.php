<?php

interface InterfaceTemplate
{
	/**
	 *
	 */
	public function initTemplate( $template ) ;
	
	/**
	 *
	 */
	public function formatTemplate( $template, $html ) ;
	
	/**
	 *
	 */
	public function outputTemplate( $template ) ;
}

class InputTemplate implements InterfaceTemplate
{
	/**
	 * {@inheritdoc}
	 */
	public function initTemplate( $template )
	{
		global $template ;
		return Template::getTemplate( $template ) ;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function formatTemplate( $template, $html )
	{
		return sprintf( $template, ' . join( "', '", $html ) . ' ) ;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function outputTemplate( $template )
	{
		return $template ;
	}
}

class DirectorTemplate
{
	public function buildTemplate( InterfaceTemplate $template )
	{
		$template->initTemplate(  ) ;
		$template->formatTemplate(  ) ;
		
		return $template->outputTemplate(  ) ;
	}
}

abstract class FormElement {
	/**
	 * @var array
	 */
	protected $data ;
	
	/**
	 * @param string $index
	 * @param mixed $value
	 */
	public function setElement( $index, $value )
	{
		$this->data[$index] = $value ;
	}
}

class InputElement extends FormElement {  }
class SelectElement extends FormElement {  }

?>

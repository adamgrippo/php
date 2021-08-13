<?php

class Photograph extends AbstractObject
{
	/**
	 * @var int
	 */
	public $id ;
	
	/**
	 * @var string
	 */
	public $filename ;
	
	/**
	 * @var string
	 */
	public $type ;
	
	/**
	 * @var int
	 */
	public $size ;
	
	/**
	 * @var string
	 */
	public $caption ;
	
	/**
	 * @var string
	 */
	private $tempPath ;
	
	/**
	 * @var array
	 */
	public $errors = array(  ) ;
	
	/**
	 * @var array
	 * @const UPLOAD_ERR_OK
	 * @const UPLOAD_ERR_INI_SIZE
	 * @const UPLOAD_ERR_FORM_SIZE
	 * @const UPLOAD_ERR_PARTIAL
	 * @const UPLOAD_ERR_NO_FILE
	 * @const UPLOAD_ERR_NO_TMP_DIR
	 * @const UPLOAD_ERR_CANT_WRITE  
	 * @const UPLOAD_ERR_EXTENSION
	 */
	protected $uploadErrors = array(
		UPLOAD_ERR_OK			=> 'File uploaded successfully.',
		UPLOAD_ERR_INI_SIZE		=> 'File too big.',
		UPLOAD_ERR_FORM_SIZE	=> 'File too big.',
		UPLOAD_ERR_PARTIAL		=> 'Partial file upload.',
		UPLOAD_ERR_NO_FILE		=> 'No file selected.',
		UPLOAD_ERR_NO_TMP_DIR	=> 'No temporary directory exists.',
		UPLOAD_ERR_CANT_WRITE	=> 'Cannot write to disk.',
		UPLOAD_ERR_EXTENSION	=> 'File extension invalid.'
	) ;
	 
	/**
	 * @static
	 * @var string
	 */
	protected static $tableName = 'photographs' ;
	
	/**
	 * @static
	 * @var array
	 */
	protected static $tableColumns = array(
		'id'		=> 'i',
		'filename'	=> 's',
		'type'		=> 's',
		'size'		=> 'i',
		'caption'	=> 's'
	) ;
	
	/**
	 * @return string
	 */
	public function imagePath(  )
	{
		return Template::IMAGE_DIR . Template::DS . $this->filename ;
	}
	
	/**
	 * @return string
	 */
	public function sizeToText(  )
	{
		if( $this->size < 1024 ) :
			return "{$this->size} bytes" ;
		elseif( $this->size < 1048576 ) :
			$sizeKB = round( $this->size / 1024 ) ;
			return "{$sizeKB} KB" ;
		else :
			$sizeMB = round( $this->size / 1048576, 1 ) ;
			return "{$sizeMB} MB" ;
		endif ;
	}
	
	/**
	 * @return object
	 */
	public function getComments(  )
	{
		return Comments::getComments( $this->id ) ;
	}
	
	/**
	 * @param mixed $file
	 * @return bool
	 */
	public function attachFile( $file )
	{
		if( !$file OR empty( $file ) OR !is_array( $file ) ) :
			$this->errors[] = "No file was uploaded." ;
			return false ;
		elseif( $file['error'] != 0 ) :
			$this->errors[] = $this->uploadErrors[$file['error']] ;
			return false ;
		endif ;
		
		$this->tempPath = $file['tmp_name'] ;
		$this->filename = basename( $file['name'] ) ;
		$this->type = $file['type'] ;
		$this->size = $file['size'] ;
		
		return true ;
	}
	
	/**
	 * @return bool
	 */	
	public function save(  )
	{
		if( isset( $this->id ) ) :
			$this->update(  ) ;
		else :
			if( !empty( $this->errors ) ) :
				return false ;
			endif ;
			
			if( strlen( $this->caption ) > 255 ) :
				$this->errors[] = "The caption can only be 255 characters long." ;
				return false ;
			endif ;
			
			if( empty( $this->filename ) OR empty( $this->tempPath ) ) :
				$this->errors[] = "The file location is not available." ;
				return false ;
			endif ;
			
			$targetPath = Template::SITE_PATH . Template::DS . 'public' . Template::DS . 'images' . Template::DS . $this->filename ;
			
			if( file_exists( $targetPath ) ) :
				$this->errors[] = "The file {$this->filename} already exists." ;
				return false ;
			endif ;
			
			if( move_uploaded_file( $this->tempPath, $targetPath ) ) :
				if( parent::save(  ) ) :
					unset( $this->tempPath ) ;
					return true ;
				endif ;
			else :
				$this->errors[] = "The file upload failed. Possibly due to incorrect permissions on the upload folder." ;
				return false ;
			endif ;
		endif ;
	}
	
	/**
	 * @return bool
	 */
	public function destroy(  )
	{
		if( $this->delete(  ) ) :
			$targetPath = Template::SITE_PATH . Template::DS . $this->imagePath(  ) ;
			return unlink( $targetPath ) ? true : false ;
		else :
			return false ;
		endif ;
	}
}	

?>

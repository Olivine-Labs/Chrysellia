<?php

namespace Protocol;

define('JSON', 0);
define('XML', 1);

/**
 * Result Class
 */
class Result
{
	/**
	 * Result
	 *
	 * Contains the result code.
	 */
	public $Data = Array();

	/**
	 * OutputMethod
	 *
	 * Sets the format that we output our result data
	 */
	public $OutputMethod = JSON;

	/**
	 * Default constructor for the Result class
	 */
	public function __construct()
	{
		
	}

	/**
	 * Prints the result
	 */
	public function Output()
	{
		switch($this->OutputMethod)
		{
			case JSON:
				echo json_encode($this->Data);
				break;
			case XML:
				if(class_exists('XML_Serializer'))
				{
					$serializer = new XML_Serializer();
					$serializer->serialize($this->Data);
					echo $serializer->getSerializedOutput();
				}
				else
					throw new \Exception('Pear XML_Serializer package not found!');
				break;
		}
	}

}

?>
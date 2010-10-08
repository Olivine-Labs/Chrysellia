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
	protected $Data = Array('Result'=>255);

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
	 * Adds a variable to the Data Array
	 *
	 *
	 * @param $Key
	 *   The key in the data array to put $Value in
	 *
	 * @param $Value
	 *   The Value to be stored
	 */
	public function Set($Key, $Value)
	{
		$this->Data[$Key] = $Value;
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
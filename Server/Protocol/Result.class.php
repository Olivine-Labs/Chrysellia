<?php

namespace Protocol;

/**
 * Result Class
 */
class Result
{

	const OT_JSON = 0;
	const OT_XML = 1;

	const ER_SUCCESS=0;//when Murphy is not around everything works.
	const ER_BADDATA=251;//when the data is bad
	const ER_ALREADYEXISTS=252);//when the data already exists in the database
	const ER_MALFORMED=253;//when a post/get is malformed for the function requested
	const ER_DBERROR=254;//when the database fails
	const ER_ACCESSDENIED=255;//when they just don't have access.

	/**
	 * Result
	 *
	 * Contains the result code.
	 */
	protected $Data = Array('Result'=>$this->ER_ACCESSDENIED);

	/**
	 * OutputMethod
	 *
	 * Sets the format that we output our result data
	 */
	public $OutputMethod = $this->OT_JSON;

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
			case $this->OT_JSON:
				echo json_encode($this->Data);
				break;
			case $this->OT_XML:
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
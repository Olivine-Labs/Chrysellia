<?php

namespace Protocol;

function ProcessDataElement(&$Element)
{
	if(is_object($Element) || is_array($Element))
		$Element = array_filter((array)$Element, '\Protocol\ProcessDataElement');
	return !is_null($Element);
}

/**
 * Result Class
 */
class Result
{

	const OT_JSON = 0;
	const OT_XML = 1;

	const ER_SUCCESS=0;//when Murphy is not around everything works.
	const ER_NOTLOGGEDIN=250;//when the session fails
	const ER_BADDATA=251;//when the data is bad
	const ER_ALREADYEXISTS=252;//when the data already exists in the database
	const ER_MALFORMED=253;//when a post/get is malformed for the function requested
	const ER_DBERROR=254;//when the database fails
	const ER_ACCESSDENIED=255;//when they just don't have access.

	/**
	 * Result
	 *
	 * Contains the result code.
	 */
	protected $Data = Array('Result'=>Result::ER_ACCESSDENIED);

	/**
	 * OutputMethod
	 *
	 * Sets the format that we output our result data
	 */
	public $OutputMethod = Result::OT_JSON;

	public $Compression = false;

	/**
	 * Default constructor for the Result class
	 */
	public function __construct($Compression)
	{
		$this->Compression=$Compression;
		if($this->Compression)
		{
			ob_start('ob_gzhandler');
		}
		else
			ob_start();
	}

	public function __destruct()
	{
		$this->Output();
		ob_end_flush();
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
			case Result::OT_JSON:
				if(isset($_GET['jsonCallback']))
				{
					echo $_GET["jsonCallback"]. "(" . json_encode(array_filter($this->Data, '\Protocol\ProcessDataElement')) . ")";
				}
				else
				{
					echo json_encode(array_filter($this->Data, '\Protocol\ProcessDataElement'));
				}
				break;
			case Result::OT_XML:
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
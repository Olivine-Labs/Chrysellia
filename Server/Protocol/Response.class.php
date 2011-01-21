<?php

namespace Protocol;

function ProcessDataElement(&$Element)
{
	if(is_object($Element) || is_array($Element))
		$Element = array_filter((array)$Element, '\Protocol\ProcessDataElement');
	return !is_null($Element);
}

/**
 * Response Class
 */
class Response
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
	 * Response
	 *
	 * Contains the Response code.
	 */
	protected $Data = Array('Result'=>Response::ER_ACCESSDENIED);

	/**
	 * OutputMethod
	 *
	 * Sets the format that we output our Response data
	 */
	public $OutputMethod = Response::OT_JSON;

	public $Compression = false;

	/**
	 * Default constructor for the Response class
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
		$this->Send();
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
	 * Prints the Response
	 */
	public function Send()
	{
		switch($this->OutputMethod)
		{
			case Response::OT_JSON:
				if(isset($_GET['jsonCallback']))
				{
					echo $_GET["jsonCallback"]. "(" . json_encode(array_filter($this->Data, '\Protocol\ProcessDataElement')) . ")";
				}
				else
				{
					echo json_encode(array_filter($this->Data, '\Protocol\ProcessDataElement'));
				}
				break;
			case Response::OT_XML:
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
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
	//Output Types
	const OT_JSON = 0;
	const OT_XML = 1;

	const ER_SUCCESS=0;//when Murphy is not around everything works.
	const ER_CORE=1;//When I typoed(syntax/runtime error)
	const ER_NOTONLINE=249;//when the target is not online
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
	protected $Data = Array('0'=>array('Result'=>Response::ER_ACCESSDENIED));
	protected $ResponseNum = 0;
	protected $Debug = 0;

	/**
	 * OutputMethod
	 *
	 * Sets the format that we output our Response data
	 */
	public $OutputMethod = Response::OT_JSON;

	public $Compression = false;
	private $ConstructTime;

	/**
	 * Default constructor for the Response class
	 */
	public function __construct($Config)
	{
		$this->ConstructTime = microtime();
		$this->OutputType = $Config[CF_OP_ENCODING];
		$this->Compression = $Config[CF_OP_COMPRESSION];
		$this->Debug = $Config[CF_OP_DEBUG];
		if($this->Compression)
		{
			ob_start('ob_gzhandler');
		}
		else
			ob_start();
	}

	public function __destruct()
	{
		if($this->Debug)
			$this->Data['RequestDuration'] = max(microtime() - $this->ConstructTime, 0);
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
		$this->Data[$this->ResponseNum][$Key] = $Value;
	}

	/**
	 * Adds an error message to the response
	 *
	 * @param $Message
	 *   The Message to send
	 */
	public function AddError($Message)
	{
		if($this->Debug)
			$this->Data[$this->ResponseNum]['Error'][] = $Message;
	}

	/**
	 * Prints the Response
	 */
	private function Send()
	{
		switch($this->OutputMethod)
		{
			case Response::OT_JSON:
				header('Cache-Control: no-cache, must-revalidate');
				header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				header('Content-Type: application/json');
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
				header('Cache-Control: no-cache, must-revalidate');
				header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
				header ("Content-Type: text/xml");
				if(class_exists('XML_Serializer'))
				{
					$serializer = new XML_Serializer();
					$serializer->serialize($this->Data);
					if (!PEAR::isError($status))
					{
						echo $serializer->getSerializedOutput();
					}
					else
					{
						throw new \Exception('Error in encoding XML output data');
					}
				}
				else
					throw new \Exception('Pear XML_Serializer package not found!');
				break;
		}
	}

	public function NextResponse()
	{
		$this->ResponseNum++;
	}
}

?>
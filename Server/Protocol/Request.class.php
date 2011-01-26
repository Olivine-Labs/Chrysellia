<?php

namespace Protocol;

/**
 * Request Class
 */
class Request
{
	//Input Types
	const IT_JSON = 0;
	const IT_XML = 1;

	//Compression Types
	const CT_NONE = 0;
	const CT_JSEND = 1;

	/**
	 * Request
	 *
	 * Contains the Request data.
	 */
	public $Data;

	/**
	 * InputMethod
	 *
	 * Sets the format that the data that is sent to us is in
	 */
	public $InputMethod = Request::IT_JSON;

	/**
	 * CompressionType
	 *
	 * The type of compression the client is using
	 */	
	public $CompressionType = Request::CT_NONE;

	/**
	 * Default constructor for the Response class
	 */
	public function __construct(&$Data, &$Config)
	{
		$this->CompressionType=$Config[CF_IP_COMPRESSION];
		$this->InputType=$Config[CF_IP_ENCODING];
		$this->Data = $Data;
		$this->Decompress();
		$this->Decode();
	}

	public function __destruct()
	{
		
	}

	/**
	 * Decompress input data
	 *
	 * @param $Input
	 *   The data to decompress
	 */
	public function Decompress()
	{
		switch($this->CompressionType)
		{
			case Request::CT_NONE:
				return true;
				break;
			case Request::CT_JSEND:
				include('./ThirdParty/jsend.class.php')
				$jSEND = new jSEND();
				$this->Data = $jSEND->getData($this->Data);
				return true;
				break;
			default:
				throw new \Exception('Compression type not valid');
				break;
		}
	}
	/**
	 * Decodes input data
	 *
	 * @param $Input
	 *   The data to decode
	 */
	public function Decode($Input)
	{
		switch($this->InputType)
		{
			case Request::IT_JSON:
				return json_decode($Input);
				break;
			case Request::IT_XML:
				if(class_exists('XML_Unserializer'))
				{
					$serializer = new XML_Unserializer();
					$serializer->unserialize($this->Data);
					if (!PEAR::isError($status))
					{
						return $serializer->getUnserializedOutput();
					}
					else
					{
						throw new \Exception('Error in decoding XML input data');
					}
				}
				else
					throw new \Exception('Pear XML_Serializer package not found!');
				break;
			default:
				throw new \Exception('Invalid input type in configuration file');
				break;
		}
	}
}

?>
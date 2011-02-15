<?php

namespace Database\MySQL;


/**
 * Contains properties and methods related to general tasks specific to the mysql database
 */
class MySQLiExtension extends \mysqli
{

	public $Log;

	/**
	 * Constructor for the MySQLi Extension
	 *
	 * Throws an exception when connection fails
	 *
	 * @param $Host
	 *   The hostname/ip address of the database server
	 *
	 * @param $Port
	 *   The port on which the database server is listening
	 *
	 * @param $UserName
	 *   A UserName which has access to the database we'll be using.
	 *
	 * @param $Password
	 *   The Password for the UserName provided
	 *
	 * @param $Database
	 *   The Database which contains the Neflaria tables
	 *
	 * @throws Exception
	 */
	public function __construct($Host, $UserName, $Password, $Database, $Port)
	{
		parent::init();

		if (!parent::options(MYSQLI_OPT_CONNECT_TIMEOUT, 5)) {
			$this->LogError('?', 'Setting the connect timeout failed');
		}

		if (!parent::real_connect($Host, $UserName, $Password, $Database, $Port))
		{
			$this->LogError(mysqli_connect_errno(), mysqli_connect_error());
		}
	}

	public function __set($Variable, $Value)
	{
		parent::__set($Variable, $Value);
		if($Variable == 'error')
		{
			$this->LogError($this->errno, $this->error);
		}
	}

	public function prepare($Statement)
	{
		if(!$Result = parent::prepare($Statement))
		{
			$this->LogError($this->errno, $this->error);
		}
		return $Result;
	}

	public function LogError($ErrorNumber, $Message)
	{
		if(isset($this->Log))
		{
			$this->Log->AddError("Database Error $ErrorNumber : $Message");
		}
		else
		{
			throw new \Exception("Database Error $ErrorNumber : $Message");
		}
	}
}

?>
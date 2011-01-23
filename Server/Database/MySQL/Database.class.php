<?php

namespace Database\MySQL;


/**
 * Contains properties and methods related to general tasks specific to the mysql database
 */
class Database extends \Database\Database
{
	/**
	 * Constructor for the MySQL Database class
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
	public function __construct($Host, $Port, $UserName, $Password, $Database, &$Error=null)
	{
		try
		{
			$this->Connection = new MySQLiExtension($Host, $UserName, $Password, $Database, $Port);
			$this->Connection->Log = $this->Log;
		}
		catch(\Exception $e)
		{
			if(isset($this->Log))
			{
				$this->Log->Set('Error', $e->getMessage());
			}
			$Error = $e->getMessage();
		}
	}

	public function __get($PropertyName)
	{
		$PropertyName = '_'.$PropertyName;
		if(property_exists($this, $PropertyName))
		{
			if(!isset($this->$PropertyName))
			{
				switch($PropertyName)
				{
					case '_Accounts':
						return ($this->_Accounts = new Accounts($this));
						break;
					case '_Characters':
						return ($this->_Characters = new Characters($this));
						break;
					case '_Sessions':
						return ($this->_Sessions = new Sessions($this));
						break;
					case '_Chat':
						return ($this->_Chat = new Chat($this));
						break;
					case '_Races':
						return ($this->_Races = new Races($this));
						break;
					case '_Maps':
						return ($this->_Maps = new Maps($this));
						break;
					case '_Items':
						return ($this->_Items = new Items($this));
						break;
					case '_Monsters':
						return ($this->_Monsters = new Monsters($this));
						break;
				}
			}
			else
			{
				return $this->$PropertyName;
			}
		}
		else
		{
			return null;
		}
	}

	/**
	 * Starts a MySQL Transaction
	 *
	 * Causes queries to not be directly applied to the database.
	 */
	public function startTransaction()
	{
		$this->Connection->autocommit(false);
	}

	/**
	 * Commits a MySQL Transaction
	 *
	 * Causes queries submitted after a startTransaction() call to be applied to the database.
	 * Also causes connection to return to autocommit mode.
	 */
	public function commitTransaction()
	{
		$this->Connection->commit();
		$this->Connection->autocommit(true);
	}

	/**
	 * Rolls back a MySQL database to before a transaction was started.
	 *
	 * Causes queries submitted after a startTransaction() call not to be applied to the database.
	 * Also causes connection to return to autocommit mode.
	 */
	public function rollbackTransaction()
	{
		$this->Connection->rollback();
		$this->Connection->autocommit(true);
	}
}

?>
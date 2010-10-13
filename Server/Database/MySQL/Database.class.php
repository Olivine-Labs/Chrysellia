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
	public function __construct($Host, $Port, $UserName, $Password, $Database)
	{
		$this->Connection = new \mysqli($Host, $UserName, $Password, $Database, $Port);
		if(!$this->Connection)
			throw new \Exception($this->Connection->error());

		$this->Accounts = new Accounts($this);
		$this->Characters = new Characters($this);
	}

	/**
	 * Starts a MySQL Transaction
	 *
	 * Causes queries to not be directly applied to the database.
	 */
	public function startTransaction()
	{
		$this->Connection->autocommit = false;
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
		$this->Connection->autocommit = true;
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
		$this->Connection->autocommit = true;
	}
}

?>
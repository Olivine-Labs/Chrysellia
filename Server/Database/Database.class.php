<?php

namespace Database;


/**
 * Abstract Database class
 */
abstract class Database
{
	/**
	 * The connection object, stored a reference to mysqli connection
	 *
	 * @var Connection
	 */
	public $Connection;

	/**
	 * Reference to object that contains Account related queries
	 *
	 * @var Accounts
	 */
	protected $_Accounts;

	/**
	 * Reference to object that contains Character related queries
	 *
	 * @var Characters
	 */
	protected $_Characters;

	/**
	 * Reference to object that contains Session related queries
	 *
	 * @var Sessions
	 */
	protected $_Sessions;

	/**
	 * Reference to object that contains Chat related queries
	 *
	 * @var Chat
	 */
	protected $_Chat;

	/**
	 * Reference to object that contains Race related queries
	 *
	 * @var Races
	 */
	protected $_Races;

	/**
	 * Reference to object that contains Map related queries
	 *
	 * @var Maps
	 */
	protected $_Maps;

	/**
	 * Reference to object that contains Item related queries
	 *
	 * @var Items
	 */
	protected $_Items;

	/**
	 * Reference to object that contains Monster related queries
	 *
	 * @var Monsters
	 */
	protected $_Monsters;

	/**
	 * Reference a function that handles error messages.
	 *
	 * @var Log
	 */
	public $Log;

	/**
	 * Constructor for the abstract Database class
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
	 *   The Database which contains the Chrysellia tables
	 *
	 * @throws Exception
	 */
	abstract public function __construct($Host, $Port, $UserName, $Password, $Database);

	/**
	 * Starts a MySQL Transaction
	 *
	 * Causes queries to not be directly applied to the database.
	 */
	abstract public function startTransaction();

	/**
	 * Commits a MySQL Transaction
	 *
	 * Causes queries submitted after a startTransaction() call to be applied to the database.
	 * Also causes connection to return to autocommit mode.
	 */
	abstract public function commitTransaction();

	/**
	 * Rolls back a MySQL database to before a transaction was started.
	 *
	 * Causes queries submitted after a startTransaction() call not to be applied to the database.
	 * Also causes connection to return to autocommit mode.
	 */
	abstract public function rollbackTransaction();
}

?>
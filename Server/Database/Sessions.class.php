<?php

namespace Database;

/**
 * Contains properties and methods related to querying our sessions table and relations
 */
abstract class Sessions
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Abstract - Constructor for the MySQL Session Queries class
	 *
	 * Contains all queries for loading Sessions from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);

	/**
	 * Abstract - Gets a session from the database
	 *
	 * @param $Id
	 *   The session identifier
	 *
	 * @return String
	 *   The encoded session data
	 */
	abstract public function Load($Id);

	/**
	 * Abstract - Replace a Session into the database
	 *
	 * @param $Account
	 *   The Account class that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Account object was successfully inserted or not
	 */
	abstract public function Replace($Id, $Data);

	/**
	 * Abstract - Replace a Session into the database
	 *
	 * @param $Account
	 *   The Account class that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Account object was successfully inserted or not
	 */
	abstract public function Delete($Id);

	/**
	 * Abstract - Clean the sessions table
	 *
	 *
	 * @return Boolean
	 *   Whether the cleaning was successful or not.
	 */
	abstract public function Clean($Seconds);
}
?>

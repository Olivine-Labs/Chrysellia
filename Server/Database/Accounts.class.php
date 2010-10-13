<?php

namespace Database;

/**
 * Abstract class that holds definitions for account query functions
 */
abstract class Accounts
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Accounts Queries class
	 *
	 * Contains all queries for loading accounts from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);

	/**
	 * Abstract - Attempts to log $Account in
	 *
	 * @param $Account
	 *   The Account class that will be compared to the database to check a successful login.
	 *
	 * @return Boolean
	 *   Whether the login was a success or not
	 */
	abstract public function Login(\Entities\Account $Account);

	/**
	 * Abstract - Fill Account Object with data by searching for it by ID
	 *
	 * @param $Account
	 *   The Account class that will be filled with data, needs to have it's accountId property set
	 *
	 * @return Boolean
	 *   Whether the Account object was filled or not
	 */
	abstract public function LoadById(\Entities\Account $Account);

	/**
	 * Abstract - Insert an Account object into the database.
	 *
	 * @param $Account
	 *   The Account object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Account object was successfully inserted or not
	 */
	abstract public function Insert(\Entities\Account $Account);
}
?>
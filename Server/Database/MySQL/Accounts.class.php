<?php

namespace Database\MySQL;

define('SQL_GETACCOUNTBYNAMEPASSWORD', 'SELECT `accountId`, `email`, `validated`, `type`, `createdOn` FROM `accounts` WHERE `userName`=? AND `password`=?');
define('SQL_GETACCOUNTBYID', 'SELECT `userName`, `email`, `validated`, `type`, `createdOn` FROM `accounts` WHERE `accountId`=?');
define('SQL_INSERTACCOUNT', 'INSERT INTO `accounts` (`accountId`, `userName`, `password`, `email`) VALUES (?, ?, ?, ?)');

/**
 * Contains properties and methods related to querying our accounts table and relations
 */
class Accounts extends \Database\Accounts
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
	function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Attempts to log $Account in
	 *
	 * @param $Account
	 *   The Account class that will be compared to the database to check a successful login.
	 *
	 * @return Boolean
	 *   Whether the login was a success or not
	 */
	function Login(\Entities\Account $Account)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETACCOUNTBYNAMEPASSWORD);
		$Query->bind_param('ss', $Account->Name, $Account->Password);

		$Query->Execute();

		$Query->bind_result($Account->AccountId, $Account->Email, $Account->Validated, $Account->Type, $Account->CreatedOn);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Fill Account Object with data by searching for it by ID
	 *
	 * @param $Account
	 *   The Account class that will be filled with data, needs to have it's accountId property set
	 *
	 * @return Boolean
	 *   Whether the Account object was filled or not
	 */
	function LoadById(\Entities\Account $Account)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETACCOUNTBYID);
		$Query->bind_param('s', $Account->AccountId);

		$Query->Execute();

		$Query->bind_result($Account->UserName, $Account->Email, $Account->Validated, $Account->Type, $Account->CreatedOn);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Insert an Account object into the database.
	 *
	 * @param $Account
	 *   The Account class that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Account object was successfully inserted or not
	 */
	function Insert(\Entities\Account $Account)
	{
		$Account->AccountId = uniqid('ACCT_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTACCOUNT);
		$Query->bind_param('ssss', $Account->AccountId, $Account->Name, $Account->Password, $Account->Email);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}
}
?>
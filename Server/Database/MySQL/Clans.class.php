<?php

namespace Database\MySQL;
define('SQL_LOADBYID', 'SELECT `name`, `description`, `gold`, `createdOn` FROM `clans` WHERE `clanId`=?');

/**
 * class that holds definitions for clan query functions
 */
class clans extends \Database\Clans
{
	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL clans Queries class
	 *
	 * Contains all queries for loading clans from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	public function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Loads a clan
	 *
	 * @param $clan
	 *   The clan
	 *
	 * @return Boolean
	 *   Whether the clan loaded successfully or not
	 */
	public function LoadById(\Entities\Clan $AClan)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADBYID);
		$this->Database->logError();
		$Query->bind_param('s', $AClan->ClanId);
		$Query->Execute();

		$Query->bind_result($AClan->Name, $AClan->Description, $AClan->Gold, $AClan->CreatedOn);

		if($Query->fetch())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
<?php

namespace Database;

/**
 * Abstract class that holds definitions for Character query functions
 */
abstract class Characters
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Characters Queries class
	 *
	 * Contains all queries for loading Characters from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);

	/**
	 * Abstract - Fill Character Object with data by searching for it by ID
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	abstract public function LoadById(\Entities\Character $Character);

	/**
	 * Abstract - Fill Character Object with data by searching for it by Account ID
	 *
	 * @param $Account
	 *   The Account class that will be filled with data, needs to have it's AccountId property set
	 *
	 * @return Array
	 *   An array of \Entities\Character objects
	 */
	abstract public function LoadListByAccountId(\Entities\Account $Account);

	/**
	 * Abstract - Insert an Character object into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	abstract public function Insert(\Entities\Character $Character);

	/**
	 * Abstract - Fill Character Object with traits
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	abstract public function LoadTraits(\Entities\Character $Character);

	/**
	 * Abstract - Inserts a new character traits row
	 *
	 * @param $Character
	 *   The Character class that will be used to create the row
	 *
	 * @return Boolean
	 *   Whether the row was inserted or not
	 */
	abstract public function InsertTraits(\Entities\Character $Character);

	/**
	 * Abstract - Fill Character Object with position data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	abstract public function LoadPosition(\Entities\Character $Character);

	/**
	 * Abstract - Update a character's position row
	 *
	 * @param $Character
	 *   The Character class that will be used to generate this row
	 *
	 * @return Boolean
	 *   Whether the row was updated or not
	 */
	abstract public function UpdatePosition(\Entities\Character $Character);

	/**
	 * Abstract - Update a character's position x and y data
	 *
	 * @param $Character
	 *   The Character class that will be used to generate this row
	 *
	 * @return Boolean
	 *   Whether the row was updated or not
	 */
	abstract public function UpdatePositionXY(\Entities\Character $Character);

	/**
	 * Abstract - Inserts a new character position row
	 *
	 * @param $Character
	 *   The Character class that will be used to create the row
	 *
	 * @return Boolean
	 *   Whether the row was inserted or not
	 */
	abstract public function InsertPosition(\Entities\Character $Character);

	/**
	 * Abstract - Fill Character Object with race trait data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	abstract public function LoadRaceTraits(\Entities\Character $Character);

	/**
	 * Abstract - Inserts a new character race traits row
	 *
	 * @param $Character
	 *   The Character class that will be used to create the row
	 *
	 * @return Boolean
	 *   Whether the row was inserted or not
	 */
	abstract public function InsertRaceTraits(\Entities\Character $Character);

	/**
	 * Abstract - Gets a count of all characters attached to an account.
	 *
	 * @param $Account
	 *   The Account entity that will be used to lookup the characters
	 *
	 * @return int
	 *   Number of characters
	 */
	abstract public function GetCount(\Entities\Account $Account);
}
?>
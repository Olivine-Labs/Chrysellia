<?php

namespace Database;

/**
 * Abstract class that holds definitions for clan query functions
 */
abstract class Clans
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
	abstract public function __construct(Database $Database);

	/**
	 * Loads a clan list for a cell
	 *
	 * @param $Clan
	 *   The 
	 *
	 * @return Array
	 *   A list of clan entities
	 */
	abstract public function LoadById(\Entities\Clan $Clan);

	/**
	 * Updates a clan
	 *
	 * @param $clan
	 *   The clan
	 *
	 * @return Boolean
	 *   Whether the clan loaded successfully or not
	 */
	abstract public function Update(\Entities\Clan $Clan);

	/**
	 * Inserts a clan
	 *
	 * @param $Clan
	 *   The clan
	 *
	 * @return Boolean
	 *   Whether the clan loaded successfully or not
	 */
	abstract public function Insert(\Entities\Clan $Clan);
}
?>
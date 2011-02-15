<?php

namespace Database;

/**
 * Abstract class that holds definitions for Item query functions
 */
abstract class Items
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Items Queries class
	 *
	 * Contains all queries for loading Items from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);

	/**
	 * Abstract - Load a character's inventory
	 *
	 * @param $Character
	 *   The Character entity that will be used to load the inventory.
	 *   Must have it's character id property set
	 *
	 * @return Array
	 *   An array containing all the inventory items
	 */
	abstract public function LoadInventory(\Entities\Character $Character);
	
	/**
	 * Abstract - Load all system item templates
	 *
	 * @return Array
	 *   An array containing all the item templates
	 */
	abstract public function LoadAllItemTemplates();
}
?>
<?php

namespace Database;

/**
 * Abstract class that holds definitions for monster query functions
 */
abstract class monsters
{
	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL monsters Queries class
	 *
	 * Contains all queries for loading monsters from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);

	/**
	 * Loads a monster list for a cell
	 *
	 * @param $MapId
	 *   The ID of the map we're on
	 *
	 * @param $PositionX
	 *   The X coordinate
	 *
	 * @param $PositionY
	 *   The Y coordinate
	 *
	 * @return Array
	 *   A list of monster entities
	 */
	abstract public function LoadListForCell($MapId, $PositionX, $PositionY);

	/**
	 * Loads a monster
	 *
	 * @param $monster
	 *   The monster
	 *
	 * @return Boolean
	 *   Whether the monster loaded successfully or not
	 */
	abstract public function LoadById(\Entities\Monster $AMonster);
}
?>
<?php

namespace Database;

/**
 * Abstract class that holds definitions for map query functions
 */
abstract class Maps
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL maps Queries class
	 *
	 * Contains all queries for loading maps from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);

	/**
	 * Abstract - Loads a map position
	 *
	 * @param $MapId
	 *   The Map Id
	 *
	 * @param $PositionX
	 *   The X coordinate
	 *
	 * @param $PositionY
	 *   The Y coordinate
	 *
	 * @return Array
	 *   A map cell
	 */
	abstract public function LoadCell(\Entities\Map $Map, $PositionX, $PositionY);

	/**
	 * Abstract Loads a map
	 *
	 * @param $Map
	 *   The Map
	 *
	 * @return Boolean
	 *   Whether the map loaded successfully or not
	 */
	abstract public function LoadMapById(\Entities\Map $Map);
}
?>
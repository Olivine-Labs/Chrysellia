<?php

namespace Database;

/**
 * Abstract class that holds definitions for race query functions
 */
abstract class Races
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL races Queries class
	 *
	 * Contains all queries for loading races from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);

	/**
	 * Abstract - Loads a Race by Id
	 *
	 * @param $Race
	 *   The Race object that will be filled with data, must have it's id property set
	 *
	 * @return Boolean
	 *   Whether or not the load was successful
	 */
	abstract public function LoadById(\Entities\Race $Race);
}
?>
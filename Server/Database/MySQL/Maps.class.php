<?php

namespace Database\MySQL;

define('SQL_GETCELL', 'SELECT `isBlocked`, `placeId`, `isPvp`, `newMapId`, `newPositionX`, `newPositionY` FROM `map_places` WHERE `mapId`=? AND `positionX`=? AND `positionY`=?');
define('SQL_GETMAP', 'SELECT `name`, `dimensionX`, `dimensionY` FROM `maps` WHERE `mapId`=?');
define('SQL_INSERTCELL', 'INSERT INTO `map_places` (`mapId`, `placeId`, `positionX`, `positionY`, `isBlocked`, `isPvp`, `newMapId`, `newPositionX`, `newPositionY`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `placeId`=?, `isBlocked`=?, `isPvp=?`');

/**
 * class that holds definitions for map query functions
 */
class Maps extends \Database\Maps
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
	public function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Loads a map position
	 *
	 * @param $Map
	 *   The Map
	 *
	 * @param $PositionX
	 *   The X coordinate
	 *
	 * @param $PositionY
	 *   The Y coordinate
	 *
	 * @return Array
	 *   A map cell and map
	 */
	public function LoadCell(\Entities\Map $Map, $PositionX, $PositionY)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCELL);
		$Query->bind_param('sii', $Map->MapId, $PositionX, $PositionY);
		$Query->Execute();

		$Result = Array();
		$Query->bind_result($Result['Blocked'], $Result['PlaceId'], $Result['Pvp'], $Result['NewMapId'], $Result['NewMapPositionX'], $Result['newMapPositionY']);

		if($Query->fetch()){
			return $Result;
		}
		else{
			$Result['Blocked'] = false;
			$Result['PlaceId'] = null;
			return $Result;
		}
	}

	/**
	 * Loads a map
	 *
	 * @param $Map
	 *   The Map
	 *
	 * @return Boolean
	 *   Whether the map loaded successfully or not
	 */
	public function LoadMapById(\Entities\Map $Map)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETMAP);
		$Query->bind_param('s', $Map->MapId);
		$Query->Execute();

		$Query->bind_result($Map->Name, $Map->DimensionX, $Map->DimensionY);

		if($Query->fetch()){
			return true;
		}
		else{
			return false;
		}
	}
}
?>
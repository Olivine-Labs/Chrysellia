<?php

namespace Database\MySQL;

define('SQL_LOADLISTBYCELL', 'SELECT m.monsterId, m.name, m.level, m.experienceBonus, m.goldBonus, m.weaponClass, m.spellClass, m.armorClass FROM `monsters` m INNER JOIN `monster_monsters` mm ON mm.monsterId=m.monsterId WHERE mm.positionX=? AND mm.positionY=? AND mm.mapId=?');
define('SQL_LOADBYID', 'SELECT `name`, `level`, `experienceBonus`, `goldBonus`, `weaponClass`, `spellClass`, `armorClass` FROM `monsters` WHERE `monsterId`=?');

/**
 * class that holds definitions for monster query functions
 */
class monsters extends \Database\monsters
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
	public function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

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
	public function LoadListForCell($MapId, $PositionX, $PositionY)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADLISTBYCELL);
		$this->Database->logError();
		$Query->bind_param('sii', $MapId, $PositionX, $PositionY);
		$Query->Execute();
		$Continue = true;
		$Result = Array();
		$Index = 0;
		while($Continue)
		{
			$AMonster = new \Entities\Monster();
			$Query->bind_result($AMonster->MonsterId, $AMonster->Name, $AMonster->Level, $AMonster->ExperienceBonus, $AMonster->GoldBonus, $AMonster->WeaponClass, $AMonster->SpellClass, $AMonster->ArmorClass);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$Index] = $AMonster;
				$Index++;
			}
		}
	}

	/**
	 * Loads a monster
	 *
	 * @param $monster
	 *   The monster
	 *
	 * @return Boolean
	 *   Whether the monster loaded successfully or not
	 */
	public function LoadById(\Entities\Monster $AMonster)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADBYID);
		$this->Database->logError();
		$Query->bind_param('s', $AMonster->MonsterId);
		$Query->Execute();

		$Query->bind_result($AMonster->Name, $AMonster->Level, $AMonster->ExperienceBonus, $AMonster->GoldBonus, $AMonster->WeaponClass, $AMonster->SpellClass, $AMonster->ArmorClass);

		if($Query->fetch()){
			return true;
		}
		else{
			return false;
		}
	}
}
?>
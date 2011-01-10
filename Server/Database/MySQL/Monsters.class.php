<?php

namespace Database\MySQL;

define('SQL_LOADLISTBYCELL', 'SELECT m.monsterId, m.name, m.level, m.experienceBonus, m.goldBonus, m.weaponClass, m.spellClass, m.armorClass FROM `monsters` m INNER JOIN `monster_monsters` mm ON mm.monsterId=m.monsterId WHERE mm.mapId=? AND mm.positionX=? AND mm.positionY=?');
define('SQL_LOADBYID', 'SELECT `name`, `level`, `experienceBonus`, `goldBonus`, `weaponClass`, `spellClass`, `armorClass`, `alignGood`, `alignOrder` FROM `monsters` WHERE `monsterId`=?');
define('SQL_ISMONSTERINCELL', 'SELECT 1 FROM `map_monsters` mm WHERE mm.monsterId=? AND mm.mapId=? AND mm.positionX=? AND mm.positionY=?');

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

		$Query->bind_result($AMonster->Name, $AMonster->Level, $AMonster->ExperienceBonus, $AMonster->GoldBonus, $AMonster->WeaponClass, $AMonster->SpellClass, $AMonster->ArmorClass, $AMonster->AlignGood, $Monster->AlignOrder);

		if($Query->fetch()){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * Checks to see if a monster is at a cell
	 *
	 * @param $Monster
	 *   The monster
	 *
	 * @return Boolean
	 *   Whether the monster was found or not
	 */
	public function IsInCell(\Entities\Monster $AMonster)
	{
		$Query = $this->Database->Connection->prepare(SQL_ISMONSTERINCELL);
		$this->Database->logError();
		$Query->bind_param('ssss', $AMonster->MonsterId, $AMonster->MapId, $AMonster->PositionX, $AMonster->PositionY);
		$Query->Execute();

		if($Query->fetch()){
			return true;
		}
		else{
			return false;
		}
	}
}
?>
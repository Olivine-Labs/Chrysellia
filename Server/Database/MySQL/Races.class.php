<?php

namespace Database\MySQL;

define('SQL_GETRACE', 'SELECT `name`, `homeMapId`, `homePositionX`, `homePositionY`, `levelRequirement`, `alignMin`, `alignMax`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `strengthMax`, `dexterityMax`, `intelligenceMax`, `wisdomMax`, `vitalityMax`, `weaponSlots`, `armorSlots`, `accessorySlots`, `spellSlots`, `alignGood`, `alignOrder` FROM `races` WHERE raceId=?');
define('SQL_LOADDEFAULTMASTERIES', 'SELECT `masteryId`, `value`, `minValue`, `maxValue` FROM `race_default_masteries` WHERE `raceId`=?');
/**
 * Class that holds definitions for race query functions
 */
class Races
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
	public function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Loads a Race by Id
	 *
	 * @param $Race
	 *   The Race object that will be filled with data, must have it's id property set
	 *
	 * @return Boolean
	 *   Whether or not the load was successful
	 */
	public function LoadById(\Entities\Race $Race)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETRACE);
		$Query->bind_param('s', $Race->RaceId);
		$Query->Execute();

		$Query->bind_result($Race->Name, $Race->HomeMapId, $Race->HomePositionX, $Race->HomePositionY, $Race->LevelRequirement, $Race->AlignMin, $Race->AlignMax, $Race->Strength, $Race->Dexterity, $Race->Intelligence, $Race->Wisdom, $Race->Vitality, $Race->StrengthMax, $Race->DexterityMax, $Race->IntelligenceMax, $Race->WisdomMax, $Race->VitalityMax, $Race->WeaponSlots, $Race->ArmorSlots, $Race->AccessorySlots, $Race->SpellSlots, $Race->AlignGood, $Race->AlignOrder);

		if($Query->fetch()){
			return $Race;
		}
		else{
			return false;
		}
	}

	/**
	 * Load a race's default masteries
	 *
	 * @param $Race
	 *   The race entity that will be used to load the list.
	 *   Must have it's race id property set
	 *
	 * @return Array
	 *   An array containing all the default masteried
	 */
	public function LoadDefaultMasteries(\Entities\Race $Race)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADDEFAULTMASTERIES);
		$Query->bind_param('s', $Race->RaceId);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		while($Continue)
		{
			$AMastery = array();
			$Query->bind_result($AMastery['MasteryId'], $AMastery['Value'], $AMastery['Min'], $AMastery['Max']);
			$Continue = $Query->Fetch();
			if($Continue)
			{
				$Result[$AMastery['MasteryId']] = $AMastery;
			}
		}

		return $Result;
	}
}
?>
<?php

namespace Database\MySQL;

define('SQL_GETRACE', 'SELECT `name`, `homeMapId`, `homePositionX`, `homePositionY`, `levelRequirement`, `alignMin`, `alignMax`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `strengthMax`, `dexterityMax`, `intelligenceMax`, `wisdomMax`, `vitalityMax`, `armorMasteryMin`, `armorMasteryMax`, `swordMasteryMin`, `swordMasteryMax`, `axeMasteryMin`, `axeMasteryMax`, `maceMasteryMinimum`, `maceMasteryMax`, `staffMasteryMin`, `staffMasteryMax`, `shieldMasteryMin`, `shieldMasteryMax`, `fireMasteryMin`, `fireMastereyMax`, `coldMasteryMin`, `coldMasteryMax`, `arcaneMasteryMin`, `arcaneMasteryMax`, `airMasteryMin`, `airMasterytMax`, `weaponSlots`, `armorSlots`, `accessorySlots`, `spellSlots` FROM `races` WHERE raceId=?');

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
		$this->Database->logError();
		$Query->bind_param('s', $Race->RaceId);
		$Query->Execute();

		$Query->bind_result($Race->Name, $Race->HomeMapId, $Race->HomePositionX, $Race->HomePositionY, $Race->LevelRequirement, $Race->AlignMin, $Race->AlignMax, $Race->Strength, $Race->Dexterity, $Race->Intelligence, $Race->Wisdom, $Race->Vitality, $Race->StrengthMax, $Race->DexterityMax, $Race->IntelligenceMax, $Race->WisdomMax, $Race->VitalityMax, $Race->ArmorMasteryMin, $Race->ArmorMasteryMax, $Race->SwordMasteryMin, $Race->SwordMasteryMax, $Race->AxeMasteryMin, $Race->AxeMasteryMax, $Race->MaceMasteryMinimum, $Race->MaceMasteryMax, $Race->StaffMasteryMin, $Race->StaffMasteryMax, $Race->ShieldMasteryMin, $Race->ShieldMasteryMax, $Race->FireMasteryMin, $Race->FireMastereyMax, $Race->ColdMasteryMin, $Race->ColdMasteryMax, $Race->ArcaneMasteryMin, $Race->ArcaneMasteryMax, $Race->AirMasteryMin, $Race->AirMasterytMax, $Race->WeaponSlots, $Race->ArmorSlots, $Race->AccessorySlots, $Race->SpellSlots);

		if($Query->fetch()){
			return $Race;
		}
		else{
			return false;
		}
	}
}
?>
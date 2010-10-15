<?php

namespace Database\MySQL;

//Queries
//Basic
define('SQL_GETCHARACTERSBYACCOUNTID', 'SELECT c.firstName, c.middleName, c.lastName, c.createdOn, ct.strength, ct.dexterity, ct.intelligence, ct.wisdom, ct.vitality, ct.health, ct.alignGood, ct.alignOrder, ct.raceId FROM `characters` c INNER JOIN `character_traits` ct ON c.characterId=ct.characterId WHERE c.accountId=?);
define('SQL_GETCHARACTERBYID', 'SELECT `firstName`, `middleName`, `lastName`, `createdOn` FROM `Characters` WHERE `CharacterId`=?');
define('SQL_INSERTCHARACTER', 'INSERT INTO `Characters` (`characterId`, `firstName`, `middleName`, `lastName`, `biography`) VALUES (?, ?, ?, ?)');
define('SQL_GETCHARACTERCOUNT', 'SELECT count(*) FROM `Characters` WHERE `accountId`=?');

//Traits
define('SQL_GETCHARACTERTRAITS', 'SELECT `raceId`, `alignGood`, `alignOrder`, `level`, `freelevels`, `experience`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `health`, `experienceBonus`, `alignBonus`, `strengthBonus`, `dexterityBonus`, `intelligenceBonus`, `wisdomBonus`, `vitalityBonus` FROM `character_traits` WHERE `characterId`=?');
define('SQL_GETCHARACTERRACETRAITS', 'SELECT `strength`, `dexterity`, `wisdom`, `intelligence`, `vitality`, `racialAbility` FROM `character_race_traits` WHERE `characterId`=?');
define('SQL_INSERTCHARACTERTRAITS', 'INSERT INTO `character_traits` (`characterId`, `raceId`, `alignGood`, `alignOrder`, `strength`, `dexterity`, `intelligence`, `wisdom`, `vitality`, `health`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
define('SQL_INSERTCHARACTERRACETRAITS', 'INSERT INTO `character_race_traits` (`strength`, `dexterity`, `wisdom`, `intelligence`, `vitality`, `racialAbility`) VALUES (?, ?, ?, ?, ?, ?');

//Location
define('SQL_GETCHARACTERLOCATION', 'SELECT `mapId`, `positionX`, `positionY` FROM `character_locations` WHERE `characterId`=?');
define('SQL_UPDATECHARACTERLOCATION', 'UPDATE `character_locations` SET `mapId`=?, `positionX`=?, `positionY=?` WHERE `characterId`=?');
define('SQL_UPDATECHARACTERLOCATIONXY', 'UPDATE `character_locations` SET `positionX`=?, `positionY=?` WHERE `characterId`=?');
define('SQL_INSERTCHARACTERLOCATION', 'INSERT INTO character_locations (`characterId`, `mapId`, `positionX`, `positionY`) VALUES (?, ?, ?)');

/**
 * Contains properties and methods related to querying our characters table and relations
 */
class Characters extends \Database\Characters
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL Characters Queries class
	 *
	 * Contains all queries for loading Characters from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Fill Character Object with data by searching for it by ID
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadById(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERBYID);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->FirstName, $Character->MiddleName, $Character->LastName, $Character->CreatedOn);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with data by searching for it by Account ID
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Array
	 *   An Array of \Entities\Character objects
	 */
	function LoadListByAccountId(\Entities\Account $Account)
	{
		$Result = Array();
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERSBYACCOUNTID);
		$Query->bind_param('s', $AccountId);

		$Query->Execute();

		$Query->bind_result($CharacterId, $FirstName, $MiddleName, $LastName, $CreatedOn, $Strength, $Dexterity, $Intelligence, $Wisdom, $Vitality, $Health, $AlignGood, $AlignOrder, $RaceId);

		while($Query->fetch())
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $CharacterId;
			$Character->FirstName = $FirstName;
			$Character->MiddleName = $MiddleName;
			$Character->LastName = $LastName;
			$Character->CreatedOn = $CreatedOn;
			$Character->Strength = $Strength;
			$Character->Dexterity = $Dexterity;
			$Character->Intelligence = $Intelligence;
			$Character->Wisdom = $Wisdom;
			$Character->Vitality = $Vitality;
			$Character->Health = $Health;
			$Character->AlignGood = $AlignGood;
			$Character->AlignOrder = $AlignOrder;
			$Character->RaceId = $RaceId;
			array_push($Result, $Character);
		}
		return $Result;
	}

	/**
	 * Insert an Character object into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function Insert(\Entities\Character $Character)
	{
		$Character->CharacterId = uniqid('CHAR_', true);
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTER);
		$Query->bind_param('sssss', $Character->CharacterId, $Character->FirstName, $Character->MiddleName, $Character->LastName, $Character->Biography);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's trait data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERTRAITS);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->RaceId, $Character->AlignGood, $Character->AlignOrder, $Character->Level, $Character->FreeLevels, $Character->Experience, $Character->Strength, $Character->Dexterity, $Character->Intelligence, $Character->Wisdom, $Character->Vitality, $Character->Health, $Character->ExperienceBonus, $Character->AlignBonus, $Character->StrengthBonus, $Character->DexterityBonus, $Character->IntelligenceBonus, $Character->WisdomBonus, $Character->VitalityBonus);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Insert an Character object's traits into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function InsertTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTERTRAITS);
		$Query->bind_param('ssssssss', $Character->CharacterId, $Character->RaceId, $Character->AlignGood, $Character->AlignOrder, $Character->Strength, $Character->Dexterity, $Character->Intelligence, $Character->Wisdom, $Character->Vitality, $Character->Health);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's race trait data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadRaceTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERTRAITS);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->Strength, $Character->Dexterity, $Character->Intelligence, $Character->Wisdom, $Character->Vitality, $Character->RacialAbilityId);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Insert an Character object's racial traits into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function InsertRaceTraits(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTERRACETRAITS);
		$Query->bind_param('sssssss', $Character->CharacterId, $Character->Strength, $Character->Dexterity, $Character->Intelligence, $Character->Wisdom, $Character->Vitality);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's position data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function LoadPosition(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERLOCATION);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();

		$Query->bind_result($Character->MapId, $Character->PositionX, $Character->PositionY);

		if($Query->fetch())
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's position data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function UpdatePosition(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_UPDATECHARACTERLOCATION);
		$Query->bind_param('ssss', $Character->CharacterId, $Character->MapId, $Character->PositionX, $Character->PositionY);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Fill Character Object with it's position data
	 *
	 * @param $Character
	 *   The Character class that will be filled with data, needs to have it's CharacterId property set
	 *
	 * @return Boolean
	 *   Whether the Character object was filled or not
	 */
	function UpdatePositionXY(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_UPDATECHARACTERLOCATION);
		$Query->bind_param('sss', $Character->CharacterId, $Character->PositionX, $Character->PositionY);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Insert an Character object's position data into the database.
	 *
	 * @param $Character
	 *   The Character object that will be inserted.
	 *
	 * @return Boolean
	 *   Whether the Character object was successfully inserted or not
	 */
	function InsertPosition(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTCHARACTERLOCATION);
		$Query->bind_param('ssss', $Character->CharacterId, $Character->MapId, $Character->PositionX, $Character->PositionY);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Abstract - Gets a count of all characters attached to an account.
	 *
	 * @param $Account
	 *   The Account entity that will be used to lookup the characters
	 *
	 * @return int
	 *   Number of characters
	 */
	public function GetCount(\Entities\Account $Account)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETCHARACTERCOUNT);
		$Query->bind_param('s', $Account->Id);

		$Query->Execute();

		$Query->bind_result($Count);

		$Query->fetch();
		return $Count;
	}
}
?>
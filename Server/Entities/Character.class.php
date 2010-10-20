<?php

namespace Entities;

/**
 * Character Class
 */
class Character
{
	/**
	 * Id
	 *
	 * 28 character identifier
	 *
	 * @var $CharacterId
	 */
	public $CharacterId;

	/**
	 * Pin
	 *
	 * @var $Pin
	 */
	public $Pin;

	/**
	 * First Name
	 *
	 * @var $FirstName
	 */
	public $FirstName;

	/**
	 * Middle Name
	 *
	 * @var MiddleName
	 */
	public $MiddleName;

	/**
	 * Last Name
	 *
	 * @var $LastName
	 */
	public $LastName;

	/**
	 * CreatedOn
	 *
	 * The date the character was created
	 *
	 * @var $CreatedOn
	 */
	public $CreatedOn;

	/**
	 * MapId
	 *
	 * The map the character is currently located on.
	 *
	 * @var $MapId
	 */
	public $MapId;

	/**
	 * PositionX
	 *
	 * The X value of the character's coordinates
	 *
	 * @var $PositionX
	 */
	public $PositionX;

	/**
	 * PositionY
	 *
	 * The Y value of the character's coordinates
	 *
	 * @var $PositionY
	 */
	public $PositionY;

	/**
	 * RaceId
	 *
	 * An identifier that defines the character's race
	 *
	 * @var $RaceId
	 */
	public $RaceId;

	/**
	 * Gender
	 *
	 * An identifier that defines the character's gender
	 *
	 * @var $gender
	 */
	public $Gender;

	/**
	 * AlignGood
	 *
	 * A character's align on the "Good/Evil" axis
	 *
	 * @var $alignGood
	 */
	public $AlignGood;

	/**
	 * AlignEvil
	 *
	 * A character's align on the "Order/Chaos" axis
	 *
	 * @var $alignOrder
	 */
	public $AlignOrder;

	/**
	 * Level
	 *
	 * A character's level
	 *
	 * @var $Level
	 */
	public $Level;

	/**
	 * FreeLevels
	 *
	 * A character's levels that need to be "spent"
	 *
	 * @var $FreeLevels
	 */
	public $FreeLevels;

	/**
	 * Experience
	 *
	 * A character's total experience gained
	 *
	 * @var $Experience
	 */
	public $Experience;

	/**
	 * Strength
	 *
	 * A character's strength
	 *
	 * @var $Strength
	 */
	public $Strength;

	/**
	 * Dexterity
	 *
	 * A character's Dexterity
	 *
	 * @var $Dexterity
	 */
	public $Dexterity;

	/**
	 * Intelligence
	 *
	 * A character's Intelligence
	 *
	 * @var $Intelligence
	 */
	public $Intelligence;

	/**
	 * Wisdom
	 *
	 * A character's Wisdom
	 *
	 * @var $Wisdom
	 */
	public $Wisdom;

	/**
	 * Vitality
	 *
	 * A character's vitality
	 *
	 * @var $Vitality
	 */
	public $Vitality;

	/**
	 * Health
	 *
	 * A character's health
	 *
	 * @var $Health
	 */
	public $Health;

	/**
	 * ExperienceBonus
	 *
	 * A percentage that is added to all experience gained for this character.
	 *
	 * @var $ExperienceBonus
	 */
	public $ExperienceBonus;

	/**
	 * AlignBonus
	 *
	 * A percentage increase to all align gains
	 *
	 * @var $AlignBonus
	 */
	public $AlignBonus;

	/**
	 * StrengthBonus
	 *
	 * The amount of strength added from items/gems
	 *
	 * @var $StrengthBonus
	 */
	public $StrengthBonus;

	/**
	 * DexterityBonus
	 *
	 * The amount of dexterity added from items/gems
	 *
	 * @var $DexterityBonus
	 */
	public $DexterityBonus;

	/**
	 * IntelligenceBonus
	 *
	 * The amount of intelligence added from items/gems
	 *
	 * @var $IntelligenceBonus
	 */
	public $IntelligenceBonus;

	/**
	 * WisdomBonus
	 *
	 * The amount of wisdom added from items/gems
	 *
	 * @var $WisdomBonus
	 */
	public $WisdomBonus;

	/**
	 * VitalityBonus
	 *
	 * The amount of vitality added from items/gems
	 *
	 * @var $VitalityBonus
	 */
	public $VitalityBonus;

	/**
	 * RacialStrength
	 *
	 * A character's racial strength, used during leveling
	 *
	 * @var $RacialStrength
	 */
	public $RacialStrength;

	/**
	 * RacialDexterity
	 *
	 * A character's Racial Dexterity, used during leveling
	 *
	 * @var $RacialDexterity
	 */
	public $RacialDexterity;

	/**
	 * RacialIntelligence
	 *
	 * A character's Racial Intelligence, used during leveling
	 *
	 * @var $RacialIntelligence
	 */
	public $RacialIntelligence;

	/**
	 * RacialWisdom
	 *
	 * A character's Racial Wisdom, used during leveling
	 *
	 * @var $RacialWisdom
	 */
	public $RacialWisdom;

	/**
	 * RacialVitality
	 *
	 * A character's Racial vitality, used during leveling
	 *
	 * @var $RacialVitality
	 */
	public $RacialVitality;

	/**
	 * RacialAbilityId
	 *
	 * A character's Racial ability
	 *
	 * @var $RacialAbilityId
	 */
	public $RacialAbilityId;


	/**
	 * Default constructor for the Account Class
	 */
	public function __construct()
	{
		
	}

	/**
	 * Verifies character data, ensures all fields are valid.
	 */
	public function Verify()
	{
		if(isset($this->FirstName) && isset($this->MiddleName) && isset($this->LastName))
		{
			$test = $this->FirstName.$this->MiddleName.$this->LastName;
			if((strlen($test) < 3) || (strlen($test) > 150))
			{
				return false;
			}
		}
		if(isset($this->RacialStrength) && isset($this->RacialDexterity) && isset($this->RacialIntelligence) && isset($this->RacialWisdom) && isset($this->RacialVitality))
		{
			if($this->RacialStrength + $this->RacialDexterity + $this->RacialIntelligence + $this->RacialWisdom + $this->RacialVitality != 25)
			{
				return false;
			}
		} 
		return true;
	}
}

?>
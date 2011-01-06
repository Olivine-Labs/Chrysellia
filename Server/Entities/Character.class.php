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
	 * Equipment
	 *
	 * Array containing equipped items
	 *
	 * @var $Equipment
	 */
	public $Equipment;

	/**
	 * Pin
	 *
	 * @var $Pin
	 */
	public $Pin;

	/**
	 * HasPin
	 *
	 * @var $HasPin
	 */
	public $HasPin;

	/**
	 * Name
	 *
	 * @var $Name
	 */
	public $Name;

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
	 * ArmorClass
	 *
	 * The item class of the item in the armor slot
	 *
	 * @var $ArmorClass
	 */
	public $ArmorClass;

	/**
	 * RightHandClass
	 *
	 * The item class of the item in the Right Hand slot
	 *
	 * @var $RightHandClass
	 */
	public $RightHandClass;

	/**
	 * LeftHandClass
	 *
	 * The item class of the item in the LEft Hand slot
	 *
	 * @var $LeftHandClass
	 */
	public $LeftHandClass;

	/**
	 * Spell1Class
	 *
	 * The item class of the item in the spell1 slot
	 *
	 * @var $Spell1Class
	 */
	public $Spell1Class;

	/**
	 * Spell2Class
	 *
	 * The item class of the item in the spell2 slot
	 *
	 * @var $Spell2Class
	 */
	public $Spell2Class;


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
	 * Gold
	 *
	 * A character's gold
	 *
	 * @var $Gold
	 */
	public $Gold;

	/**
	 * Armor
	 *
	 * The ID of the item equipped in the armor slot
	 *
	 * @var $Armor
	 */
	public $Armor;

	/**
	 * RightHand
	 *
	 * The item equipped in the righthand slot
	 *
	 * @var $RightHand
	 */
	public $RightHand;

	/**
	 * LeftHand
	 *
	 * The item equipped in the lefthand slot
	 *
	 * @var $LeftHand
	 */
	public $LeftHand;

	/**
	 * Spell1
	 *
	 * The item equipped in the Spell1 slot
	 *
	 * @var $Spell1
	 */
	public $Spell1;

	/**
	 * Spell2
	 *
	 * The item equipped in the Spell2 slot
	 *
	 * @var $Spell2
	 */
	public $Spell2;

	/**
	 * Accessory
	 *
	 * The item equipped in the Accessory slot
	 *
	 * @var $Accessory
	 */
	public $Accessory;

	/**
	 * Default constructor for the Account Class
	 */
	public function __construct()
	{
		
	}

	/**
	 * Verifies character data, ensures all fields are valid.
	 */
	public function Verify(Race $ARace)
	{
		if(isset($this->Gender))
		{
			if(($this->Gender != 0) && ($this->Gender != 1))
			{
				return false;
			}
		}
		if(isset($this->Pin))
		{
			if(($this->Pin > 9999) || ($this->Pin < 0))
			{
				return false;
			}
		}
		if(isset($this->Name))
		{
			if((strlen($this->Name) < 3) || (strlen($this->Name) > 50))
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

			if(
				($this->RacialStrength + $ARace->Strength > $ARace->StrengthMax) ||
				($this->RacialDexterity + $ARace->Dexterity > $ARace->DexterityMax) ||
				($this->RacialIntelligence + $ARace->Intelligence > $ARace->IntelligenceMax) ||
				($this->RacialWisdom + $ARace->Wisdom > $ARace->WisdomMax) ||
				($this->RacialVitality + $ARace->Vitality > $ARace->VitalityMax)
			){
				return false;
			}
		} 
		return true;
	}
}

?>
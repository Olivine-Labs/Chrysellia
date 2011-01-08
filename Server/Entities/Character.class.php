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

	/**
	 * Checks to see if the character leveled up
	 */
	public function LevelUp()
	{
		$ExperienceToLevel = pow($this->Level + $this->FreeLevels, 8/5) * 1000 * log($this->Level+1);
		if($this->Experience > $ExperienceToLevel)
		{
			$this->FreeLevels += 1;
			return true;
		}
		return false;
	}

	/**
	 * Verifies character data, ensures all fields are valid.
	 */
	public function Attack(Monster $AMonster, $Spell=true)
	{
		$Result = array();
		$PlayerWins = false;
		$EnemyWins = false;

		$PlayerRow = array();
		foreach($this->Equipment AS $AnItem)
		{
			if(!$Spell)
			{
				if($AnItem->SlotType == 0)
				{
					$PlayerRow[count($PlayerRow)] = array('Damage'=>10, 'Heal'=>0);
				}
			}
			else
			{
				if($AnItem->SlotType == 3)
				{
					$PlayerRow[count($PlayerRow)] = array('Damage'=>10, 'Heal'=>0);
				}
			}
		}
		$Result[0] = $PlayerRow;
		
		$MonsterRow = array();
		$MonsterRow[0] = array('Damage'=>100000, 'Heal'=>50000);
		$MonsterRow[0] = array('Damage'=>120000, 'Heal'=>49000);
		$Result[1] = $MonsterRow;

		$AMonster->Health -= 10;
		if($AMonster->Health <= 0)
		{
			$PlayerWins = true;
		}
		else if($this->Health <= 0)
		{
			$EnemyWins = true;
		}

		if($PlayerWins)
		{
			$this->Experience += $Monster->EXPGiven;
			$this->Gold += $Monster->GoldGiven;

			$Result['Winner'] = 0;
			$Result['Gold'] = $Monster->GoldGiven;
			$Result['Experience'] = $Monster->EXPGiven;
			$Result['LevelUp'] = $this->LevelUp();
			unset($_SESSION['CurrentFight']);
		}
		else if($EnemyWins)
		{
			$Result['Winner'] = 1;
		}
		return $Result;
	}
}

?>
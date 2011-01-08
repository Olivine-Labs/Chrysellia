<?php

namespace Entities;

/**
 * Character Class
 */
class Character extends Being
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
	 * CreatedOn
	 *
	 * The date the character was created
	 *
	 * @var $CreatedOn
	 */
	public $CreatedOn;

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
	 * Vitality
	 *
	 * A character's vitality
	 *
	 * @var $Vitality
	 */
	public $Vitality;

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
		$ExperienceToLevel = round(pow($this->Level + $this->FreeLevels, 8/5) * 1000 * log($this->Level+1));
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
	public function Attack(Being $AnEnemy, $Spell=true)
	{
		$Result = array();
		$PlayerWins = false;
		$EnemyWins = false;

		$PlayerArmorClass = 0;
		$NumWeapons = 0;

		//Get Armor Class for player
		foreach($this->Equipment AS $AnItem)
		{
			if($AnItem->SlotType == 1)
			{
				$PlayerArmorClass += $AnItem->ItemClass;
			}
			if(!$Spell)
			{
				if($AnItem->SlotType == 0)
				{
					$NumWeapons++;
				}
			}
			else
			{
				if($AnItem->SlotType == 3)
				{
					$NumWeapons++;
				}
			}
		}
		$DamageStat = 0;
		$PlayerRow = array();
		foreach($this->Equipment AS $AnItem)
		{
			$IsWeapon = false;
			if(!$Spell)
			{
				if($AnItem->SlotType == 0)
				{
					$IsWeapon = true;
					$DamageStat = $this->Strength;
				}
			}
			else
			{
				if($AnItem->SlotType == 3)
				{
					$IsWeapon = true;
					$DamageStat = $this->Intelligence;
				}
			}
			if($IsWeapon)
			{
				$ArmorMastery = 0;
				$EnemyArmorClass = 0;
				$BaseDamage=pow(1.15,((($AnItem->ItemClass + $this->WeaponClassBonus)-($EnemyArmorClass + $AnEnemy->ArmorClassBonus))-round($ArmorMastery/5)));
				$ActualDamage=round(\gauss_ms($DamageStat/3, ($DamageStat/3) * 0.1)*$BaseDamage);
				$ActualDamage *= (1/$NumWeapons^(1.5)) / (2/3);
				$PlayerRow[count($PlayerRow)] = array('Damage'=>$ActualDamage, 'Heal'=>0);
			}
		}
		$Result[0] = $PlayerRow;
		
		$MonsterRow = array();
		$MonsterRow[0] = array('Damage'=>100000, 'Heal'=>50000);
		$MonsterRow[0] = array('Damage'=>120000, 'Heal'=>49000);
		$Result[1] = $MonsterRow;

		$AnEnemy->Health -= 10;
		if($AnEnemy->Health <= 0)
		{
			$PlayerWins = true;
		}
		else if($this->Health <= 0)
		{
			$EnemyWins = true;
		}

		if($PlayerWins)
		{
			$this->Experience += $AnEnemy->EXPGiven;
			$this->Gold += $AnEnemy->GoldGiven;

			$Result['Winner'] = 0;
			$Result['Gold'] = $AnEnemy->GoldGiven;
			$Result['Experience'] = $AnEnemy->EXPGiven;
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
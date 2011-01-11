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
	 * Bank
	 *
	 * A character's bank
	 *
	 * @var $Bank
	 */
	public $Bank;

	/**
	 * InventoryId
	 *
	 * A character's inventory
	 *
	 * @var $InventoryId
	 */
	public $InventoryId;

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
	 * EXP per level calculation
	 */
	public function CalculateExpToLevel($Level)
	{
		return round(pow($Level, 8/5) * 100 * log($Level+1));
	}

	/**
	 * Checks to see if the character leveled up
	 */
	public function LevelUp()
	{
		$ExperienceToLevel = $this->CalculateExpToLevel($this->Level + $this->FreeLevels);
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

		if(get_class($AnEnemy) == 'Entities\Monster')
		{
			$AnEnemy->Equipment = array();
			
			$Item = new \Entities\Item();
			
			if($AnEnemy->Strength > $AnEnemy->Intelligence)
			{
				$Item->SlotType = 0;
				$Item->ItemClass = $AnEnemy->WeaponClass;
			}
			else
			{
				$Item->SlotType = 3;
				$Item->ItemClass = $AnEnemy->SpellClass;
			}
			$Armor = new \Entities\Item();
			$Armor->SlotType = 1;
			$Armor->ItemClass = $AnEnemy->ArmorClass;
			$AnEnemy->Equipment[0]=$Item;
			$AnEnemy->Equipment[1]=$Item;
			$AnEnemy->Equipment[2]=$Armor;
		}

		$PlayerArmorClass = 0;
		$NumWeapons = 0;

		for($Index = 0; $Index < 2; $Index++)
		{
			$Being = null;
			$EnemyBeing = null;
			$DamageType = 0;
			if($Index == 1)
			{
				$Being = $AnEnemy;
				$EnemyBeing = $this;
				if($AnEnemy->Strength > $AnEnemy->Intelligence)
				{
					$DamageType = 0;
				}else
				{
					$DamageType  = 1;
				}
			}
			else
			{
				$EnemyBeing = $AnEnemy;
				$Being = $this;
				$DamageType = $Spell;
			}

			//Get Armor Class for player
			foreach($Being->Equipment AS $AnItem)
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

			$PlayerRow = array();	

			foreach($Being->Equipment AS $AnItem)
			{
				$DamageStat = 0;
				$HitStat = 0;
				$MissStat = 0;
				$IsWeapon = false;
				if(!$DamageType)
				{
					if($AnItem->SlotType == 0)
					{
						$IsWeapon = true;
						$DamageStat = $Being->Strength;
						$HitStat = $Being->Dexterity;
						$MissStat = $EnemyBeing->Dexterity;
					}
				}
				else
				{
					if($AnItem->SlotType == 3)
					{
						$IsWeapon = true;
						$DamageStat = $Being->Intelligence;
						$HitStat = $Being->Wisdom;
						$MissStat = $EnemyBeing->Wisdom;
					}
				}
				if($IsWeapon)
				{
					$ActualDamage=0;
					$ChanceToHitBonus = 1;
					$Mastery = 0;
					$ChanceToHit = ($HitStat/$MissStat*50*(1+$Mastery/100))*$ChanceToHitBonus;
					if(mt_rand(1,100) < $ChanceToHit)
					{
						$ArmorMastery = 0;
						$EnemyArmorClass = 0;
						$BaseDamage=pow(1.15,((($AnItem->ItemClass + $Being->WeaponClassBonus)-($EnemyArmorClass + $EnemyBeing->ArmorClassBonus))-round($ArmorMastery/5)));
						$ActualDamage=\gauss_ms($DamageStat/3, ($DamageStat/3) * 0.1)*$BaseDamage;
						$ActualDamage = round($ActualDamage * (1/max(pow($NumWeapons, 1.5), 1)) / (2/3));
					}
					$InitStat = max($Being->Dexterity, $Being->Wisdom);
					$EnemyInitStat = max($EnemyBeing->Dexterity, $EnemyBeing->Wisdom);
					$Initiative = \gauss_ms($InitStat, $InitStat * 0.2) - \gauss_ms($EnemyInitStat, $EnemyInitStat * 0.2);
					$Inserted = false;
					$PlayerRow = array('Damage'=>$ActualDamage, 'Actor'=>$Index, 'Type'=>$DamageType, 'Initiative'=>$Initiative);
					if(count($Result))
					{
						for($ArrayIndex = 0; $ArrayIndex < count($Result); $ArrayIndex++)
						{
							if($Initiative > $Result[$ArrayIndex]["Initiative"])
							{
								array_splice($Result, $ArrayIndex, 0, array($PlayerRow));
								$Inserted =true;
								break;
							}
						}
					}
					if(!$Inserted)
						$Result[count($Result)] = $PlayerRow;
				}
			}
		}

		$PlayerWins = false;
		$EnemyWins = false;
		$Length = count($Result);
		for($Index = 0; $Index < $Length; $Index++)
		{
			if(isset($Result[$Index]))
			{
				unset($Result[$Index]['Initiative']);
				$ArrayItem = $Result[$Index];
				if($ArrayItem['Actor'] == 0)
				{
					if(!$EnemyWins)
					{
						if(($ArrayItem['Type'] == 0) || ($ArrayItem['Type'] == 1))
							$AnEnemy->Health -= $ArrayItem['Damage'];
						else if($ArrayItem['Type'] == 2)
							$this->Health += $ArrayItem['Damage'];
					}
					else
					{
						unset($Result[$Index]);
					}
				}
				else
				{
					if(!$PlayerWins)
					{
						if(($ArrayItem['Type'] == 0) || ($ArrayItem['Type'] == 1))
							$this->Health -= $ArrayItem['Damage'];
						else if($ArrayItem['Type'] == 2)
							$AnEnemy->Health += $ArrayItem['Damage'];
						}
					else
					{
						unset($Result[$Index]);
					}
				}
				if($AnEnemy->Health <= 0)
				{
					$PlayerWins = true;
				}
				else if($this->Health <= 0)
				{
					$EnemyWins = true;
				}
			}
		}

		if($PlayerWins)
		{
			$Result['Winner'] = 0;
			if(get_class($AnEnemy) == 'Entities\Monster')
			{
				$this->Experience += $AnEnemy->EXPGiven;
				$this->Gold += $AnEnemy->GoldGiven;
				$Result['Gold'] = $AnEnemy->GoldGiven;
				$Result['Experience'] = $AnEnemy->EXPGiven;
			}
			else
			{
				$this->Gold += $AnEnemy->Gold;
				$Result['Gold'] = $AnEnemy->Gold;
				$AnEnemy->Gold = 0;
			}

			if(mt_rand(0,10000) < 10000)
			{
				if($AnEnemy->AlignGood >= 0)
				{
					$this->AlignGood -= 1;
					$Result['AlignGood'] = $this->AlignGood;
				}
				else
				{
					$this->AlignGood += 1;
					$Result['AlignGood'] = $this->AlignGood;
				}
				if($AnEnemy->AlignOrder >= 0)
				{
					$this->AlignOrder -= 1;
					$Result['AlignOrder'] = $this->AlignOrder;
				}
				else
				{
					$this->AlignOrder += 1;
					$Result['AlignOrder'] = $this->AlignOrder;
				}
			}
			
			$Result['LevelUp'] = $this->LevelUp();
			unset($_SESSION['CurrentFight']);
		}
		else if($EnemyWins)
		{
			$Result['Winner'] = 1;
			$LastReviveTime = 0;
			if(isset($_SESSION['LastReviveTime']))
				$LastReviveTime = $_SESSION['LastReviveTime'];
			$RevivePenaltyMultiplier = 0;

			if($LastReviveTime + (60*5) >= time())
			{
				if(isset($_SESSION['RevivePenaltyMultiplier']))
				{
					$_SESSION['RevivePenaltyMultiplier']++;
				}
				else
				{
					$_SESSION['RevivePenaltyMultiplier']=1;
				}
			}
			else
			{
				unset($_SESSION['RevivePenaltyMultiplier']);
			}

			$this->Gold = 0;
			unset($_SESSION['CurrentFight']);
		}

		return $Result;
	}
}

?>
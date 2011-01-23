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
	 * Masteries
	 *
	 * A character's masteries
	 *
	 * @var $Masteries
	 */
	public $Masteries;

	/**
	 * RacialMasteries
	 *
	 * The character's racial masteries
	 *
	 * @var $RacialMasteries
	 */
	public $RacialMasteries;

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
			$PrevLength = strlen($this->Name);
			$NewLength = strlen(trim($this->Name));
			if($NewLength != $PrevLength)
				return false;
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
		$LevelModifier = 38.19;
		$TNLMultiplier = 5;
		return round(pow($this->Level+$LevelModifier, log(($this->Level+$LevelModifier)*$TNLMultiplier, 17-($this->Level/150)))-829.53);
	}

	/**
	 * Checks to see if the character leveled up
	 */
	public function LevelUp()
	{
		$ExperienceToLevel = $this->CalculateExpToLevel($this->Level + $this->FreeLevels);
		if($this->Experience >= $ExperienceToLevel)
		{
			$this->FreeLevels += 1;
			$this->Experience = ($this->Experience - $ExperienceToLevel);
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
		$Result['Rounds'] = array();
		$Result['Masteries'] = array();
		$MonsterMasteryChance = 0;
		//Modify AnEnemy if is monster. Make it like a character.
		if(get_class($AnEnemy) == 'Entities\Monster')
		{
			//Give our monster some gear!
			$AnEnemy->Equipment = array();
			for($Index = 0; $Index < 2; $Index++)
			{
				$Item = new \Entities\Item();
				if($AnEnemy->Strength > $AnEnemy->Intelligence)
				{
					$Item->SlotType = 0;
					$Item->MasteryType = 2;
					$Item->ItemClass = $AnEnemy->WeaponClass;
				}
				else
				{
					$Item->SlotType = 3;
					if(mt_rand(1,100) < 25)
					{
						$Item->MasteryType = 11;//Heal
					}
					else
					{
						$Item->MasteryType = 6;//Fire
					}
					$Item->ItemClass = $AnEnemy->SpellClass;
				}
				$AnEnemy->Equipment[$Index]=$Item;
			}
			if($AnEnemy->MasteryBonus)
				$MonsterMasteryChance = $AnEnemy->MasteryBonus;
			$Armor = new \Entities\Item();
			$Armor->SlotType = 1;
			$Armor->ItemClass = $AnEnemy->ArmorClass;

			$AnEnemy->Equipment[2]=$Armor;
		}

		$PlayerArmorClass = 0;
		$NumWeapons = 0;

		//0 is the player, 1 is the enemy. Loop through to create "Rounds", or rows in the result set.
		for($Index = 0; $Index < 2; $Index++)
		{
			$Being = null;
			$EnemyBeing = null;
			$DamageType = 0;
			//If this is the enemy...
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
			else//This is the player
			{
				$EnemyBeing = $AnEnemy;
				$Being = $this;
				$DamageType = $Spell;
			}

			//Get Armor Class for the attacker
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

			//Fill the "Round" with attack data.
			$PlayerRow = array();	
			foreach($Being->Equipment AS $AnItem)
			{
				$DamageStat = 0;
				$HitStat = 0;
				$MissStat = 0;
				$IsWeapon = false;
				$IsHeal = false;
				$AttackType = $DamageType;
				if(!$DamageType)
				{
					//If is a weapon
					if($AnItem->SlotType == 0)
					{
						if($AnItem->MasteryType != 0)
						{
							$AttackType=0;
							$IsWeapon = true;
							$DamageStat = $Being->Strength;
							$HitStat = $Being->Dexterity;
							$MissStat = $EnemyBeing->Dexterity;
						}
					}
				}
				else
				{
					//If is a spell
					if($AnItem->SlotType == 3)
					{
						$DamageStat = $Being->Intelligence;
						$HitStat = $Being->Wisdom;
						$MissStat = $EnemyBeing->Wisdom;
						if($AnItem->MasteryType <> 11)
						{
							$AttackType = 1;
							$IsWeapon = true;
						}
						else
						{
							$AttackType = 2;
							$IsHeal = true;
						}
					}
				}

				//Initiative - shared between all damage types
				$Initiative = 0;
				if($IsWeapon || $IsHeal)
				{
					$InitStat = max($Being->Dexterity, $Being->Wisdom);
					$EnemyInitStat = max($EnemyBeing->Dexterity, $EnemyBeing->Wisdom);
					$Initiative = \gauss_ms($InitStat, $InitStat * 0.2) - \gauss_ms($EnemyInitStat, $EnemyInitStat * 0.2);

					//Damage/Heal calculations
					$ActualDamage = 0;
					$IsCritical = false;
					if($IsWeapon)
					{
						$ActualDamage=0;
						$ChanceToHitBonus = 1;
						$Mastery = 0;
						if(get_class($Being) == 'Entities\Character')
							$Mastery = $Being->Masteries[$AnItem->MasteryType]['Value'];
						$ChanceToHit = ($HitStat/$MissStat*50*(1+$Mastery/100))*$ChanceToHitBonus;
						if(mt_rand(1,100) < $ChanceToHit)
						{
							$EnemyArmorMastery = 0;
							if(get_class($AnEnemy) == 'Entities\Character')
								$EnemyArmorMastery = $EnemyBeing->Masteries[0]['Value'];
							$EnemyArmorClass = 0;
							$ItemClassBonus = $Being->WeaponClassBonus;
							if($DamageType)
								$ItemClassBonus = $Being->SpellClassBonus;
							$BaseDamage=pow(1.15,((($AnItem->ItemClass + $ItemClassBonus)-($EnemyArmorClass + $EnemyBeing->ArmorClassBonus))-round($EnemyArmorMastery/5)));
							$ActualDamage=\gauss_ms($DamageStat/3, ($DamageStat/3) * 0.1)*$BaseDamage;
							$ActualDamage = round($ActualDamage * (1/max(pow($NumWeapons, 1.5), 1)) / (2/3));
							$CritChance=mt_rand(1,20+$Mastery/10);
							if($CritChance > 19)
							{
								$IsCritical = true;
								$ActualDamage = round($ActualDamage * \gauss_ms(3, 0.5));
							}
						}
					}
					else if($IsHeal)
					{
						$BaseHeal = $Being->Intelligence/10;
						$ActualDamage = round((\gauss_ms($BaseHeal, $BaseHeal * 0.2 )*$AnItem->ItemClass)/5);
					}

					//Insert Damage/Heal into Result array ordered by initiative
					$Inserted = false;
					$PlayerRow = array('Damage'=>$ActualDamage, 'Actor'=>$Index, 'Type'=>$AttackType, 'MasteryType'=>$AnItem->MasteryType, 'Initiative'=>$Initiative, 'IsCritical'=>$IsCritical);
					for($ArrayIndex = 0; $ArrayIndex < count($Result); $ArrayIndex++)
					{
						if($Initiative > @$Result['Rounds'][$ArrayIndex]['Initiative'])
						{
							array_splice($Result['Rounds'], $ArrayIndex, 0, array($PlayerRow));
							$Inserted =true;
							break;
						}
					}
					if(!$Inserted)
						array_push($Result['Rounds'], $PlayerRow);
				}
			}
		}

		$PlayerWins = false;
		$EnemyWins = false;
		$Index = 0;
		//Clean up and finalize the Result
		while($Index < count($Result['Rounds']))
		{
			if(isset($Result['Rounds'][$Index]))
			{
				if($EnemyWins || $PlayerWins)
				{
					$Run = true;
					for($Index2 = count($Result['Rounds'])-1; $Index2 >= $Index; $Index2--)
					{
						array_pop($Result['Rounds']);
					}
					break;
				}
				else
				{
					unset($Result['Rounds'][$Index]['Initiative']);
					$ArrayItem = $Result['Rounds'][$Index];
					if($ArrayItem['Actor'] == 0)
					{
						if(($ArrayItem['Type'] == 0) || ($ArrayItem['Type'] == 1))
							$AnEnemy->Health = max($AnEnemy->Health - $ArrayItem['Damage'], 0);
						else if($ArrayItem['Type'] == 2)
							$this->Health = min($ArrayItem['Damage'] + $this->Health, $this->Vitality);

						//Mastery Gain Check
						if($this->Masteries[$ArrayItem['MasteryType']]['Value'] < $this->RacialMasteries[$ArrayItem['MasteryType']]['Max'])
						{
							$MasteryCheck = (0 >= $AnEnemy->Health)?(20+$MonsterMasteryChance):20;
							if(mt_rand(1,max(20+$this->Masteries[$ArrayItem['MasteryType']]['Value']*50,50))<$MasteryCheck)
							{
								$this->Masteries[$ArrayItem['MasteryType']]['Value']++;
								$Result['Masteries'][]= $ArrayItem['MasteryType'];
							}
						}
					}
					else
					{
						if(($ArrayItem['Type'] == 0) || ($ArrayItem['Type'] == 1))
						{
							$this->Health = max($this->Health - $ArrayItem['Damage'], 0);
							//Armor Mastery Gain Check
							if($ArrayItem['Damage'] > 0)
							{
								if($this->Masteries[$ArrayItem['MasteryType']]['Value'] < $this->RacialMasteries[$ArrayItem['MasteryType']]['Max'])
								{
									$MasteryCheck = 20+(($this->Health/$ArrayItem['Damage'])*20);
									if(mt_rand(1,max(20+$this->Masteries[0]['Value']*50,50))<$MasteryCheck)
									{
										$this->Masteries[0]['Value']++;
										$Result['Masteries'][]= 0;
									}
								}
							}
						}
						else if($ArrayItem['Type'] == 2)
							$AnEnemy->Health = min($ArrayItem['Damage'] + $AnEnemy->Health, $AnEnemy->Vitality);
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
			$Index++;
		}

		if(property_exists($AnEnemy, 'Special'))
		{
			$Result['Special'] = $AnEnemy->Special;
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
				if($AnEnemy->AlignGood || $AnEnemy->AlignOrder)
				{
					if(mt_rand(0, 2500) < 5+(2500*$AnEnemy->AlignChanceBonus))
					{
						if($AnEnemy->AlignGood > 0)
						{
							$this->AlignGood -= 1;
							$Result['AlignGood'] = $this->AlignGood;
						}
						else if($AnEnemy->AlignGood < 0)
						{
							$this->AlignGood += 1;
							$Result['AlignGood'] = $this->AlignGood;
						}
						if($AnEnemy->AlignOrder > 0)
						{
							$this->AlignOrder -= 1;
							$Result['AlignOrder'] = $this->AlignOrder;
						}
						else if($AnEnemy->AlignOrder < 0)
						{
							$this->AlignOrder += 1;
							$Result['AlignOrder'] = $this->AlignOrder;
						}
					}
				}
			}
			else
			{
				$this->Gold += $AnEnemy->Gold;
				$Result['Gold'] = $AnEnemy->Gold;
				$AnEnemy->Gold = 0;
				if($AnEnemy->AlignGood >= 0)
				{
					$this->AlignGood -= 1;
					$Result['AlignGood'] = $this->AlignGood;
				}
				else if($AnEnemy->AlignGood < 0)
				{
					$this->AlignGood += 1;
					$Result['AlignGood'] = $this->AlignGood;
				}
				if($AnEnemy->AlignOrder >= 0)
				{
					$this->AlignOrder -= 1;
					$Result['AlignOrder'] = $this->AlignOrder;
				}
				else if($AnEnemy->AlignOrder < 0)
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
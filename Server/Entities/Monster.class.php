<?php

namespace Entities;


/**
 * Monster Class
 */
class Monster extends Being
{
	/**
	 * MonsterId
	 *
	 * 28 character monster identifier
	 *
	 * @var monsterId
	 */
	public $MonsterId;

	/**
	 * ExperienceBonus
	 *
	 * @var ExperienceBonus
	 */
	public $ExperienceBonus;

	/**
	 * GoldBonus
	 *
	 * @var GoldBonus
	 */
	public $GoldBonus;

	/**
	 * DropBonus
	 *
	 * @var DropBonus
	 */
	public $DropBonus;

	/**
	 * MasteryBonus
	 *
	 * @var MasteryBonus
	 */
	public $MasteryBonus;

	/**
	 * WeaponClass
	 *
	 * @var WeaponClass
	 */
	public $WeaponClass;

	/**
	 * SpellClass
	 *
	 * @var SpellClass
	 */
	public $SpellClass;

	/**
	 * ArmorClass
	 *
	 * @var ArmorClass
	 */
	public $ArmorClass;

	/**
	 * EXPGiven
	 *
	 * The monster's experience given on kill
	 *
	 * @var $EXPGiven
	 */
	public $EXPGiven;

	/**
	 * GoldGiven
	 *
	 * The monster's gold given on kill
	 *
	 * @var $GoldGiven
	 */
	public $GoldGiven;

	/**
	 * Special
	 *
	 * What type of special monster this is
	 *
	 * @var $Special
	 */
	public $Special;

	/**
	 * Generate Stats
	 *
	 * function to generate stats for a mob based on level and bonuses.
	 *
	 */
	public function GenerateStats()
	{
		$StatSeed = 7;
		$Stats = log($StatSeed*$this->Level) * ($this->Level * 10);
		$StatsHigh = $Stats * 1.1;
		$StdDev = $StatsHigh - $Stats;
		$StatBonus = 1;

		$StrengthBonus = 1;
		$DexterityBonus = 1;
		$HealthBonus = 1;
		$IntelligenceBonus = 1;
		$WisdomBonus = 1;

		define('SPEC_MERCHANT', 1);
		define('SPEC_DEFENDER', 2);
		define('SPEC_ASSASSIN', 3);
		define('SPEC_KING', 4);
		define('SPEC_ELDER', 5);
		define('SPEC_VETERAN', 6);
		define('SPEC_FANATIC', 7);
		define('SPEC_ENIGMA', 8);
		define('SPEC_SAINT', 9);
		define('SPEC_VILLAIN', 10);
		define('SPEC_JUDGE', 11);
		define('SPEC_ANARCHIST', 12);
		define('SPEC_FOOL', 13);
		define('SPEC_ILLUSIONIST', 14);
		$this->Special = 0;
		if(mt_rand(0, 100) > 95)
		{
			$this->Special = mt_rand(0, 13);
			switch($this->Special)
			{
				case SPEC_MERCHANT:
					$this->GoldBonus *= 4;
					break;
				case SPEC_DEFENDER:
					$this->ArmorClass += 3;
					$this->GoldBonus *= 2;
					$this->ExperienceBonus *= 3;
					break;
				case SPEC_ASSASSIN:
					$this->WeaponClass += 3;
					$this->SpellClass += 3;
					$this->GoldBonus *= 3;
					$this->ExperienceBonus *= 2;
					break;
				case SPEC_KING:
					$this->GoldBonus *= 3;
					$this->ExperienceBonus *= 2;
					$this->DropBonus *= 2;
					break;
				case SPEC_ELDER:
					$this->GoldBonus *= 2;
					$this->MasteryBonus *= 2;
					break;
				case SPEC_VETERAN:
					$StatBonus = 2;
					$GoldBonus *= 2;
					$this->ExperienceBonus *= 4;
					$this->WeaponClass += 1;
					$this->SpellClass += 1;
					$this->ArmorClass += 1;
					break;
				case SPEC_FANATIC:
					$StatBonus = 3;
					$this->ExperienceBonus *= 2;
					$this->WeaponClass += 1;
					$this->SpellClass += 1;
					$this->ArmorClass += 1;
					break;
				case SPEC_ENIGMA:
					//
					break;
				case SPEC_SAINT:
					//
					break;
				case SPEC_VILLAIN:
					//
					break;
				case SPEC_JUDGE:
					//
					break;
				case SPEC_ANARCHIST:
					//
					break;
				case SPEC_FOOL:
					$this->GoldBonus = 0;
					$this->ExperienceBonus *= 2;
					$this->WeaponClass -= 1;
					$this->SpellClass -= 1;
					$this->ArmorClass -= 1;
					break;
				case SPEC_ILLUSIONIST:
					$this->GoldBonus *= 2;
					$this->ExperienceBonus *= 2;
					break;
			}
		}

		$this->Strength = round(\gauss_ms($Stats, $StdDev) * $StrengthBonus * $StatBonus);
		$this->Dexterity = round(\gauss_ms($Stats, $StdDev) * $DexterityBonus * $StatBonus);
		$this->Intelligence = round(\gauss_ms($Stats, $StdDev) * $IntelligenceBonus * $StatBonus);
		$this->Wisdom = round(\gauss_ms($Stats, $StdDev) * $WisdomBonus * $StatBonus);
		$this->Health = round(\gauss_ms($Stats, $StdDev) * $HealthBonus * $StatBonus);

		$ExpSeed = 1.1;
		$GoldSeed = 1.01;
		$this->GoldGiven = round(log($GoldSeed*($this->Level+1)) * 0.5 * ($this->Level * 5) * $this->GoldBonus);

		$this->EXPGiven = round(pow($this->Level, (7/5)) * 8 * log($this->Level+1.1) * $this->ExperienceBonus);
		$GoldStdDev = $this->GoldGiven - $this->GoldGiven * 0.90;
		$ExpStdDev = $this->EXPGiven - $this->EXPGiven * 0.90;
		$this->GoldGiven = round(\gauss_ms($this->GoldGiven, $GoldStdDev));
		$this->EXPGiven = round(\gauss_ms($this->EXPGiven, $ExpStdDev));
	}
}

?>
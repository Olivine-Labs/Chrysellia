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
	 * Generate Stats
	 *
	 * function to generate stats for a mob based on level and bonuses.
	 *
	 */
	public function GenerateStats()
	{
		$StatSeed = 25;
		$Stats = log($StatSeed*$this->Level) * ($this->Level * 10);
		$StatsHigh = $Stats * 1.1;
		$StdDev = $StatsHigh - $Stats;
		$this->Strength = round(\gauss_ms($Stats, $StdDev));
		$this->Dexterity = round(\gauss_ms($Stats, $StdDev));
		$this->Intelligence = round(\gauss_ms($Stats, $StdDev));
		$this->Wisdom = round(\gauss_ms($Stats, $StdDev));
		$this->Health = round(\gauss_ms($Stats, $StdDev));

		$ExpSeed = 1.1;
		$GoldSeed = 1.01;
		$this->GoldGiven = round(log($GoldSeed*($this->Level+1)) * 0.5 * ($this->Level * 5) + $this->GoldBonus);

		$this->EXPGiven = round(pow($this->Level, (7/5)) * 8 * log($this->Level+1.1) + $this->ExperienceBonus);
		$GoldStdDev = $this->GoldGiven - $this->GoldGiven * 0.90;
		$ExpStdDev = $this->EXPGiven - $this->EXPGiven * 0.90;
		$this->GoldGiven = round(\gauss_ms($this->GoldGiven, $GoldStdDev));
		$this->EXPGiven = round(\gauss_ms($this->EXPGiven, $ExpStdDev));
	}
}

?>
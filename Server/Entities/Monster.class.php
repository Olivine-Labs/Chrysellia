<?php

namespace Entities;


/**
 * Monster Class
 */
class Monster
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
	 * Name
	 *
	 * The map's name
	 *
	 * @var name
	 */
	public $Name;

	/**
	 * Level
	 *
	 * @var Level
	 */
	public $Level;

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
	 * MapId
	 *
	 * The map the monster is currently located on.
	 *
	 * @var $MapId
	 */
	public $MapId;

	/**
	 * PositionX
	 *
	 * The X value of the monster's coordinates
	 *
	 * @var $PositionX
	 */
	public $PositionX;

	/**
	 * PositionY
	 *
	 * The Y value of the monster's coordinates
	 *
	 * @var $PositionY
	 */
	public $PositionY;

	/**
	 * Health
	 *
	 * The monster's hp
	 *
	 * @var $Health
	 */
	public $Health;

	/**
	 * Strength
	 *
	 * The monster's strength
	 *
	 * @var $Strength
	 */
	public $Strength;

	/**
	 * Dexterity
	 *
	 * The monster's dex
	 *
	 * @var $Dexterity
	 */
	public $Dexterity;

	/**
	 * Intelligence
	 *
	 * The monster's int
	 *
	 * @var $Intelligence
	 */
	public $Intelligence;

	/**
	 * Wisdom
	 *
	 * The monster's wisdom
	 *
	 * @var $Wisdom
	 */
	public $Wisdom;

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

		$ExpSeed = 5;
		$GoldSeed = 1;
		$this->GoldGiven = round(log($GoldSeed*$this->Level) * ($this->Level * 5) * $this->GoldBonus);
		$this->EXPGiven = round(log($ExpSeed*$this->Level) * ($this->Level * 5) * $this->ExperienceBonus);
		$GoldStdDev = $this->GoldGiven - $this->GoldGiven * 0.90;
		$ExpStdDev = $this->EXPGiven - $this->EXPGiven * 0.90;
		$this->GoldGiven = round(\gauss_ms($this->GoldGiven, $GoldStdDev));
		$this->EXPGiven = round(\gauss_ms($this->EXPGiven, $ExpStdDev));
	}
}

?>
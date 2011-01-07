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
		$this->Strength = gauss_ms($Stats, $StdDev);
		$this->Dexterity = gauss_ms($Stats, $StdDev);
		$this->Intelligence = gauss_ms($Stats, $StdDev);
		$this->Wisdom = gauss_ms($Stats, $StdDev);
		$this->Health = gauss_ms($Stats, $StdDev);

		//TODO
		$this->GoldGiven = 1;
		$this->ExperienceGiven = 10;
	}
}

?>
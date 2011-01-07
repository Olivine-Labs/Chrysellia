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
}

?>
<?php

namespace Entities;


/**
 * Being Class
 */
abstract class Being
{

	/**
	 * Equipment
	 *
	 * Array containing equipped items
	 *
	 * @var $Equipment
	 */
	public $Equipment;

	/**
	 * Name
	 *
	 * The being's name
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
	 * MapId
	 *
	 * The map the being is currently located on.
	 *
	 * @var $MapId
	 */
	public $MapId;

	/**
	 * PositionX
	 *
	 * The X value of the being's coordinates
	 *
	 * @var $PositionX
	 */
	public $PositionX;

	/**
	 * PositionY
	 *
	 * The Y value of the being's coordinates
	 *
	 * @var $PositionY
	 */
	public $PositionY;

	/**
	 * Health
	 *
	 * The being's hp
	 *
	 * @var $Health
	 */
	public $Health;

	/**
	 * Strength
	 *
	 * The being's strength
	 *
	 * @var $Strength
	 */
	public $Strength;

	/**
	 * Dexterity
	 *
	 * The being's dex
	 *
	 * @var $Dexterity
	 */
	public $Dexterity;

	/**
	 * Intelligence
	 *
	 * The being's int
	 *
	 * @var $Intelligence
	 */
	public $Intelligence;

	/**
	 * Wisdom
	 *
	 * The being's wisdom
	 *
	 * @var $Wisdom
	 */
	public $Wisdom;

	/**
	 * WeaponClassBonus
	 *
	 * @var $WeaponClassBonus
	 */
	public $WeaponClassBonus;

	/**
	 * ArmorClassBonus
	 *
	 * @var $ArmorClassBonus
	 */
	public $ArmorClassBonus;

	/**
	 * SpellClassBonus
	 *
	 * @var $SpellClassBonus
	 */
	public $SpellClassBonus;

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
}

?>
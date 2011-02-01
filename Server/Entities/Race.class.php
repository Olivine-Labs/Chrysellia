<?php

namespace Entities;


/**
 * Race Class
 */
class Race
{
	/**
	 * Id
	 *
	 * 28 character race identifier
	 *
	 * @var raceId
	 */
	public $RaceId;

	/**
	 * Name
	 *
	 * @var userName
	 */
	public $Name;

	/**
	 * homeMapId
	 *
	 * 28 character map identifier
	 *
	 * @var homeMapId
	 */
	public $HomeMapId;

	/**
	 * homePositionX
	 *
	 * @var homePositionX
	 */
	public $HomePositionX;

	/**
	 * homePositionY
	 *
	 * @var homePositionY
	 */
	public $HomePositionY;

	/**
	 * LevelRequirement
	 *
	 * The required level to reincarnate to this race.
	 *
	 * @var LevelRequirement
	 */
	public $LevelRequirement;

	/**
	 * AlignMin
	 *
	 * The minimum alignment to reincarnate to this race
	 *
	 * @var AlignMin
	 */
	public $AlignMin;

	/**
	 * AlignMax
	 *
	 * The minimum alignment to reincarnate to this race
	 *
	 * @var AlignMax
	 */
	public $AlignMax;

	/**
	 * Strength
	 *
	 * @var strength
	 */
	public $Strength;

	/**
	 * Dexterity
	 *
	 * @var dexterity
	 */
	public $Dexterity;

	/**
	 * Intelligence
	 *
	 * @var intelligence
	 */
	public $Intelligence;

	/**
	 * Wisdom
	 *
	 * @var wisdom
	 */
	public $Wisdom;

	/**
	 * Vitality
	 *
	 * @var vitality
	 */
	public $Vitality;

	/**
	 * StrengthMax
	 *
	 * @var strengthMax
	 */
	public $StrengthMax;

	/**
	 * DexterityMax
	 *
	 * @var dexterityMax
	 */
	public $DexterityMax;

	/**
	 * IntelligenceMax
	 *
	 * @var intelligenceMax
	 */
	public $IntelligenceMax;

	/**
	 * WisdomMax
	 *
	 * @var wisdomMax
	 */
	public $WisdomMax;

	/**
	 * VitalityMax
	 *
	 * @var vitalityMax
	 */
	public $VitalityMax;

	/**
	 * WeaponSlots
	 *
	 * @var WeaponSlots
	 */
	public $WeaponSlots;

	/**
	 * ArmorSlots
	 *
	 * @var ArmorSlots
	 */
	public $ArmorSlots;

	/**
	 * AccessorySlots
	 *
	 * @var AccessorySlots
	 */
	public $AccessorySlots;

	/**
	 * SpellSlots
	 *
	 * @var SpellSlots
	 */
	public $SpellSlots;

	/**
	 * AlignGood
	 *
	 * @var AlignGood
	 */
	public $AlignGood;

	/**
	 * AlignOrder
	 *
	 * @var AlignOrder
	 */
	public $AlignOrder;

	/**
	 * Default constructor for the Account Class
	 */
	public function __construct()
	{
		
	}

}

?>
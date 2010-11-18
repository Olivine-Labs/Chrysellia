<?php

namespace Entities;

define('BT_PERCENT', 0);
define('BT_VALUE', 1);

/**
 * Item Script Environment Class
 */
class ItemScriptEnvironment
{
	/**
	 * Character
	 *
	 * An instance of the character entity
	 *
	 * @var character
	 */
	private $Character;

	/**
	 * Item
	 *
	 * An instance of the Item entity
	 *
	 * @var item
	 */
	private $Item;

	/**
	 * Default constructor for the ScriptEnvironment Class
	 */
	public function __construct(\Entities\Character $Character, \Entities\Item $Item)
	{
		$this->Character = $Character;
		$this->Item = $Item;
	}

	public function __call($name, $arguments)
	{
		switch($name)
		{
			case 'Equip':
				eval($this->Item->OnEquip);
				break;
			case 'Unequip':
				eval($this->Item->OnUnequip);
				break;
			case 'Use':
				eval($this->Item->OnUse);
				break;
			default:
				break;
		}
	}

	private function AddStrength($bonus, $type)
	{
		switch($type)
		{
			case BT_VALUE:
				$this->Character->StrengthBonus += $bonus;
				break;
			case BT_PERCENT:
				$this->Character->StrengthBonus += $this->Character->Strength * ($bonus/100);
				break;
		}
	}

	private function AddDexterity($bonus, $type)
	{
		switch($type)
		{
			case BT_VALUE:
				$this->Character->DexterityBonus += $bonus;
				break;
			case BT_PERCENT:
				$this->Character->DexterityBonus += $this->Character->Dexterity * ($bonus/100);
				break;
		}
	}

	private function AddIntelligence($bonus, $type)
	{
		switch($type)
		{
			case BT_VALUE:
				$this->Character->IntelligenceBonus += $bonus;
				break;
			case BT_PERCENT:
				$this->Character->IntelligenceBonus += $this->Character->Intelligence * ($bonus/100);
				break;
		}
	}

	private function AddWisdom($bonus, $type)
	{
		switch($type)
		{
			case BT_VALUE:
				$this->Character->WisdomBonus += $bonus;
				break;
			case BT_PERCENT:
				$this->Character->WisdomBonus += $this->Character->Wisdom * ($bonus/100);
				break;
		}
	}

	private function AddVitality($bonus, $type)
	{
		switch($type)
		{
			case BT_VALUE:
				$this->Character->VitalityBonus += $bonus;
				break;
			case BT_PERCENT:
				$this->Character->VitalityBonus += $this->Character->Vitality * ($bonus/100);
				break;
		}
	}

	private function AddHealth($bonus, $type)
	{
		switch($type)
		{
			case BT_VALUE:
				$this->Character->Health = min($this->Character->Health + $bonus, $this->Character->Vitality + $this->Character->VitalityBonus);
				break;
			case BT_PERCENT:
				$this->Character->Health = min($this->Character->Health + (($this->Character->Vitality + $this->Character->VitalityBonus) * ($bonus/100)), $this->Character->Vitality + $this->Character->VitalityBonus);
				break;
		}
	}

	private function AddArmorClass($bonus)
	{
		$this->Character->ArmorClassBonus += $bonus;
	}

	private function AddWeaponClass($bonus)
	{
		$this->Character->WeaponClassBonus += $bonus;
	}
}

?>
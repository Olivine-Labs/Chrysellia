<?php

namespace Entities;


/**
 * Item Class
 */
class Item
{
	/**
	 * Id
	 *
	 * 28 character Item identifier
	 *
	 * @var ItemId
	 */
	public $ItemId;

	/**
	 * Name
	 *
	 * @var Name
	 */
	public $Name;

	/**
	 * Description
	 *
	 * @var description
	 */
	public $Description;

	/**
	 * Type
	 *
	 * @var type
	 */
	public $Type;

	/**
	 * CreatedOn
	 *
	 * @var createdOn
	 */
	public $CreatedOn;

	/**
	 * Sockets
	 *
	 * @var sockets
	 */
	public $Sockets;

	/**
	 * SocketedIn
	 *
	 * @var socketedIn
	 */
	public $SocketedIn;

	/**
	 * Slots
	 *
	 * @var slots
	 */
	public $Slots;

	/**
	 * SlotType
	 *
	 * @var slotType
	 */
	public $SlotType;

	/**
	 * OnEquip
	 *
	 * @var onEquip
	 */
	public $OnEquip;

	/**
	 * OnUnequip
	 *
	 * @var onUnequip
	 */
	public $OnUnequip;

	/**
	 * OnAttack
	 *
	 * @var onAttack
	 */
	public $OnAttack;

	/**
	 * OnDefend
	 *
	 * @var onDefend
	 */
	public $OnDefend;

	/**
	 * OnSocket
	 *
	 * @var onSocket
	 */
	public $OnSocket;

	/**
	 * OnUse
	 *
	 * @var onUse
	 */
	public $OnUse;

	/**
	 * BuyPrice
	 *
	 * @var BuyPrice
	 */
	public $BuyPrice;

	/**
	 * SellPrice
	 *
	 * @var SellPrice
	 */
	public $SellPrice;
}

?>
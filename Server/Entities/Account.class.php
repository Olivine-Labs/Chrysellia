<?php

namespace Entities;


/**
 * Account Class
 */
class Account
{
	/**
	 * Id
	 *
	 * 28 character account identifier
	 *
	 * @var accountId
	 */
	public Id;

	/**
	 * Name
	 *
	 * @var userName
	 */
	public Name;

	/**
	 * Password
	 *
	 * @var password
	 */
	public Password;

	/**
	 * Type
	 *
	 * 0 = banned, 1 = normal, 2 = admin
	 *
	 * @var type
	 */
	public Type;

	/**
	 * Validated
	 *
	 * Whether or not the account has passed email validation.
	 *
	 * @var validated
	 */
	public Validated;

	/**
	 * CreatedOn
	 *
	 * The date the account was created
	 *
	 * @var createdOn
	 */
	public CreatedOn;

	/**
	 * Default constructor for the Account Class
	 */
	public function __construct()
	{
		
	}


	/**
	 * Constructor for the Account Class
	 *
	 * @param $Id
	 *   The account's 28 character string Identifier
	 *
	 * @param $Name
	 *   The account's Name
	 *
	 * @param $Type
	 *   The Type of account. 0 = banned, 1 = normal, 2 = admin
	 *
	 * @param $Validated
	 *   Whether the account's email has been validated or not.
	 *
	 * @param $CreatedOn
	 *   Timestamp when the account was created
	 */
	public function __construct($Id, $Name, $Password, $Type, $Validated, $CreatedOn)
	{
		$this->Id = $Id;
		$this->Name = $Name;
		$this->Password = $Password;
		$this->Type = $Type;
		$this->Validated = $Validated;
		$this->CreatedOn = $CreatedOn;
	}

	/**
	 * Verifies account data, ensures all fields are valid.
	 */
	public function Verify()
	{
		if(isset($this->Name))
		{
			if((strlen($this->Name) < 8) || (strlen($this->Name)) > 50)
			{
				return false;
			}
		}
		if(isset($this->Password))
		{
			if(strlen($this->Password) != 16)
			{
				return false;
			}
		}
		if(isset($this->Email))
		{
			if((strlen($this->Email) < 3) && (strlen($this->Email) > 150))
			{
				return false;
			}
		}
	}

	/**
	 * Fills the account with data from a json_decoded post object
	 */
	public function Fill($Post)
	{
		if(property_exists($Post->Data, 'UserName')
		{
			$this->Name = $Post->Data->UserName;
		}
		if(property_exists($Post->Data, 'Password')
		{
			$this->Password = $Post->Data->Password;
		}
		if(property_exists($Post->Data, 'Email')
		{
			$this->Email = $Post->Data->Email;
		}
	}
}

?>
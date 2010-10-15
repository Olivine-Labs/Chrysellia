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
	public $Id;

	/**
	 * Name
	 *
	 * @var userName
	 */
	public $Name;

	/**
	 * Password
	 *
	 * @var password
	 */
	public $Password;

	/**
	 * Type
	 *
	 * 0 = banned, 1 = normal, 2 = admin
	 *
	 * @var type
	 */
	public $Type;

	/**
	 * Validated
	 *
	 * Whether or not the account has passed email validation.
	 *
	 * @var validated
	 */
	public $Validated;

	/**
	 * CreatedOn
	 *
	 * The date the account was created
	 *
	 * @var createdOn
	 */
	public $CreatedOn;

	/**
	 * Default constructor for the Account Class
	 */
	public function __construct()
	{
		
	}

	/**
	 * Verifies account data, ensures all fields are valid.
	 */
	public function Verify()
	{
		if(isset($this->Name))
		{
			if((strlen($this->Name) < 4) || (strlen($this->Name)) > 50))
			{
				return false;
			}
		}
		if(isset($this->Password))
		{
			if(strlen($this->Password) != 32)
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
		if(property_exists($Post, 'UserName'))
		{
			$this->Name = $Post->UserName;
		}
		if(property_exists($Post, 'Password'))
		{
			$this->Password = $Post->Password;
		}
		if(property_exists($Post, 'Email'))
		{
			$this->Email = $Post->Email;
		}
	}
}

?>
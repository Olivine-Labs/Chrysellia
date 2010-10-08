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
}

?>
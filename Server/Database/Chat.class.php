<?php

namespace Database;

/**
 * Abstract class that holds definitions for chat query functions
 */
abstract class Chat
{

	/**
	 * Contains a reference to the parent Database class
	 */
	public $Database;

	/**
	 * Constructor for the MySQL chats Queries class
	 *
	 * Contains all queries for loading chat from the database
	 *
	 * @param $Parent
	 *   The Database class that the queries contained here will manipulate
	 */
	abstract public function __construct(Database $Database);


	/**
	 * Abstract - Inserts a chat message into the database
	 *
	 * @param $Character
	 *   The Character object that will be used to insert "from" information.
	 *
	 * @param $Channel
	 *   The channel id
	 *
	 * @param $Message
	 *   The text to be shown in channel
	 *
	 * @return Boolean
	 *   Whether the insert was successful or not.
	 */
	abstract public function Insert(\Entities\Character $Character, $Channel, $Message);

	/**
	 * Abstract - Loads a list of chat messages for a character
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @param $Channel
	 *   A channel id to load chat for.
	 *
	 * @return Array
	 *   An array of chat messages
	 */
	abstract public function LoadListForChannel(\Entities\Character $Character, $Channel, $DateForward);

	/**
	 * Loads a list of chat messages for a character
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @param $Channel
	 *   A channel id to load chat for.
	 *
	 * @return Array
	 *   An array of chat messages
	 */
	abstract public function LoadListForCharacter(\Entities\Character $Character, $DateForward);

	/**
	 * Abstract - Joins a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
	 *
	 * @param $Channel
	 *   The name of the channel the character wishes to join.
	 *
	 * @return String
	 *   The id of the channel or null if access is denied
	 */
	abstract public function JoinChannel(\Entities\Character $Character, $Channel);
}
?>
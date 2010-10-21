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
	 * @param $ChannelId
	 *   The channel id
	 *
	 * @param $Message
	 *   The text to be shown in channel
	 *
	 * @return Boolean
	 *   Whether the insert was successful or not.
	 */
	abstract public function Insert(\Entities\Character $Character, $ChannelId, $Message);

	/**
	 * Abstract - Loads a list of chat messages for a character
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @param $ChannelId
	 *   A channel id to load chat for.
	 *
	 * @param $DateForward
	 *   The max date from which to get chat messages from
	 *
	 * @return Array
	 *   An array of chat messages
	 */
	abstract public function LoadListForChannel(\Entities\Character $Character, $ChannelId, $DateForward);

	/**
	 * Loads a list of chat messages for a character
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @param $DateForward
	 *   The max date from which to get chat messages from
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
	 * @param $ChannelName
	 *   The name of the channel the character wishes to join.
	 *
	 * @return String
	 *   The id of the channel or null if access is denied
	 */
	abstract public function JoinChannel(\Entities\Character $Character, $ChannelName);

	/**
	 * Abstract - Creates a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
	 *
	 * @param $ChannelName
	 *   The name of the channel
	 *
	 * @return String
	 *   The id of the channel or null if access is denied
	 */
	abstract public function CreateChannel($ChannelName);

	/**
	 * Abstract - Gets a character's rights to a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
	 *
	 * @param $ChannelId
	 *   The id of the channel
	 *
	 * @return Array
	 *   An array of rights or false
	 */
	abstract public function GetRights(\Entities\Character $Character, $ChannelId);

	/**
	 * Abstract - Sets rights on a channel
	 *
	 * @param $Character
	 *   The Character object that will be given permissions
	 *
	 * @param $ChannelId
	 *   The id of the channel to which rights will be given
	 *
	 * @return Boolean
	 *   Whether or not the update was successful
	 */
	abstract public function SetRights(\Entities\Character $ACharacter, $ChannelId, Array $Rights);
}
?>
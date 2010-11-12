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
	abstract public function Insert(\Entities\Character $Character, $ChannelId, $Message, $Type=0, \Entities\Character $CharacterTarget = null);

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
	 *   The max date from when to return data
	 *
	 * @return Array
	 *   An array of chat messages
	 */
	abstract public function LoadList(\Entities\Character $Character, $ChannelId, $DateForward);


	/**
	 * abstract - Loads a list of system messages for a character
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup system messages
	 *
	 * @param $DateForward
	 *   The max date from when to return data
	 *
	 * @return Array
	 *   An array of system messages
	 */
	abstract public function LoadSystemList(\Entities\Character $Character, $DateForward);

	/**
	 * Abstract - Loads a list of joined channels
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @return Array
	 *   An array of channels
	 */
	abstract public function LoadJoinedChannels(\Entities\Character $Character);

	/**
	 * Abstract - Joins a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
	 *
	 * @param $ChannelName
	 *   The name of the channel the character wishes to join.
	 *
	 * @return Boolean/String
	 *   ChannelId or false if access is denied
	 */
	abstract public function JoinChannel(\Entities\Character $Character, $ChannelName);

	/**
	 * Abstract - Leaves a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
	 *
	 * @param $ChannelId
	 *   The id of the channel the character wishes to leave.
	 *
	 * @return Boolean
	 *   true or false if isJoined set successfully
	 */
	abstract public function LeaveChannel(\Entities\Character $Character, $ChannelId);

	/**
	 * Abstract - Creates a channel
	 *
	 * @param $Channel
	 *   The name of the channel the character wishes to create
	 *
	 * @return String
	 *   The id of the channel or false if access is denied
	 */
	abstract public function CreateChannel($ChannelName, $Motd);

	/**
	 * Abstract - Gets a character's rights to a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
	 *
	 * @param $ChannelId
	 *   The id of the channel
	 *
	 * @return String
	 *   An array of rights or false
	 */
	abstract public function GetRights(\Entities\Character $Character, $ChannelId);

	/**
	 * Abstract - Gets a character's rights to a channel
	 *
	 * @param $Character
	 *   The Character object that will be given permissions
	 *
	 * @param $ChannelId
	 *   The id of the channel
	 *
	 * @param $Rights
	 *   The Rights array
	 *
	 * @return Boolean
	 *   whether or not the insert succeded
	 */
	abstract public function SetRights(\Entities\Character $Character, $ChannelId, Array $Rights);
}
?>
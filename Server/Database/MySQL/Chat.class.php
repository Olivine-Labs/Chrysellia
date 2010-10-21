<?php

namespace Database\MySQL;

define('SQL_GETMESSAGESINCHANNEL', 'SELECT c.message, c.fromName, c.type, c.sentOn FROM `chat` c INNER JOIN `channel_permissions` p ON p.channelId=c.channelId AND p.characterId=? WHERE c.channelId=? AND p.accessChat=1 AND c.sentOn>?');
define('SQL_JOINCHANNEL', 'SELECT c.channelid FROM `channels` c INNER JOIN `channel_permissions` p ON c.channelId=p.channelId AND p.characterId=? AND p.accessChat=1 WHERE c.Name=?');
define('SQL_CHANNELGETRIGHTS', 'SELECT `accessRead`, `accessWrite`, `accessModerator`, `accessAdmin` FROM `channel_permissions` WHERE `channelId`=?');
define('SQL_INSERTMESSAGE', 'INSERT INTO `chat` (`characterIdFrom`, `channelId`, `message`, `fromName`) VALUES (?, ?, ?, ?)');
define('SQL_GETMESSAGESFORCHARACTER', 'SELECT `message`, `fromName`, `sentOn` FROM `chat` WHERE `type`=2 AND `characterIdTo`=? `sentOn`>?');
define('SQL_CHANNELSETRIGHTS', 'INSERT INTO `channel_permissions` (`characterId`, `channelId`, `accessRead`,`accessWrite`,`accessModerator`,`accessAdmin`) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE UPDATE `accessRead`=?, `accessWrite`=?, `accessModerate`=?, `accessAdmin`=?');
/**
 * Contains properties and methods related to querying our chat table and relations
 */
class Chat extends \Database\Chat
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
	function __construct(Database $Database)
	{
		$this->Database = $Database;
	}

	/**
	 * Inserts a chat message into the database
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
	public function Insert(\Entities\Character $Character, $ChannelId, $Message)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTMESSAGE);
		$Query->bind_param('ssss', $Character->CharacterId, $ChannelId, $Message, $Character->Name);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Loads a list of chat messages for a character
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @param $ChannelId
	 *   An channel id to load chat for.
	 *
	 * @param $DateForward
	 *   The max date from when to return data
	 *
	 * @return Array
	 *   An array of chat messages
	 */
	public function LoadListForChannel(\Entities\Character $Character, $ChannelId, $DateForward)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETMESSAGES);
		$Query->bind_param('sss', $Character->CharacterId, $ChannelId, $DateForward);

		$Query->Execute();	
		$Continue = true;
		$Index = 0;
		$Result = Array();
		while($Continue)
		{
			$Query->bind_result($Result[$Index]['Message'], $Result[$Index]['FromName'], $Result[$Index]['Type'], $Result[$Index]['SentOn']);
			$Continue = $Query->Fetch();
			$Index ++;
		}

		return $Result;
	}

	/**
	 * Loads a list of chat messages for a character
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @param $DateForward
	 *   The max date from when to return data
	 *
	 * @return Array
	 *   An array of chat messages
	 */
	public function LoadListForCharacter(\Entities\Character $Character, $DateForward)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETMESSAGESFORCHARACTER);
		$Query->bind_param('ss', $Character->CharacterId, $DateForward);

		$Query->Execute();	
		$Continue = true;
		$Index = 0;
		$Result = Array();
		while($Continue)
		{
			$Query->bind_result($Result[$Index]['Message'], $Result[$Index]['FromName'], $Result[$Index]['SentOn']);
			$Continue = $Query->Fetch();
			$Index ++;
		}

		return $Result;
	}

	/**
	 * Joins a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
	 *
	 * @param $ChannelName
	 *   The name of the channel the character wishes to join.
	 *
	 * @return String
	 *   The id of the channel or false if access is denied
	 */
	public function JoinChannel(\Entities\Character $Character, $ChannelName)
	{
		$Query = $this->Database->Connection->prepare(SQL_JOINCHANNEL);
		$Query->bind_param('ss', $Character->CharacterId, $ChannelName);

		$Query->Execute();

		$Query->bind_result($ChannelId);

		if($Query->fetch())
			return $ChannelId;
		else
			return false;
	}

	/**
	 * Creates a channel
	 *
	 * @param $Channel
	 *   The name of the channel the character wishes to create
	 *
	 * @return String
	 *   The id of the channel or false if access is denied
	 */
	public function CreateChannel($ChannelName)
	{
		$ChannelId = uniqid('CHAN_', true);
		$Query = $this->Database->Connection->prepare(SQL_CREATECHANNEL);
		$Query->bind_param('ss', $ChannelId, $ChannelName);

		$Query->Execute();

		if($Query->fetch())
			return $ChannelId;
		else
			return false;
	}

	/**
	 * Gets a character's rights to a channel
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
	public function GetRights(\Entities\Character $Character, $ChannelId)
	{
		$Query = $this->Database->Connection->prepare(SQL_CHANNELGETRIGHTS);
		$Query->bind_param('ss', $Character->CharacterId, $ChannelId);

		$Query->Execute();
		$Result = Array();
		$Query->bind_result($Result['Read'], $Result['Write'], $Result['Moderate'], $Result['Administrate']);

		if($Query->fetch())
			return $Result;
		else
			return false;
	}

	/**
	 * Gets a character's rights to a channel
	 *
	 * @param $Character
	 *   The Character object that will be checked for permissions
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
	public function SetRights(\Entities\Character $Character, $ChannelId, Array $Rights)
	{
		$Query = $this->Database->Connection->prepare(SQL_CHANNELSETRIGHTS);
		$Query->bind_param('ssiiiiiiii', $Character->CharacterId, $ChannelId, $Rights['Read'], $Rights['Write'], $Rights['Moderate'], $Rights['Administrate'], $Rights['Read'], $Rights['Write'], $Rights['Moderate'], $Rights['Administrate']);

		$Query->Execute();

		if($Query->fetch())
			return true;
		else
			return false;
	}

}
?>
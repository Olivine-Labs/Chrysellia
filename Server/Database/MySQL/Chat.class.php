<?php

namespace Database\MySQL;

define('SQL_GETMESSAGES', 'SELECT c.message, c.fromName, c.type, UNIX_TIMESTAMP(c.sentOn) FROM `chat` c INNER JOIN `channel_permissions` p ON p.channelId=c.channelId AND p.characterId=? AND p.characterId != c.characterIdFrom WHERE c.channelId=? AND p.accessRead=1 AND c.sentOn>FROM_UNIXTIME(?) ORDER BY c.sentOn ASC');
define('SQL_JOINCHANNEL', 'SELECT c.channelid FROM `channels` c INNER JOIN `channel_permissions` p ON c.channelId=p.channelId AND p.characterId=? AND p.accessRead=1 WHERE c.Name=?');
define('SQL_CHANNELGETRIGHTS', 'SELECT `accessRead`, `accessWrite`, `accessModerator`, `accessAdmin` FROM `channel_permissions` WHERE `characterId`=? AND `channelId`=?');
define('SQL_INSERTMESSAGE', 'INSERT INTO `chat` (`characterIdFrom`, `channelId`, `message`, `fromName`, `type`) VALUES (?, ?, ?, ?, ?)');
define('SQL_CHANNELSETRIGHTS', 'INSERT INTO `channel_permissions` (`characterId`, `channelId`, `accessRead`,`accessWrite`,`accessModerator`,`accessAdmin`) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE `accessRead`=?, `accessWrite`=?, `accessModerator`=?, `accessAdmin`=?');
define('SQL_CHANNELGETJOINEDLIST', 'SELECT p.channelId, c.name FROM `channel_permissions` p INNER JOIN channels c ON c.channelId=p.channelId WHERE p.characterId`=?');
define('SQL_CHANNELSETJOINED', 'INSERT INTO `channel_permissions` (`characterId`, `channelId`, `isJoined`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `isJoined`=?');

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
	public function Insert(\Entities\Character $Character, $ChannelId, $Message, $Type=0)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTMESSAGE);
		
		$Query->bind_param('sssss', $Character->CharacterId, $ChannelId, $Message, $Character->Name, $Type);

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
	public function LoadList(\Entities\Character $Character, $ChannelId, $DateForward)
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

		if(count($Result) > 0)
		{
			array_pop($Result);
		}

		return $Result;
	}

	/**
	 * Loads a list of joined channels
	 *
	 * @param $Character
	 *   The Character object that will be used to lookup chat messages
	 *
	 * @return Array
	 *   An array of channels
	 */
	public function LoadJoinedChannels(\Entities\Character $Character)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETMESSAGES);
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();	
		$Continue = true;
		$Result = Array();
		while($Continue)
		{
			$Query->bind_result($ChannelId, $Name);
			if($Continue = $Query->Fetch())
			{
				$Result[$ChannelId] = $Name;
			}
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
	 * @return Boolean/String
	 *   ChannelId or false if access is denied
	 */
	public function JoinChannel(\Entities\Character $Character, $ChannelName)
	{
		$Query = $this->Database->Connection->prepare(SQL_JOINCHANNEL);
		$Query->bind_param('ss', $Character->CharacterId, $ChannelName);

		$Query->Execute();

		$Query->bind_result($ChannelId);

		if($Query->fetch())
		{
			$Query2 = $this->Database->Connection->prepare(SQL_CHANNELSETJOINED);
			$Query2->bind_param('ssi', $Character->CharacterId, $ChannelId, 1);

			$Query2->Execute();

			if($Query2->affected_rows <= 0)
				return false;
			return $ChannelId;

		}
		else
		{
			return false;
		}
	}

	/**
	 * Leaves a channel
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
	public function LeaveChannel(\Entities\Character $Character, $ChannelId)
	{
		$Query = $this->Database->Connection->prepare(SQL_CHANNELSETJOINED);
		$Query->bind_param('ssi', $Character->CharacterId, $ChannelId, 0);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
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
			$Result = Array('Read'=>0, 'Write'=>0, 'Moderate'=>0, 'Administrate'=>0);
			return $Result;
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

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

}
?>
<?php

namespace Database\MySQL;

define('SQL_GETMESSAGES', 'SELECT c.message, c.fromName, c.type, UNIX_TIMESTAMP(c.sentOn) FROM `chat` c INNER JOIN `channel_permissions` p ON p.channelId=c.channelId AND p.characterId=? AND p.characterId != c.characterIdFrom WHERE c.type!=255 AND c.channelId=? AND p.accessRead=1 AND c.sentOn>FROM_UNIXTIME(?) ORDER BY c.sentOn ASC');
define('SQL_GETSYSTEMMESSAGES', 'SELECT c.message, c.fromName, c.type, UNIX_TIMESTAMP(c.sentOn) FROM `chat` c WHERE ((c.characterIdTo=?) OR (c.characterIdTo IS NULL)) AND c.type=255 AND c.sentOn>FROM_UNIXTIME(?) ORDER BY c.sentOn ASC');
define('SQL_CHANNELGETRIGHTS', 'SELECT p.accessRead, p.accessWrite, p.accessModerator, p.accessAdmin, p.isJoined, c.name, c.defaultAccessRead, c.defaultAccessWrite FROM `channel_permissions` p right JOIN `channels` c ON (c.channelId=p.channelId AND p.characterId=?) WHERE c.channelId=?');
define('SQL_CHANNELGETRIGHTSBYNAME', 'SELECT c.channelId, p.accessRead, p.accessWrite, p.accessModerator, p.accessAdmin, p.isJoined, c.name, c.defaultAccessRead, c.defaultAccessWrite FROM `channel_permissions` p right JOIN `channels` c ON (c.channelId=p.channelId AND p.characterId=?) WHERE c.name=?');
define('SQL_INSERTMESSAGE', 'INSERT INTO `chat` (`characterIdFrom`, `characterIdTo`, `channelId`, `message`, `fromName`, `type`) VALUES (?, ?, ?, ?, ?, ?)');
define('SQL_CHANNELSETRIGHTS', 'INSERT INTO `channel_permissions` (`characterId`, `channelId`, `accessRead`,`accessWrite`,`accessModerator`,`accessAdmin`, `isJoined`) VALUES (?, ?, coalesce(?, 0), coalesce(?, 0), coalesce(?, 0), coalesce(?, 0), coalesce(?, 0)) ON DUPLICATE KEY UPDATE `accessRead`=?, `accessWrite`=?, `accessModerator`=?, `accessAdmin`=?, `isJoined`=?');
define('SQL_CHANNELGETJOINEDLIST', 'SELECT p.channelId, c.name, c.motd FROM `channel_permissions` p INNER JOIN `channels` c ON c.channelId=p.channelId WHERE p.isJoined=1 AND p.characterId=?');
define('SQL_CHANNELSETJOINED', 'INSERT INTO `channel_permissions` (`characterId`, `channelId`, `isJoined`) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE `isJoined`=?');
define('SQL_CREATECHANNEL','INSERT INTO `channels` (`channelId`, `name`, `motd`, `defaultAccessRead`, `defaultAccessWrite`) VALUES (?, ?, ?, ?, ?)');
define('SQL_UPDATECHANNEL','UPDATE `channels` SET `motd`=?, `defaultAccessRead`=?, `defaultAccessWrite`=? WHERE `channelId`=?');
define('SQL_LOADCHANNEL','SELECT `motd`, `defaultAccessRead`, `defaultAccessWrite` FROM `channels` WHERE `channelId`=?');
//API
define('SQL_PUBLICCHANNELLIST', 'SELECT c.channelId, c.name, c.motd FROM `channels` c WHERE c.defaultAccessRead=1 ORDER BY c.name ASC LIMIT ?, ?');
define('SQL_PUBLICCHANNELCOUNT', 'SELECT count(*) FROM `channels` c WHERE c.defaultAccessRead=1');

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
	public function Insert(\Entities\Character $Character, $ChannelId, $Message, $Type=0, \Entities\Character $CharacterTarget = null)
	{
		$Query = $this->Database->Connection->prepare(SQL_INSERTMESSAGE);
		$this->Database->logError();
		if($Type==255)
			$Message = serialize($Message);
		$Query->bind_param('ssssss', $Character->CharacterId, $CharacterTarget->CharacterId, $ChannelId, $Message, $Character->Name, $Type);

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
		$this->Database->logError();
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
	 * Loads a list of system messages for a character
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
	public function LoadSystemList(\Entities\Character $Character, $DateForward)
	{
		$Query = $this->Database->Connection->prepare(SQL_GETSYSTEMMESSAGES);
		$this->Database->logError();
		$Query->bind_param('ss', $Character->CharacterId, $DateForward);

		$Query->Execute();
		$Continue = true;
		$Index = 0;
		$Result = Array();
		while($Continue)
		{
			$Query->bind_result($Result[$Index]['Message'], $Result[$Index]['FromName'], $Result[$Index]['Type'], $Result[$Index]['SentOn']);
			$Continue = $Query->Fetch();
			$Result[$Index]['Message'] = unserialize($Result[$Index]['Message']);
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
		$Query = $this->Database->Connection->prepare(SQL_CHANNELGETJOINEDLIST);
		$this->Database->logError();
		$Query->bind_param('s', $Character->CharacterId);

		$Query->Execute();	
		$Continue = true;
		$Result = Array();
		$Index = 0;
		$Data = Array();
		
		while($Continue)
		{
			$Query->bind_result($ChannelId, $Name, $Motd);
			if($Continue = $Query->Fetch())
			{
				$Data = Array("Name" => $Name, "Motd" => $Motd);
				$Result[$ChannelId] = $Data;
			}
		}

		return $Result;
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
		$this->Database->logError();
		$zeroseriouslywtf = 0;
		
		$Query->bind_param('ssii', $Character->CharacterId, $ChannelId, $zeroseriouslywtf, $zeroseriouslywtf);
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
	public function CreateChannel($ChannelName, $Motd, $defaultAccessRead, $defaultAccessWrite)
	{
		$ChannelId = uniqid('CHAN_', true);
		$Query = $this->Database->Connection->prepare(SQL_CREATECHANNEL);
		$this->Database->logError();
		$Query->bind_param('sssii', $ChannelId, $ChannelName, $Motd, $defaultAccessRead, $defaultAccessWrite);

		$Query->Execute();

		if($Query->affected_rows > 0)
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
		$this->Database->logError();
		$Query->bind_param('ss', $Character->CharacterId, $ChannelId);
		
		$Query->Execute();
		$Result = Array();
		$Query->bind_result($Result['Read'], $Result['Write'], $Result['Moderate'], $Result['Administrate'], $Result['isJoined'], $Result['Name'], $Result['defaultAccessRead'], $Result['defaultAccessWrite']);
		
		if($Query->fetch())
			return $Result;
		else
			$Result = Array('Read'=>0, 'Write'=>0, 'Moderate'=>0, 'Administrate'=>0, 'isJoined'=>0, 'Name'=>'', 'defaultAccessRead'=>0, 'defaultAccessWrite'=>0);
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
	 * @return String
	 *   An array of rights or false
	 */
	public function GetRightsByName(\Entities\Character $Character, $ChannelName)
	{
		$Query = $this->Database->Connection->prepare(SQL_CHANNELGETRIGHTSBYNAME);
		$this->Database->logError();
		$Query->bind_param('ss', $Character->CharacterId, $ChannelName);
		
		$Query->Execute();
		$Result = Array();
		$Query->bind_result($Result['ChannelId'], $Result['Read'], $Result['Write'], $Result['Moderate'], $Result['Administrate'], $Result['isJoined'], $Result['Name'], $Result['defaultAccessRead'], $Result['defaultAccessWrite']);
		
		if($Query->fetch())
			return $Result;
		else
			$Result = Array('ChannelId'=>null, 'Read'=>0, 'Write'=>0, 'Moderate'=>0, 'Administrate'=>0, 'isJoined'=>0, 'Name'=>'', 'defaultAccessRead'=>0, 'defaultAccessWrite'=>0);
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
		$this->Database->logError();
		if(!isset($Rights['Read']))
			$Rights['Read'] = 0;
		if(!isset($Rights['Write']))
			$Rights['Write'] = 0;
		if(!isset($Rights['Moderate']))
			$Rights['Moderate'] = 0;
		if(!isset($Rights['Administrate']))
			$Rights['Administrate'] = 0;
		if(!isset($Rights['isJoined']))
			$Rights['isJoined'] = 0;
		$Query->bind_param('ssiiiiiiiiii', $Character->CharacterId, $ChannelId, $Rights['Read'], $Rights['Write'], $Rights['Moderate'], $Rights['Administrate'], $Rights['isJoined'], $Rights['Read'], $Rights['Write'], $Rights['Moderate'], $Rights['Administrate'], $Rights['isJoined']);

		$Query->Execute();

		if($Query->affected_rows > 0)
			return true;
		else
			return false;
	}

	/**
	 * Updates a channel
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
	public function UpdateChannel($ChannelId, $Motd, $defaultAccessRead, $defaultAccessWrite)
	{
		$Query = $this->Database->Connection->prepare(SQL_UPDATECHANNEL);
		$this->Database->logError();
		$Query->bind_param('siis', $Motd, $defaultAccessRead, $defaultAccessWrite, $ChannelId);

		$Query->Execute();

		if($Query->affected_rows > -1)
			return true;
		else
			return false;
	}

	/**
	 * Loads a list of channels
	 *
	 * @return Array
	 *   An array of channels
	 */
	public function LoadChannel($ChannelId)
	{
		$Query = $this->Database->Connection->prepare(SQL_LOADCHANNEL);
		$this->Database->logError();
		$Query->bind_param('s', $ChannelId);

		$Query->Execute();
		$Query->bind_result($Name, $Motd, $DefaultAccessRead, $DefaultAccessWrite);
		$Query->Fetch();
		$Result = Array("Name" => $Name, "Motd" => $Motd, "defaultAccessRead"=>$DefaultAccessRead, "defaultAccessWrite"=>$DefaultAccessWrite);
		return $Result;
	}

	/**
	 * Loads a list of channels
	 *
	 * @return Array
	 *   An array of channels
	 */
	public function LoadPublicChannelList($NumRows, $Position)
	{
		$Query = $this->Database->Connection->prepare(SQL_PUBLICCHANNELLIST);
		$this->Database->logError();
		$Query->bind_param('ii', $Position, $NumRows);

		$Query->Execute();
		$Continue = true;
		$Result = Array();
		
		while($Continue)
		{
			$Query->bind_result($ChannelId, $Name, $Motd);
			if($Continue = $Query->Fetch())
			{
				array_push($Result, Array("ChannelId"=> $ChannelId, "Name" => $Name, "Motd" => $Motd));
			}
		}

		return $Result;
	}

	/**
	 * Loads a list of channels
	 *
	 * @return Array
	 *   An array of channels
	 */
	public function LoadPublicChannelCount()
	{
		$Query = $this->Database->Connection->prepare(SQL_PUBLICCHANNELCOUNT);
		$this->Database->logError();

		$Query->Execute();
		$Query->bind_result($Result);
		$Query->Fetch();

		return $Result;
	}

}
?>
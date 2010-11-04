<?php
/**
 * Channel refresh logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	$ChatArray = array();

	if(!isset($_SESSION['Channels']))
	{
		$_SESSION['Channels'] = $Database->Chat->LoadJoinedChannels($Character);
		foreach($_SESSION['Channels'] AS &$Value)
		{
			$Value = new stdClass();
		}
	}
	foreach($_SESSION['Channels'] AS $ChannelId=>&$Value)
	{
		if(is_object($Value))
		{
			if(!isset($Value->LastRefresh))
			{
				$Value->LastRefresh = time() - 300;
			}
			$TempArray = $Database->Chat->LoadList($Character, $ChannelId, $Value->LastRefresh);
			if(count($TempArray) > 0)
			{
				$Value->LastRefresh = $TempArray[count($TempArray)-1]['SentOn'];
			}
			$ChatArray[$ChannelId] = $TempArray;
		}
	}
	$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
	$Result->Set('Data', $ChatArray);
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
<?php
/**
 * Channel refresh logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

try
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	$ChatArray = array();
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
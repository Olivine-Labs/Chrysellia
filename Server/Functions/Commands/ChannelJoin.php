<?php
/**
 * Join Channel
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(property_exists($Post, 'Channel'))
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Channel = $Database->Chat->JoinChannel($Character, $Post->Channel))
		{
			$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
			$Result->Set('Data', $Channel);
			$_SESSION['Channels'][$Channel["ChannelId"]] = new stdClass();
			$_SESSION['Channels'][$Channel["ChannelId"]]->LastRefresh = time() - 300;
		}
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>
<?php
/**
 * Join Channel
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(property_exists($Get, 'Channel'))
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Channel = $Database->Chat->JoinChannel($Character, $Get->Channel))
		{
			$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
			$Result->Set('Data', Array('ChannelId'=>$Channel));
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
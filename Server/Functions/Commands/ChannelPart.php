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
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Chat->LeaveChannel($Character, $Get->Channel))
	{
		unset($_SESSION['Channels'][$ChannelId]);
		$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_BADDATA);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>
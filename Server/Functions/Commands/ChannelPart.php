<?php
namespace Functions\Commands;
/**
 * Join Channel
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new stdClass();
}

if(property_exists($Get, 'Channel'))
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Chat->LeaveChannel($Character, $Get->Channel))
	{
		unset($_SESSION['Channels'][$Get->Channel]);
		$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
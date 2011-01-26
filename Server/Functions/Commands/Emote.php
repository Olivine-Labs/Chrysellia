<?php
/**
 * Emotion
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

if(
	property_exists($Get, 'Message') &&
	property_exists($Get, 'Channel')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadById($Character))
	{
		if($Database->Chat->Insert($Character, $Get->Channel, $Get->Message, 1))
		{
			$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
		}else
		{
			$Response->Set('Result', \Protocol\Response::ER_BADDATA);
		}
	}else
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
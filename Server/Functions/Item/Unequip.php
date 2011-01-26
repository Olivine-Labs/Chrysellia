<?php
/**
 * Unequip item from character
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

if(property_exists($Get, 'ItemId'))
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	$Item = new \Entities\Item();
	$Item->ItemId = $Get->ItemId;
	if($Database->Items->UnequipItem($Character, $Item))
	{
		$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
	}else
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_BADDATA);
}
?>
<?php
/**
 * Unequip item from character
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
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
}
catch(Exception $e)
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	$Response->Set('Error', $e->getMessage());
}

?>
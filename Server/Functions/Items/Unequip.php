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
			$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
			$Result->Set('Data', $Inventory);
		}else
		{
			$Result->Set('Result', \Protocol\Result::ER_DBERROR);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_BADDATA);
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
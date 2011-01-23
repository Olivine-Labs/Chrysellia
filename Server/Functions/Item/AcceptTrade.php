<?php
/**
 * Accept trade
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'TradeId')
)
{
	if(is_array($Trade = $Database->Items->LoadTrade($TradeId)))
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		$Database->Characters->LoadById($Character);
		if($Trade['InventoryToId'] == $Character->InventoryId)
		{
			$Success = true;
			$Database->startTransaction();
			foreach($Trade AS $Row)
			{
				$Item = new \Entities\Item();
				$Item->ItemId = $Trade['ItemId'];
				if(!$Database->Items->ChangeInventory($Item, $Character->InventoryId))
				{
					$Response->Set('Result', \Protocol\Response::ER_DBERROR);
					$Success = false;
					break;
				}
			}

			if(!$Database->DeleteTrade($Get->TradeId))
			{
				$Success = false;
				$Response->Set('Result', \Protocol\Response::ER_DBERROR);
			}

			if($Success)
			{
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
				$Database->commitTransaction();
			}
			else
			{
				$Database->rollbackTransaction();
			}
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_BADDATA);
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>

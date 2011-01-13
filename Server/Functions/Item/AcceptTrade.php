<?php
/**
 * Accept trade
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	if(
		property_exists($Get, 'TradeId')
	)
	{
		if(is_array($Trade = $Database->Items->LoadTrade($TradeId)))
		{
			if($Trade['CharacterId'] == $_SESSION['CharacterId'])
			{
				$Character = new \Entities\Character();
				$Character->CharacterId = $_SESSION['CharacterId'];
				$Database->Characters->LoadById($Character);
				$Success = true;
				$Database->startTransaction();
				foreach($Trade AS $Row)
				{
					$Item = new \Entities\Item();
					$Item->ItemId = $Trade['ItemId'];
					if(!$Database->Items->ChangeInventory($Item, $Character->InventoryId))
					{
						$Result->Set('Result', \Protocol\Result::ER_DBERROR);
						$Success = false;
						break;
					}
				}

				if(!$Database->DeleteTrade($Get->TradeId))
				{
					$Success = false;
					$Result->Set('Result', \Protocol\Result::ER_DBERROR);
				}

				if($Success)
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					$Database->commitTransaction();
				}
				else
				{
					$Database->rollbackTransaction();
				}
			}
			else
			{
				$Result->Set('Result', \Protocol\Result::ER_BADDATA);
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_DBERROR);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>

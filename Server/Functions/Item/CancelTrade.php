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
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			$Database->Characters->LoadById($Character);
			if($Trade['InventoryFromId'] == $Character->InventoryId)
			{
				$Success = true;

				if(!$Database->DeleteTrade($Get->TradeId))
				{
					$Success = false;
					$Result->Set('Result', \Protocol\Result::ER_DBERROR);
				}

				if($Success)
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
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

<?php
/**
 * Send trade to character
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	if(
		property_exists($Get, 'Items') &&
		property_exists($Get, 'Cost') &&
		property_exists($Get, 'CharacterName')
	)
	{
		if(is_array($Get->Items))
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			if($Database->Characters->LoadById($Character))
			{
				$TargetCharacter = new \Entities\Character();
				$TargetCharacter->Name = $Get->CharacterName;
				if($Database->Characters->CheckName($TargetCharacter))
				{
					$Database->startTransaction();
					$ItemsOwned = true;
					$Success = true;
					if(!$TradeId = $Database->Items->InsertTrade($Character->InventoryId, $TargetCharacter->InventoryId, $Get->Cost))
					{
						$Success = false;
					}

					foreach($Get->Items AS $JSONItem)
					{
						$Item = new \Entities\Item();
						$Item->ItemId = $JSONItem['ItemId'];
						if(!$Database->Items->CharacterOwnsItem($Item))
						{
							$Result->Set('Result', \Protocol\Result::ER_BADDATA);
							$ItemsOwned = false;
							break;
						}
						else
						{
							if(!$Database->Items->InsertTradeItem($TradeId, $Item, 0))
							{
								$Success = false;
								$Result->Set('Result', \Protocol\Result::ER_DBERROR);
								break;
							}
						}
					}

					if($ItemsOwned && $Success)
					{
						$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
						$Data = array('MessageType'=>2, 'TradeId'=>$TradeId, 'Cost'=>$Get->Cost, 'Items'=>array());
						$Index = 0;
						foreach($Get->Items AS $JSONItem)
						{
							$Item = new \Entities\Item();
							$Item->ItemId = $JSONItem['ItemId'];
							$Database->Items->LoadById($Item);
							$Data['Items'][$Index] = $Item;
							$Index++;
						}
						$Database->Chat->Insert($Character, 'CHAN_00000000000000000000001', $Data, 255, $TargetCharacter);
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
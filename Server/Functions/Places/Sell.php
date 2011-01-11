<?php
/**
 * Sell Logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'ItemId')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character) && $Database->Characters->LoadById($Character))
	{
		$Map = new \Entities\Map();
		$Map->MapId = $Character->MapId;
		if($Cell = $Database->Maps->LoadCell($Map, $Character->PositionX, $Character->PositionY))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000001')
			{
				$Success = false;
				$Database->startTransaction();
				$Item = new \Entities\Item();
				$Item->ItemId = $Get->ItemId;
				if($Database->Items->LoadById($Item) && $Database->Items->CharacterOwnsItem($Character, $Item))
				{
					$Character->Gold += $Item->SellPrice;
					if($Database->Items->Delete($Item) && $Database->Characters->UpdateTraits($Character))
					{
						$Success = true;
					}
				}
				else
				{
					$Result->Set('Result', \Protocol\Result::ER_BADDATA);
				}

				if($Success)
				{
					$Database->commitTransaction();
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				}
				else
				{
					$Database->rollbackTransaction();
					$Result->Set('Result', \Protocol\Result::ER_DBERROR);
				}
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_DBERROR);
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
?>
<?php
namespace Functions\Places;
/**
 * Sell Logic
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
					$Response->Set('Result', \Protocol\Response::ER_BADDATA);
				}

				if($Success)
				{
					$Database->commitTransaction();
					$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
				}
				else
				{
					$Database->rollbackTransaction();
					$Response->Set('Result', \Protocol\Response::ER_DBERROR);
				}
			}
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_DBERROR);
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
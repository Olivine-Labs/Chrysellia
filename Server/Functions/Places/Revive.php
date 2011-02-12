<?php
namespace Functions\Places;
/**
 * Revive Logic
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

$LastReviveTime = 0;
$RevivePenaltyMultiplier = 0;
if(isset($_SESSION['LastReviveTime']))
	$LastReviveTime = $_SESSION['LastReviveTime'];
if(isset($_SESSION['RevivePenaltyMultiplier']))
	$RevivePenaltyMultiplier = $_SESSION['RevivePenaltyMultiplier'];

//if($LastReviveTime + 15 * $RevivePenaltyMultiplier < time())
//{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character))
	{
		$Map = new \Entities\Map();
		$Map->MapId = $Character->MapId;
		if($Cell = $Database->Maps->LoadCell($Map, $Character->PositionX, $Character->PositionY))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000002')
			{
				if($Character->Health <=0)
				{
					$Character->Health = $Character->Vitality;
					if($Database->Characters->UpdateTraits($Character))
					{
						$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
						$_SESSION['LastReviveTime'] = time();
					}
					else
					{
						$Response->Set('Result', \Protocol\Response::ER_DBERROR);
					}
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
//}
?>
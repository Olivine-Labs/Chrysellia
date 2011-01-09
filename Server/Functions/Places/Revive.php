<?php
/**
 * Revive Logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

$LastReviveTime = 0;
$RevivePenaltyMultiplier = 0;
if(isset($_SESSION['LastReviveTime']))
	$LastReviveTime = $_SESSION['LastReviveTime'];
if(isset($_SESSION['RevivePenaltyMultiplier']))
	$RevivePenaltyMultiplier = $_SESSION['RevivePenaltyMultiplier'];

if($LastReviveTime + 15 * $RevivePenaltyMultiplier < time())
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character))
	{
		if($Cell = $Database->Maps->GetCell($Character->MapId, $Character->PositionX, $Character->PositionY))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000002')
			{
				$Character->Health = $Character->Vitality;
				if($Database->Character->UpdateTraits($Character))
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					$_SESSION['LastReviveTime'] = time();
				}
				else
				{
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

?>
<?php
/**
 * Withdraw Logic
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
	property_exists($Get, 'Gold')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character) && $Database->Characters->LoadById($Character))
	{
		$Map = new \Entities\Map();
		$Map->MapId = $Character->MapId;
		if(is_array($Cell = $Database->Maps->LoadCell($Map, $Character->PositionX, $Character->PositionY)))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000003')
			{
				if($Get->Gold > 0 && $Character->Bank >= $Get->Gold)
				{
					$Character->Bank -= $Get->Gold;
					$Character->Gold += $Get->Gold;
					if($Database->Characters->UpdateTraits($Character))
					{
						$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
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
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
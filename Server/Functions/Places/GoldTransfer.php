<?php
/**
 * Transfer Logic
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
	property_exists($Get, 'Gold') &&
	property_exists($Get, 'Name')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadPosition($Character))
	{
		$Map = new \Entities\Map();
		$Map->MapId = $Character->MapId;
		if($Cell = $Database->Maps->LoadCell($Map, $Character->PositionX, $Character->PositionY))
		{
			if($Cell['PlaceId'] == 'PLAC_00000000000000000000003')
			{
				if($Get->Gold > 0 && $Character->Bank >= $Get->Gold)
				{
					$TargetCharacter = new \Entities\Character();
					$TargetCharacter->Name = $Get->Name;
					if($Database->Characters->CheckName($TargetCharacter))
					{
						if($TargetCharacter->CharacterId != $Character->CharacterId)
						{
							if($Database->Characters->LoadTraits($TargetCharacter))
							{
								$TargetCharacter->Bank += $Get->Gold;
								$Character->Bank -= $Get->Gold;
								if($Database->Characters->UpdateTraits($Character) && $Database->Characters->UpdateTraits($TargetCharacter))
								{
									$Database->Characters->LoadById($Character);
									$Message['Amount'] = $Get->Gold;
									$Message['MessageType'] = 3;
									$Message['From'] = $Character->Name;
									if($Database->Chat->Insert($Character, 'CHAN_00000000000000000000001', $Message, 255, $TargetCharacter))
									{
										$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
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
								$Response->Set('Result', \Protocol\Response::ER_DBERROR);
							}
						}
						else
						{
							$Response->Set('Result', \Protocol\Response::ER_BADDATA);
						}
					}
					else
					{
						$Response->Set('Result', \Protocol\Response::ER_BADDATA);
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
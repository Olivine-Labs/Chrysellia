<?php
/**
 * Character movement logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadPosition($Character))
	{
		$Map = new \Entities\Map();
		$Map->MapId = $Character->MapId;
		if(is_array($Cell = $Database->Maps->LoadCell($Map->MapId, $Character->PositionX, $Character->PositionY)))
		{
			if(isset($Cell['NewMapId']))
			{
				$Character->MapId = $Cell['NewMapId'];
				$Character->PositionX = $Cell['NewPositionX'];
				$Character->PositionY = $Cell['NewPositionY'];
				if($Database->Characters->UpdatePosition($Character))
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					$Result->Set('Data', Array('MapId'=>$Character->MapId, 'X'=>$Character->PositionX, 'Y'=>$Character->PositionY));
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
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}


?>
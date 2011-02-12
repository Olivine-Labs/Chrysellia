<?php
namespace Functions\Map;
/**
 * Character movement logic
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new \stdClass();
}

$Character = new \Entities\Character();
$Character->CharacterId = $_SESSION['CharacterId'];
if($Database->Characters->LoadPosition($Character))
{
	$Map = new \Entities\Map();
	$Map->MapId = $Character->MapId;
	if(is_array($Cell = $Database->Maps->LoadCell($Map, $Character->PositionX, $Character->PositionY)))
	{
		if(isset($Cell['NewMapId']))
		{
			$Character->MapId = $Cell['NewMapId'];
			$Character->PositionX = $Cell['NewPositionX'];
			$Character->PositionY = $Cell['NewPositionY'];
			if($Database->Characters->UpdatePosition($Character))
			{
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
				$Response->Set('Data', Array('MapId'=>$Character->MapId, 'X'=>$Character->PositionX, 'Y'=>$Character->PositionY));
			}
			else
			{
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
?>
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
}
catch(Exception $e)
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	$Response->Set('Error', $e->getMessage());
}


?>
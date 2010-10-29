<?php
/**
 * Character movement logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post, 'PositionX') &&
	property_exists($Post, 'PositionY')
){
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadPosition($Character))
		{
			$DiffX = abs($Character->PositionX - $Post->PositionX);
			$DiffY = abs($Character->PositionY - $Post->PositionY);
			if(
				($DiffX <= 1) &&
				($DiffY <= 1)
			){
				if($DiffX + $DiffY == 2)
				{
					$_SESSION['NextAction'] = microtime(true) + 1.5;
				}
				else
				{
					$_SESSION['NextAction'] = time() + 1;
				}
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				$Result->Set('Data', Array('X'=>$Post->PositionX, 'Y'=>$PositionY));
			}
			else
			{
				$Result->Set('Result', \Protocol\Result::ER_BADDATA);
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_BADDATA);
		}
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}

?>
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
	property_exists($Post, 'X') &&
	property_exists($Post, 'Y')
){
	if(
		($Post->X >= 0) &&
		($Post->Y >= 0)
	){
		try
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			if($Database->Characters->LoadPosition($Character))
			{
				$DiffX = abs($Character->PositionX - $Post->X);
				$DiffY = abs($Character->PositionY - $Post->Y);
				if(
					($DiffX <= 1) &&
					($DiffY <= 1)
				){
					$Map = new \Entities\Map();
					$Map->MapId = $Character->MapId;
					if($Database->Maps->LoadById($Map))
					{
						if(
							($Post->X < $Map->DimensionX) &&
							($Post->Y < $Map->DimensionY)
						){
							$Cell = $Database->Maps->LoadCell($Map, $Post->X, $Post->Y);
							if(!$Cell['Blocked'])
							{
								if($DiffX + $DiffY == 2)
								{
									$_SESSION['NextAction'] = microtime(true) + 1.5;
								}
								else
								{
									$_SESSION['NextAction'] = time() + 1;
								}
								$Character->PositionX = $Post->X;
								$Character->PositionY = $Post->Y;
								if($Database->Character->UpdatePosition($Character))
								{
									$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
									$Result->Set('Data', Array('X'=>$Post->X, 'Y'=>$Post->Y));
								}
								else
								{
									$Result->Set('Result', \Protocol\Result::ER_DBERROR);
								}
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
		$Result->Set('Result', \Protocol\Result::ER_BADDATA);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}

?>
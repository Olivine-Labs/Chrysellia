<?php
/**
 * Character movement logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'X') &&
	property_exists($Get, 'Y')
){
	if(
		($Get->X >= 0) &&
		($Get->Y >= 0)
	){
		try
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			if($Database->Characters->LoadPosition($Character))
			{
				$DiffX = abs($Character->PositionX - $Get->X);
				$DiffY = abs($Character->PositionY - $Get->Y);
				if(
					($DiffX <= 1) &&
					($DiffY <= 1)
				){
					$Map = new \Entities\Map();
					$Map->MapId = $Character->MapId;
					if($Database->Maps->LoadMapById($Map))
					{
						if(
							($Get->X < $Map->DimensionX) &&
							($Get->Y < $Map->DimensionY)
						){
							$Cell = $Database->Maps->LoadCell($Map, $Get->X, $Get->Y);
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
								$Character->PositionX = $Get->X;
								$Character->PositionY = $Get->Y;
								if($Database->Character->UpdatePosition($Character))
								{
									$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
									$Result->Set('Data', Array('X'=>$Get->X, 'Y'=>$Get->Y));
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
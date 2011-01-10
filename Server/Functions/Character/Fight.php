<?php
/**
 * PvP Logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'MonsterId') &&
	property_exists($Get, 'FightType')
){
	if(($Get->FightType == 0) || ($Get->FightType == 1))
	{
		try
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			if($Database->Characters->LoadPosition($Character))
			{
				$EnemyCharacter = new \Entities\Character();
				$EnemyCharacter ->CharacterId = $Get->CharacterId;
				if($Database->Characters->LoadPosition($EnemyCharacter))
				{
					if(
						($Character->MapId == $EnemyCharacter->MapId) &&
						($Character->PositionX == $EnemyCharacter->PositionX) &&
						($Character->PositionY == $EnemyCharacter->PositionY)
					){
						if($Database->Characters->LoadTraits($Character))
						{
							if(($Character->Health > 0) && ($EnemyCharacter->Health > 0))
							{
								if($Database->Character->LoadTraits($EnemyCharacter))
								{
									$SameMonster = false;
									//$CurrentFight = null;
									//if(isset($_SESSION['CurrentFight']))
									//	$CurrentFight = $_SESSION['CurrentFight'];

									$Character->Equipment = $Database->Items->LoadEquippedItems($Character);
									$EnemyCharacter->Equipment = $Database->Items->LoadEquippedItems($EnemyCharacter);

									if($AttackResult = $Character->Attack($EnemyCharacter, $Get->FightType))
									{
										$Success = false;
										$Database->startTransaction();
										if($Database->Characters->UpdateTraits($Character) && $Database->Characters->UpdateTraits($EnemyCharacter))
										{
											$Database->Characters->LoadById($Character);
											$Message['AttackedBy'] = $Character->Name;
											$Message['BattleData'] = $AttackResult;
											if($Database->Chat->Insert($EnemyCharacter, 0, $Message, 255, $TargetCharacter))
											{
												$Success = true;
											}
										}
										if($Success)
										{
											$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
											$Result->Set('Data', $AttackResult);
											$_SESSION['NextAction'] = microtime(true) + 1.50;
											$Database->commitTransaction();
										}
										else
										{
											$Result->Set('Result', \Protocol\Result::ER_DBERROR);
											$Database->rollbackTransaction();
										}
									}
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
						$Result->Set('Result', \Protocol\Result::ER_BADDATA);
					}
				}
				else
				{
					$Result->Set('Result', \Protocol\Result::ER_BADDATA);
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
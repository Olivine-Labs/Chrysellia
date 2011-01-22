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
	property_exists($Get, 'CharacterId') &&
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
						if(
							$Database->Characters->LoadTraits($Character) &&
							$Database->Characters->LoadTraits($EnemyCharacter) &&
							is_array($Character->Masteries = $Database->Characters->LoadMasteries($Character)) &&
							is_array($EnemyCharacter->Masteries = $Database->Characters->LoadMasteries($EnemyCharacter))
						){
							if(($Character->Health > 0) && ($EnemyCharacter->Health > 0) && ($EnemyCharacter->Level >= $Character->Level*0.75))
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
										foreach($AttackResult['Masteries'] AS $MasteryId)
										{
											if(!$Database->Characters->UpdateMastery($Character, $MasteryId, $Character->Masteries[$MasteryId]['Value'], $Character->Masteries[$MasteryId]['Bonus']))
											{
												$Success = false;
												break;
											}
										}

										if($Success)
										{
											$Database->Characters->LoadById($Character);
											$Message['AttackedBy'] = $Character->Name;
											$Message['BattleData'] = $AttackResult;
											$Message['MessageType'] = 1;
											if($Database->Chat->Insert($Character, 'CHAN_00000000000000000000001', $Message, 255, $EnemyCharacter))
											{
												$Success = true;
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

									if($Success)
									{
										$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
										$Response->Set('Data', $AttackResult);
										$_SESSION['NextAction'] = microtime(true) + 1.50;
										$Database->commitTransaction();
									}
									else
									{
										$Database->rollbackTransaction();
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
						$Response->Set('Result', \Protocol\Response::ER_BADDATA);
					}
				}
				else
				{
					$Response->Set('Result', \Protocol\Response::ER_BADDATA);
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
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}

?>
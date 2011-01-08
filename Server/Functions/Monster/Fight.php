<?php
/**
 * PvE Logic
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
				$Monster = new \Entities\Monster();
				$Monster->MonsterId = $Get->MonsterId;
				$Monster->MapId = $Character->MapId;
				$Monster->PositionX = $Character->PositionX;
				$Monster->PositionY = $Character->PositionY;
				if($Database->Monsters->IsInCell($Monster))
				{
					if($Database->Characters->LoadTraits($Character))
					{
						if($Character->Health > 0)
						{
							if($Database->Monsters->LoadById($Monster))
							{
								$SameMonster = false;
								$CurrentFight = null;
								if(isset($_SESSION['CurrentFight']))
									$CurrentFight = $_SESSION['CurrentFight'];
								if(is_array($CurrentFight))
								{
									if(isset($CurrentFight['MonsterId']))
									{
										if(
											($Monster->MonsterId == $CurrentFight['MonsterId']) &&
											($CurrentFight['MapId'] == $Character->MapId) &&
											($CurrentFight['PositionX'] == $Character->PositionX) &&
											($CurrentFight['PositionY'] == $Character->PositionY)
										){
											$SameMonster = true;
										}
									}
								}

								if($SameMonster)
								{
									$Monster->Health = $CurrentFight['Health'];
									$Monster->Strength = $CurrentFight['Strength'];
									$Monster->Dexterity = $CurrentFight['Dexterity'];
									$Monster->Intelligence = $CurrentFight['Intelligence'];
									$Monster->Wisdom = $CurrentFight['Wisdom'];
									$Monster->GoldGiven = $CurrentFight['GoldGiven'];
									$Monster->ExperienceGiven = $CurrentFight['ExperienceGiven'];
								}
								else
								{
									$Monster->GenerateStats();
								}
								$Character->Equipment = $Database->Items->LoadEquippedItems($Character);
								if($AttackResult = $Character->Attack($Monster, $Get->FightType))
								{
									$CurrentFight = Array();
									$CurrentFight['MonsterId'] = $Monster->MonsterId;
									$CurrentFight['Health'] = $Monster->Health;
									$CurrentFight['Strength'] = $Monster->Strength;
									$CurrentFight['Dexterity'] = $Monster->Dexterity;
									$CurrentFight['Intelligence'] = $Monster->Intelligence;
									$CurrentFight['Wisdom'] = $Monster->Wisdom;
									$CurrentFight['GoldGiven'] = $Monster->GoldGiven;
									$CurrentFight['ExperienceGiven'] = $Monster->ExperienceGiven;
									$CurrentFight['MapId'] = $Character->MapId;
									$CurrentFight['PositionX'] = $Character->PositionX;
									$CurrentFight['PositionY'] = $Character->PositionY;
	
									$_SESSION['CurrentFight'] = $CurrentFight;
	
									$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
									$Result->Set('Data', $AttackResult);
									$_SESSION['NextAction'] = microtime(true) + 1.50;
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
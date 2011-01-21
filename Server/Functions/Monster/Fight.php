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
									$Monster->Vitality = $CurrentFight['Vitality'];
									$Monster->Strength = $CurrentFight['Strength'];
									$Monster->Dexterity = $CurrentFight['Dexterity'];
									$Monster->Intelligence = $CurrentFight['Intelligence'];
									$Monster->Wisdom = $CurrentFight['Wisdom'];
									$Monster->GoldGiven = $CurrentFight['GoldGiven'];
									$Monster->EXPGiven = $CurrentFight['EXPGiven'];
									$Monster->Special = $CurrentFight['Special'];
									$Monster->DropBonus = $CurrentFight['DropBonus'];
									$Monster->MasteryBonus = $CurrentFight['MasteryBonus'];
									$Monster->WeaponClass = $CurrentFight['WeaponClass'];
									$Monster->SpellClass = $CurrentFight['SpellClass'];
									$Monster->Armor = $CurrentFight['ArmorClass'];
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
									$CurrentFight['Vitality'] = $Monster->Vitality;
									$CurrentFight['Strength'] = $Monster->Strength;
									$CurrentFight['Dexterity'] = $Monster->Dexterity;
									$CurrentFight['Intelligence'] = $Monster->Intelligence;
									$CurrentFight['Wisdom'] = $Monster->Wisdom;
									$CurrentFight['GoldGiven'] = $Monster->GoldGiven;
									$CurrentFight['EXPGiven'] = $Monster->EXPGiven;
									$CurrentFight['MapId'] = $Character->MapId;
									$CurrentFight['PositionX'] = $Character->PositionX;
									$CurrentFight['PositionY'] = $Character->PositionY;
									$CurrentFight['Special'] = $Monster->Special;
									$CurrentFight['DropBonus']=$Monster->DropBonus;
									$CurrentFight['MasteryBonus']=$Monster->MasteryBonus;
									$CurrentFight['WeaponClass'] = $Monster->WeaponClass;
									$CurrentFight['SpellClass'] = $Monster->SpellClass;
									$CurrentFight['ArmorClass'] = $Monster->ArmorClass;
	
									if($Database->Characters->UpdateTraits($Character))
									{
										if(!isset($AttackResult['Winner']))
											$_SESSION['CurrentFight'] = $CurrentFight;
										$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
										$Response->Set('Data', $AttackResult);
										$_SESSION['NextAction'] = microtime(true) + 1.50;
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
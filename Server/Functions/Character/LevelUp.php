<?php
/**
 * try to spend a freelevel
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	if(
		property_exists($Get, 'Stat')
	){
		if(($Get->Stat >= 0) && ($Get->Stat < 5))
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			if($Database->Characters->LoadTraits($Character) && $Database->Characters->LoadRaceTraits($Character))
			{
				if($Character->FreeLevels > 0)
				{
					switch($Get->Stat)
					{
						case 0:
							$Character->Strength += 10;
							$Character->Dexterity += 10;
							$Character->Vitality += 10;
							$Character->Intelligence += 10;
							$Character->Wisdom += 10;
							break;
						case 1:
							$Character->Strength += 50;
							break;
						case 2:
							$Character->Dexterity += 50;
							break;
						case 3:
							$Character->Vitality += 50;
							break;
						case 4:
							$Character->Intelligence += 50;
							break;
						case 5:
							$Character->Wisdom += 50;
							break;
					}

					$Character->Strength += $Character->RacialStrength;
					$Character->Dexterity += $Character->RacialDexterity;
					$Character->Vitality += $Character->RacialVitality;
					$Character->Intelligence += $Character->RacialIntelligence;
					$Character->Wisdom += $Character->RacialWisdom;
					$Character->Health = $Character->Vitality;
					$Character->FreeLevels -= 1;
					$Character->Level++;
					if($Database->Characters->UpdateTraits($Character))
					{
						$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
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
		$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
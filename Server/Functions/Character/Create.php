<?php
/**
 * This file contains the Character creation logic
 */

define('CHANNEL_GENERAL', 'CHAN_00000000000000000000001');
define('CHANNEL_TRADE', 'CHAN_00000000000000000000002');

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Gender') &&
	property_exists($Get, 'Pin') &&
	property_exists($Get, 'Name') &&
	property_exists($Get, 'RaceId') &&
	property_exists($Get, 'Strength') &&
	property_exists($Get, 'Dexterity') &&
	property_exists($Get, 'Intelligence') &&
	property_exists($Get, 'Wisdom') &&
	property_exists($Get, 'Vitality')
){
	$ACharacter = new \Entities\Character();
	$ACharacter->AccountId = $_SESSION['AccountId'];
	$ACharacter->Gender = $Get->Gender;
	$ACharacter->Pin = $Get->Pin;
	$ACharacter->Name = $Get->Name;
	$ACharacter->RaceId = $Get->RaceId;
	$ACharacter->RacialStrength = $Get->Strength;
	$ACharacter->RacialDexterity = $Get->Dexterity;
	$ACharacter->RacialIntelligence = $Get->Intelligence;
	$ACharacter->RacialWisdom = $Get->Wisdom;
	$ACharacter->RacialVitality = $Get->Vitality;

	$ARace = new \Entities\Race();
	$ARace->RaceId = $ACharacter->RaceId;
	
	if($Database->Races->LoadById($ARace))
	{
		if($ACharacter->Verify($ARace))
		{
			$ACharacter->MapId = $ARace->HomeMapId;
			$ACharacter->PositionX = $ARace->HomePositionX;
			$ACharacter->PositionY = $ARace->HomePositionY;
			$ACharacter->Strength = $ARace->Strength + $ACharacter->RacialStrength;
			$ACharacter->Dexterity = $ARace->Dexterity + $ACharacter->RacialDexterity;
			$ACharacter->Intelligence = $ARace->Intelligence + $ACharacter->RacialIntelligence;
			$ACharacter->Wisdom = $ARace->Wisdom + $ACharacter->RacialWisdom;
			$ACharacter->Vitality = $ARace->Vitality + $ACharacter->RacialVitality;
			$ACharacter->Health = $ACharacter->Vitality;

			try
			{
				//$Database->startTransaction();
				$Success = false;
				if($Database->Characters->Insert($ACharacter))
				{
					if($Database->Characters->InsertTraits($ACharacter))
					{
						if($Database->Characters->InsertRaceTraits($ACharacter))
						{
							if($Database->Characters->InsertPosition($ACharacter))
							{
								if($Database->Chat->SetRights($ACharacter, CHANNEL_GENERAL, Array('Read'=>1, 'Write'=>1, 'Moderate'=>0, 'Administrate'=>0, 'isJoined' =>1)))
								{
									if($Database->Chat->SetRights($ACharacter, CHANNEL_TRADE, Array('Read'=>1, 'Write'=>1, 'Moderate'=>0, 'Administrate'=>0, 'isJoined' =>1)))
									{
										$Success = true;
									}
								}
							}
						}
					}

					if(!$Success)
					{
						$Result->Set('Result', \Protocol\Result::ER_DBERROR);
					}
				}else
				{
					$Result->Set('Result', \Protocol\Result::ER_ALREADYEXISTS);
				}

				if($Success)
				{
					$Database->commitTransaction();
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				}
				else
				{
					$Database->rollbackTransaction();
				}
			}
			catch(Exception $e)
			{
				$Result->Set('Result', \Protocol\Result::ER_DBERROR);
				$Database->rollbackTransaction();
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
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}

?>
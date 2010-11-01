<?php
/**
 * This file contains the Character creation logic
 */

define('CHANNEL_GENERAL', 'CHAN_00000000000000000000001');
define('CHANNEL_TRADE', 'CHAN_00000000000000000000002');

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post, 'Gender') &&
	property_exists($Post, 'Pin') &&
	property_exists($Post, 'Name') &&
	property_exists($Post, 'RaceId') &&
	property_exists($Post, 'Strength') &&
	property_exists($Post, 'Dexterity') &&
	property_exists($Post, 'Intelligence') &&
	property_exists($Post, 'Wisdom') &&
	property_exists($Post, 'Vitality')
){
	$ACharacter = new \Entities\Character();
	$ACharacter->AccountId = $_SESSION['AccountId'];
	$ACharacter->Gender = $Post->Gender;
	$ACharacter->Pin = $Post->Pin;
	$ACharacter->Name = $Post->Name;
	$ACharacter->RaceId = $Post->RaceId;
	$ACharacter->RacialStrength = $Post->Strength;
	$ACharacter->RacialDexterity = $Post->Dexterity;
	$ACharacter->RacialIntelligence = $Post->Intelligence;
	$ACharacter->RacialWisdom = $Post->Wisdom;
	$ACharacter->RacialVitality = $Post->Vitality;

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
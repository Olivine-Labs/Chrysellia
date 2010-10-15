<?php
/**
 * This file contains the Character creation logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post, 'FirstName') &&
	property_exists($Post, 'MiddleName') &&
	property_exists($Post, 'LastName') &&
	property_exists($Post, 'RaceId') &&
	property_exists($Post, 'Strength') &&
	property_exists($Post, 'Dexterity') &&
	property_exists($Post, 'Intelligence') &&
	property_exists($Post, 'Wisdom') &&
	property_exists($Post, 'Vitality')
){
	$ACharacter = new \Entities\Character();
	$ACharacter->AccountId = $_SESSION['AccountId'];
	$ACharacter->FirstName = $Post->FirstName;
	$ACharacter->MiddleName = $Post->MiddleName;
	$ACharacter->LastName = $Post->LastName;
	$ACharacter->RaceId = $Post->RaceId;
	$ACharacter->RacialStrength = $Post->Strength;
	$ACharacter->RacialDexterity = $Post->Dexterity;
	$ACharacter->RacialIntelligence = $Post->Intelligence;
	$ACharacter->RacialWisdom = $Post->Wisdom;
	$ACharacter->RacialVitality = $Post->Vitality;

	if($ACharacter->Verify())
	{
		try
		{
			//TODO Racial verification
			$Database->startTransaction();
			$Success = false;
			if($Database->Characters->Insert($ACharacter))
			{
				if($Database->Characters->InsertTraits($ACharacter))
					if($Database->Characters->InsertRaceTraits($ACharacter))
						if($Database->Characters->InsertPosition($ACharacter))
							$Success = true;
				if(!$Success)
					$Result->Set('Result', \Protocol\Result::ER_DBERROR);
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
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}

?>
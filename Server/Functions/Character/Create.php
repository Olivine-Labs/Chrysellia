<?php
/**
 * This file contains the Character creation logic
 */

if(
	property_exists($Post->Data, 'FirstName') &&
	property_exists($Post->Data, 'MiddleName') &&
	property_exists($Post->Data, 'LastName') &&
	property_exists($Post->Data, 'RaceId') &&
	property_exists($Post->Data, 'Strength') &&
	property_exists($Post->Data, 'Dexterity') &&
	property_exists($Post->Data, 'Intelligence') &&
	property_exists($Post->Data, 'Wisdom') &&
	property_exists($Post->Data, 'Vitality')
){
	$ACharacter = new \Entities\Character();
	$ACharacter->AccountId = $_SESSION['AccountId'];
	$ACharacter->FirstName = $Post->Data->FirstName;
	$ACharacter->MiddleName = $Post->Data->MiddleName;
	$ACharacter->LastName = $Post->Data->LastName;
	$ACharacter->RaceId = $Post->Data->RaceId;
	$ACharacter->RacialStrength = $Post->Data->Strength;
	$ACharacter->RacialDexterity = $Post->Data->Dexterity;
	$ACharacter->RacialIntelligence = $Post->Data->Intelligence;
	$ACharacter->RacialWisdom = $Post->Data->Wisdom;
	$ACharacter->RacialVitality = $Post->Data->Vitality;

	if($ACharacter->Verify())
	{
		try
		{
			InitializeDatabase($Database);
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
					$Result->Set('Result', \Protocol\ER_DBERROR);
			}else
			{
				$Result->Set('Result', \Protocol\ER_ALREADYEXISTS);
			}

			if($Success)
			{
				$Database->commitTransaction();
				$Result->Set('Result', \Protocol\ER_SUCCESS);
			}
			else
			{
				$Database->rollbackTransaction();
			}
		}
		catch(Exception $e)
		{
			$Result->Set('Result', \Protocol\ER_DBERROR);
			$Database->rollbackTransaction();
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\ER_BADDATA);
	}
}
else
{
	$Result->Set('Result', \Protocol\ER_MALFORMED);
}

?>
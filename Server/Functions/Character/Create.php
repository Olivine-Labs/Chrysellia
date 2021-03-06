<?php
namespace Functions\Character;
/**
 * This file contains the Character creation logic
 */

const CHANNEL_GENERAL = 'CHAN_00000000000000000000001';
const CHANNEL_TRADE = 'CHAN_00000000000000000000002';
const STARTING_GOLD = '150';

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new \stdClass();
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
			$ACharacter->Gold = STARTING_GOLD;
			$ACharacter->AlignGood = $ARace->AlignGood;
			$ACharacter->AlignOrder = $ARace->AlignOrder;

			$Database->startTransaction();
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
									if($InventoryId = $Database->Items->InsertInventoryForCharacter($ACharacter))
									{
										if(
											is_array($DefaultItemsList = $Database->Items->LoadRaceDefaultItems($ARace)) &&
											is_array($DefaultMasteriesList = $Database->Races->LoadDefaultMasteries($ARace))
										){
											$Run = true;
											$Index = 0;
											while(($Run) && ($Index < count($DefaultItemsList)))
											{
												$AnItem = $DefaultItemsList[$Index];
												$AnItem->InventoryId = $InventoryId;
												if(!$Database->Items->Insert($AnItem))
												{
													$Run = false;
												}else
												{
													$Database->Items->EquipItem($ACharacter, $AnItem, 0);
												}
												$Index++;
											}
											$Index = 0;
											while(($Run) && ($Index < count($DefaultMasteriesList)))
											{
												$AMastery = $DefaultMasteriesList[$Index];
												if(!$Database->Characters->InsertMastery($ACharacter, $Index, $AMastery['Value']))
												{
													$Run = false;
												}
												$Index++;
											}
											if($Run)
												$Success = true;
										}
									}
								}
							}
						}
					}
				}
				if(!$Success)
				{
					$Response->Set('Result', \Protocol\Response::ER_DBERROR);
				}
			}else
			{
				$Response->Set('Result', \Protocol\Response::ER_ALREADYEXISTS);
			}

			if($Success)
			{
				$Database->commitTransaction();
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
			}
			else
			{
				$Database->rollbackTransaction();
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
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
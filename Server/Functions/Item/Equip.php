<?php
namespace Functions\Item;
/**
 * Equip item to character
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new stdClass();
}

if(
	property_exists($Get, 'ItemId') &&
	property_exists($Get, 'SlotNumber')
)
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadTraits($Character))
	{
		$Race = new \Entities\Race();
		$Race->RaceId = $Character->RaceId;
		if($Database->Races->LoadById($Race))
		{
			$Item = new \Entities\Item();
			$Item->ItemId = $Get->ItemId;
			if($Database->Items->CharacterOwnsItem($Character, $Item))
			{
				if($Database->Items->LoadById($Item))
				{
					$Slots = 0;
					switch($Item->SlotType)
					{
						case 0:
							$Slots = $Race->WeaponSlots;
							break;
						case 1:
							$Slots = $Race->ArmorSlots;
							break;
						case 2:
							$Slots = $Race->AccessorySlots;
							break;
						case 3:
							$Slots = $Race->SpellSlots;
							break;
					}
					if(($Get->SlotNumber + ($Item->Slots - 1) < $Slots) && ($Get->SlotNumber >= 0))
					{
						if(is_array($Character->Equipment = $Database->Items->LoadEquippedItems($Character)))
						{
							$SlotFree = true;
							$FreeBefore = true;
							$FreeAfter = true;
							for($Index = 0; $Index < count($Character->Equipment); $Index++)
							{
								$AnItem = $Character->Equipment[$Index];
								if($AnItem->SlotType == $Item->SlotType)
								{
									if($AnItem->SlotNumber != $Get->SlotNumber)
									{
										if(
											($AnItem->SlotNumber < $Get->SlotNumber) &&
											($AnItem->SlotNumber + ($AnItem->Slots-1) >= $Get->SlotNumber)
										){
											$FreeBefore = false;
										}
										else if(
											($Get->SlotNumber < $AnItem->SlotNumber) &&
											($Get->SlotNumber + ($Item->Slots - 1) >= $AnItem->SlotNumber)
										){
											$FreeAfter = false;
										}
									}
									else
									{
										$SlotFree = false;
										break;
									}
								}
							}
							if($SlotFree && $FreeBefore && $FreeAfter)
							{
								if($Database->Items->EquipItem($Character, $Item, $Get->SlotNumber))
								{
									$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
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
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
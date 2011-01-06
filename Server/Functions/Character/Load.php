<?php
/**
 * Load a character in it's entirety - called on first selecting a character
 */
try
{
	if(isset($_SESSION['CharacterId']))
	{
		$ACharacter = new \Entities\Character();
		$ACharacter->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadById($ACharacter))
		{
			if($Database->Characters->LoadTraits($ACharacter))
			{
				if($Database->Characters->LoadPosition($ACharacter))
				{
					if($Character->Equipment = $Database->Items->LoadEquippedItems($ACharacter))
					{
						$Race = $Database->Races->LoadById($ACharacter->RaceId);
						$EquipmentArray = Array();
						for($TypeIndex=0; $TypeIndex < 4; $TypeIndex++)
						{
							$Slots = 0;
							switch($TypeIndex)
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
							for($Index = 0; $Index < $Slots; $Index++)
							{
								$EquipmentArray[$TypeIndex][$Index]=new \Entities\Item();
							}
						}
						foreach($Character->Equipment AS $AnItem)
						{
							$EquipmentArray[$AnItem->SlotType][$AnItem->SlotNumber] = $AnItem;
						}
						$Character->Equipment = $EquipmentArray;
						
						if($ACharacter->Pin > 0)
							$ACharacter->HasPin = true;
						else
							$ACharacter->HasPin = false;
						$ACharacter->Pin = null;
						$ACharacter->Channels = $Database->Chat->LoadJoinedChannels($ACharacter);
						foreach($ACharacter->Channels AS $ChannelId=>&$AChannel)
						{
							$AChannel['Permissions'] = $Database->Chat->GetRights($ACharacter, $ChannelId);
						}
						$Result->Set('Data', $ACharacter);
						$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					}
					else
					{
						$Result->Set('Result', \Protocol\Result::ER_DBERROR);
					}
				}
				else
				{
					$Result->Set('Result', \Protocol\Result::ER_DBERROR);
				}
			}
			else
			{
				$Result->Set('Result', \Protocol\Result::ER_DBERROR);
			}
		}
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
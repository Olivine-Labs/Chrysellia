<?php
/**
 * Equip item to character
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	if(
		property_exists($Get, 'ItemId') &&
		property_exists($Get, 'SlotNumber')
	)
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadById($Character))
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
						switch($Item->Type)
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
						if($Get->SlotNumber > $Slots)
						{
							if($Character->Equipment = $Database->Items->LoadEquippedItems($Character))
							{
								$CanEquip = false;
								for($Index = 0; $Index < count($Character->Equipment); $Index++)
								{
									$AnItem = $Character->Equipment[$Index];
									//if($AnItem
								}
								if($CanEquip)
								{
									
								}
								else
								{
									
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
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_DBERROR);
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
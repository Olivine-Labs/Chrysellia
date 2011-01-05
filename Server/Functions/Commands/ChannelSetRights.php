<?php
/**
 * Join Channel
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Character') &&
	property_exists($Get, 'Channel') &&
	property_exists($Get, 'Rights')
){
	try
	{
		
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		$Database->Characters->LoadById($Character);

		$TargetCharacter = new \Entities\Character();
		$TargetCharacter->Name = $Get->Character;

		if($Rights = $Database->Chat->GetRights($Character, $Get->Channel))
		{
			if($Rights['Administrate'] || $Rights['Moderate'])
			{
				if($Database->Characters->CheckName($TargetCharacter))
				{
					$TargetCharacterRights = $Database->Chat->GetRights($TargetCharacter, $Get->Channel);

					define('RIGHT_READ', 0);
					define('RIGHT_WRITE', 1);
					define('RIGHT_MODERATE', 2);
					define('RIGHT_ADMINISTRATE', 3);

					$TargetRights = $Get->Rights;
					$CanModify = true;
					if(!($TargetCharacter['Administrate'] && !$Rights['Administrate']))
					{
						if(property_exists($TargetRights, 'Read'))
						{
							$TargetCharacterRights['Read'] = (bool)$TargetRights->Read;
						}

						if(property_exists($TargetRights, 'Write'))
						{
							$TargetCharacterRights['Write'] = (bool)$TargetRights->Write;
						}

						if($Rights['Administrate'])
						{
							if(property_exists($TargetRights, 'Moderate'))
							{
								$TargetCharacterRights['Moderate'] = (bool)$TargetRights->Moderate;
							}

							if(property_exists($TargetRights, 'Administrate'))
							{
								$TargetCharacterRights['Administrate'] = (bool)$TargetRights->Administrate;
							}
						}
					}else
					{
						$CanModify = false;
					}
					if($CanModify)
					{
						$Success = false;
						$Database->startTransaction();
						if($Database->Chat->SetRights($TargetCharacter, $Get->Channel, $TargetCharacterRights))
						{
							$TargetCharacterRights['ChannelId'] = $Get->Channel;
							if($Database->Chat->Insert($Character, $Get->Channel, $TargetCharacterRights, 255, $TargetCharacter))
							{
								$Success = true;
							}
						}

						if($Success)
						{
							$Database->commitTransaction();
							$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
						}
						else
						{
							$Database->rollbackTransaction();
							$Result->Set('Result', \Protocol\Result::ER_DBERROR);
						}
					}
				}
				else
				{
					$Result->Set('Result', \Protocol\Result::ER_BADDATA);
				}
			}
		}
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>
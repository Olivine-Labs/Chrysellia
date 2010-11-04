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

		$TargetCharacter = new \Entities\Character();
		$TargetCharacter->Name = $Get->Character;

		if($Rights = $Database->Chat->GetRights($Character, $Get->Channel))
		{
			if($Rights['Administrate'])
			{
				if($Database->Characters->CheckName($TargetCharacter))
				{
					$TargetCharacterRights = $Database->Chat->GetRights($TargetCharacter, $Get->Channel);
					
					define('RIGHT_READ', 0);
					define('RIGHT_WRITE', 1);
					define('RIGHT_MODERATE', 2);
					define('RIGHT_ADMINISTRATE', 3);
					
					$Success = true;
					$TargetRights = $Get->Rights;
					
					if(property_exists($TargetRights, 'Read')){
						$TargetCharacterRights['Read'] = (bool)$TargetRights->Read;
					}
					
					if(property_exists($TargetRights, 'Write')){
						$TargetCharacterRights['Write'] = (bool)$TargetRights->Write;
					}
					
					if(property_exists($TargetRights, 'Moderate')){
						$TargetCharacterRights['Moderate'] = (bool)$TargetRights->Moderate;
					}
					
					if(property_exists($TargetRights, 'Administrate')){
						$TargetCharacterRights['Administrate'] = (bool)$TargetRights->Administrate;
					}
					
					if(property_exists($TargetRights, 'isJoined')){
						$TargetCharacterRights['isJoined'] = (bool)$TargetRights->isJoined;
					}
					
					if($Success)
					{
						if($Database->Chat->SetRights($TargetCharacter, $Get->Channel, $TargetCharacterRights))
						{
							$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
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
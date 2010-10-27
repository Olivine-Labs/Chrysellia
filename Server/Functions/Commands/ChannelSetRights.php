<?php
/**
 * Join Channel
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post, 'Character') &&
	property_exists($Post, 'Channel') &&
	property_exists($Post, 'RightType') &&
	property_exists($Post, 'Right')
){
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];

		$TargetCharacter = new \Entities\Character();
		$TargetCharacter->Name = $Post->Character;
		if($Rights = $Database->Chat->GetRights($Character, $Post->Channel))
		{
			if($Rights['Administrate'])
			{
				if($Database->Characters->CheckName($TargetCharacter))
				{
					$TargetCharacterRights = $Database->Chat->GetRights($TargetCharacter, $Post->Channel);
					define('RIGHT_READ', 0);
					define('RIGHT_WRITE', 1);
					define('RIGHT_MODERATE', 2);
					define('RIGHT_ADMINISTRATE', 3);
					$Success = true;
					switch($Post->RightType)
					{
						case RIGHT_READ:
							$TargetCharacterRights['Read'] = (bool)$Post->Right;
							break;
						case RIGHT_WRITE:
							$TargetCharacterRights['Write'] = (bool)$Post->Right;
							break;
						case RIGHT_MODERATE:
							$TargetCharacterRights['Moderate'] = (bool)$Post->Right;
							break;
						case RIGHT_ADMINISTRATE:
							$TargetCharacterRights['Administrate'] = (bool)$Post->Right;
							break;
						default:
							$Success = false;
							break;
					}

					if($Success)
					{
						if($Database->Chat->SetRights($TargetCharacter, $Post->Channel, $TargetCharacterRights))
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
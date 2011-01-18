<?php
/**
 * /id implementation
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Character')
){
	try
	{
		
		if(isset($_SESSION['CharacterId']))
		{

			$TargetCharacter = new \Entities\Character();
			$TargetCharacter->Name = $Get->Character;
			if($Database->Characters->CheckName($TargetCharacter))
			{
				if($Database->Characters->LoadById($TargetCharacter))
				{
					if($Database->Characters->LoadTraits($TargetCharacter))
					{
						$IdArray = array(
							'AlignGood'	=>	$TargetCharacter->AlignGood,
							'AlignOrder'=>	$TargetCharacter->AlignOrder,
							'RaceId'	=>	$TargetCharacter->RaceId,
							'Level'	=>	$TargetCharacter->Level,
							'ClanId'	=>	$TargetCharacter->ClanId
						);
						$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
						$Result->Set('Data', $IdArray);
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
				$Result->Set('Result', \Protocol\Result::ER_BADDATA);
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
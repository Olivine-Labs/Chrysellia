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
						$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
						$Response->Set('Data', $IdArray);
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
				$Response->Set('Result', \Protocol\Response::ER_BADDATA);
			}
		}
	}
	catch(Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		$Response->Set('Error', $e->getMessage());
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
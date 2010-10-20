<?php
/**
 * Character select logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(property_exists($Post, 'Character'))
{
	try
	{
		$ACharacter = new \Entities\Character();
		$ACharacter->CharacterId = $Post->Character;
		if($Database->Characters->LoadById($ACharacter))
		{
			if($ACharacter->AccountId == $_SESSION['AccountId'])
			{
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				$_SESSION['CharacterId'] = $ACharacter->CharacterId;
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_BADDATA);
		}
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_BADDATA);
}

?>
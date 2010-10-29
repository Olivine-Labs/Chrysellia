<?php
/**
 * Character select logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post, 'Character') &&
	property_exists($Post, 'Pin')
){
	try
	{
		$ACharacter = new \Entities\Character();
		$ACharacter->CharacterId = $Post->Character;
		if($Database->Characters->LoadById($ACharacter))
		{
			if(
				($ACharacter->AccountId == $_SESSION['AccountId']) &&
				(($ACharacter->Pin == $Post->Pin) || ($ACharacter->Pin == 0))
			){
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				$_SESSION['CharacterId'] = $ACharacter->CharacterId;
				$_SESSION['NextAction'] = time() + 1;
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
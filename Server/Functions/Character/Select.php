<?php
/**
 * Character select logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Character') &&
	property_exists($Get, 'Pin')
){
	try
	{
		$ACharacter = new \Entities\Character();
		$ACharacter->CharacterId = $Get->Character;
		if($Database->Characters->LoadById($ACharacter))
		{
			if(
				($ACharacter->AccountId == $_SESSION['AccountId']) &&
				(($ACharacter->Pin == $Get->Pin) || ($ACharacter->Pin == 0))
			){
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
				$_SESSION['CharacterId'] = $ACharacter->CharacterId;
				$_SESSION['NextAction'] = time() + 1;
			}
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_BADDATA);
		}
	}
	catch(Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_BADDATA);
}

?>
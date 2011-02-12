<?php
namespace Functions\Character;
/**
 * Character select logic
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new \stdClass();
}

if(
	property_exists($Get, 'Character') &&
	property_exists($Get, 'Pin')
){
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
else
{
	$Response->Set('Result', \Protocol\Response::ER_BADDATA);
}

?>
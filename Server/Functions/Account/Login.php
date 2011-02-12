<?php
namespace Functions\Account;
/**
 * This file contains the Login function logic for Accounts
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new stdClass();
}

if(
	property_exists($Get, 'UserName') &&
	property_exists($Get, 'Password')
){
	$AnAccount = new \Entities\Account();
	$AnAccount->Fill($Get);

	if($AnAccount->Verify())
	{
		if($Database->Accounts->Login($AnAccount))
		{
			$Database->Accounts->Kick($AnAccount);
			$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
			$_SESSION['AccountId'] = $AnAccount->AccountId;
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
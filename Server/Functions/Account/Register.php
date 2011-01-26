<?php
/**
 * This file contains the Register function logic for Accounts
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
	property_exists($Get, 'Password') &&
	property_exists($Get, 'Email')
){
	$AnAccount = new \Entities\Account();
	$AnAccount->Fill($Get);

	if($AnAccount->Verify())
	{
		if($Database->Accounts->Insert($AnAccount))
		{
			$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_ALREADYEXISTS);
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
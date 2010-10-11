<?php
/**
 * This file contains the Register function logic for Accounts
 */

if(
	property_exists($Post->Data, 'UserName') &&
	property_exists($Post->Data, 'Password') &&
	property_exists($Post->Data, 'Email')
){
	$AnAccount = new \Entities\Account();
	$AnAccount->Name = $Post->Data->UserName;
	$AnAccount->Password = $Post->Data->Password;
	$AnAccount->Email = $Post->Data->Email;
	//TODO
	if($AnAccount->Verify())
	{
		try
		{
			InitializeDatabase($Database);
			if($Database->Accounts->Insert($Account))
			{
				$Result->Set('Result', ER_SUCCESS);
			}
			else
			{
				$Result->Set('Result', ER_ALREADYEXISTS);
			}
		}
		catch(Exception $e)
		{
			$Result->Set('Result', ER_DBERROR);
		}
	}
	else
	{
		$Result->Set('Result', ER_BADDATA);
	}
}
else
{
	$Result->Set('Result', ER_MALFORMED);
}

?>
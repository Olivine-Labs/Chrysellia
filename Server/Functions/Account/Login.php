<?php
/**
 * This file contains the Login function logic for Accounts
 */

if(
	property_exists($Post->Data, 'UserName') &&
	property_exists($Post->Data, 'Password')
){
	$AnAccount = new \Entities\Account();
	$AnAccount->Name = $Post->Data->UserName;
	$AnAccount->Password = $Post->Data->Password;
	if($AnAccount->Verify())
	{
		try
		{
			InitializeDatabase($Database);
			if($Database->Accounts->Login($AnAccount))
			{
				$Result->Set('Result', \Protocol\ER_SUCCESS);
				$_SESSION['AccountId'] = $AnAccount->Id;
			}
		}
		catch(Exception $e)
		{
			$Result->Set('Result', \Protocol\ER_DBERROR);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\ER_BADDATA);
	}
}
else
{
	$Result->Set('Result', \Protocol\ER_MALFORMED);
}
?>
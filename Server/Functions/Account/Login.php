<?php
/**
 * This file contains the Login function logic for Accounts
 */

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
		}
	}
	catch(Exception $e)
	{
		$Result->Set('Result', ER_DBERROR);
	}
}

?>
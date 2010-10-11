<?php
/**
 * This file contains the Register function logic for Accounts
 */

$AnAccount = new \Entities\Account();
$AnAccount->Name = $Post->Data->UserName;
$AnAccount->Password = $Post->Data->Password;
//TODO
if($AnAccount->Verify())
{
	try
	{
		InitializeDatabase($Database);
		//TODO
	}
	catch(Exception $e)
	{
		$Result->Set('Result', ER_DBERROR);
	}
}

?>
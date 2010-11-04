<?php
/**
 * This file contains the Login function logic for Accounts
 */
$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'UserName') &&
	property_exists($Get, 'Password')
){
	$AnAccount = new \Entities\Account();
	$AnAccount->Fill($Get);
	if($AnAccount->Verify())
	{
		try
		{
			if($Database->Accounts->Login($AnAccount))
			{
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				$_SESSION['AccountId'] = $AnAccount->AccountId;
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
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>
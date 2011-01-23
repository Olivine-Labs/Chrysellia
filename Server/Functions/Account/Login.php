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
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
				$_SESSION['AccountId'] = $AnAccount->AccountId;
			}
		}
		catch(Exception $e)
		{
			$Response->Set('Result', \Protocol\Response::ER_DBERROR);
			$Response->Set('Error', $e->getMessage());
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
<?php
/**
 * This file contains the Login function logic for Accounts
 */
$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post->Data, 'UserName') &&
	property_exists($Post->Data, 'Password')
){
	$AnAccount = new \Entities\Account();
	$AnAccount->Fill($Post);
	if($AnAccount->Verify())
	{
		try
		{
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
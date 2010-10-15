<?php
/**
 * This file contains the Register function logic for Accounts
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post, 'UserName') &&
	property_exists($Post, 'Password') &&
	property_exists($Post, 'Email')
){
	$AnAccount = new \Entities\Account();
	$AnAccount->Fill($Post);

	if($AnAccount->Verify())
	{
		try
		{
			if($Database->Accounts->Insert($Account))
			{
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
			}
			else
			{
				$Result->Set('Result', \Protocol\Result::ER_ALREADYEXISTS);
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
<?php
/**
 * This file contains the Register function logic for Accounts
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
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
		try
		{
			if($Database->Accounts->Insert($AnAccount))
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
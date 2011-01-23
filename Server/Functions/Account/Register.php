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
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
			}
			else
			{
				$Response->Set('Result', \Protocol\Response::ER_ALREADYEXISTS);
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
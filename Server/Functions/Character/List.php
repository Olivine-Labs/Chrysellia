<?php
/**
 * Character list logic
 */
try
{
	$AnAccount = new \Entities\Account();
	$AnAccount->AccountId = $_SESSION['AccountId'];
	$Response->Set('Data', $Database->Characters->LoadListByAccountId($AnAccount));
	$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
}
catch(Exception $e)
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	$Response->Set('Error', $e->getMessage());
}

?>
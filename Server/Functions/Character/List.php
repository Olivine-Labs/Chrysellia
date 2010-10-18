<?php
/**
 * Character list logic
 */
try
{
	$AnAccount = new \Entities\Account();
	$AnAccount->AccountId = $_SESSION['AccountId'];
	$Result->Set('Data', $Database->Characters->LoadListByAccountId($AnAccount));
	$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
<?php
/**
 * Character list logic
 */
try
{
	InitializeDatabase($Database);
	if(isset($_SESSION['AccountId']))
	{
		$AnAccount = new \Entities\Account();
		$AnAccount->Id = $_SESSION['AccountId'];
		$Result->Set('Data', $Database->Characters->LoadListByAccountId($AnAccount));
		$Result->Set('Result', \Protocol\ER_SUCCESS);
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\ER_DBERROR);
}

?>
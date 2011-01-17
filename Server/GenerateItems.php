<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Content-type: application/json');

require('./Common/Common.inc.php');
$Result = new \Protocol\Result();
$Database->Log = $Result;

try
{
	if(is_array($Inventory = $Database->Items->LoadAllItemTemplates()))
	{
		$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
		$Result->Set('Data', $Inventory);
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}
$Result->Output();
?>
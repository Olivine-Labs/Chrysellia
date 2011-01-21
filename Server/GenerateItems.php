<?php
include('./Common/Common.inc.php');

try
{
	if(is_array($Inventory = $Database->Items->LoadAllItemTemplates()))
	{
		$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
		$Result->Set('Data', $Inventory);
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
catch(Exception $e)
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
}
?>
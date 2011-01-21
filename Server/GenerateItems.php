<?php
include('./Common/Common.inc.php');

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
?>
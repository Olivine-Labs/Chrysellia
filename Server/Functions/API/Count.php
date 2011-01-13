<?php
/**
 * Character Count logic
 */

try
{
	$Result->Set('Data', Array('Count'=>$Database->Characters->GetTotalCount()));
	$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
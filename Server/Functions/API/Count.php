<?php
/**
 * Character Count logic
 */

try
{
	$Result->Set('Data', Array('Count'=>$Database->Characters->GetCount()));
	$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
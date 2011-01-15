<?php
/**
 * Online Count logic
 */

try
{
	$Result->Set('Data', Array('Count'=>$Database->Sessions->GetOnline()));
	$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
<?php
/**
 * Online Count logic
 */

try
{
	$Response->Set('Data', Array('Count'=>$Database->Sessions->GetOnline()));
	$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
}
catch(Exception $e)
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	$Response->Set('Error', $e->getMessage());
}

?>
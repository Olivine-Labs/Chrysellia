<?php
/**
 * Character Count logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(property_exists($Get, 'Race'))
{
	try
	{
		$Result->Set('Data', Array('Count'=>$Database->Characters->GetTotalCount($Get->Race)));
		$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}

?>
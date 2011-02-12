<?php
namespace Functions\API;
/**
 * Character Count logic
 */

$Get = null;
if(property_exists($Request->Data, 'Data'))
{
	$Get = $Request->Data->Data;
}
else
{
	$Get = new stdClass();
}

if(property_exists($Get, 'Race'))
{
	$Response->Set('Data', Array('Count'=>$Database->Characters->GetTotalCount($Get->Race)));
	$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
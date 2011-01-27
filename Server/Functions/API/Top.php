<?php
/**
 * Top list logic
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

if(
	property_exists($Get, 'Num') &&
	property_exists($Get, 'Position') &&
	property_exists($Get, 'Sort') &&
	property_exists($Get, 'ListType') &&
	property_exists($Get, 'Race')
){
	if($Get->Num <= 100)
	{
		$Response->Set('Data', $Database->Characters->LoadTopList($Get->Num, $Get->Position, $Get->Sort, $Get->ListType, $Get->Race));
		$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}

?>
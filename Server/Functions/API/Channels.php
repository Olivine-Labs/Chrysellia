<?php
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

if(
	(property_exists($Get, 'Num')) &&
	(property_exists($Get, 'Position'))
){
	$Response->Set('Data', $Database->Chat->LoadPublicChannelList($Get->Num, $Get->Position));
	$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}

?>
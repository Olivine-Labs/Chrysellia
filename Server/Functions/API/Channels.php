<?php
/**
 * Character Count logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
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
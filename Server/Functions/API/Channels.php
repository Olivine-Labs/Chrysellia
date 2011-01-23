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
	try
	{
		$Response->Set('Data', $Database->Chat->LoadPublicChannelList($Get->Num, $Get->Position));
		$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
	}
	catch(Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		$Response->Set('Error', $e->getMessage());
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}

?>
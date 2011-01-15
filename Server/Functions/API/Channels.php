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
		$Result->Set('Data', $Database->Chat->LoadPublicChannelList($Get->Num, $Get->Position));
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
<?php
/**
 * Top list logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
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
		try
		{
			$Result->Set('Data', $Database->Characters->LoadTopLevelList($Get->Num, $Get->Position, $Get->Sort, $Get->ListType, $Get->Race));
			$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
		}
		catch(Exception $e)
		{
			$Result->Set('Result', \Protocol\Result::ER_DBERROR);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_BADDATA);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}

?>
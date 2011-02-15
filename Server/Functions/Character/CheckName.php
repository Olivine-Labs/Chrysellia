<?php
namespace Functions\Character;
/**
 * Check to see if a name already exists
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new \stdClass();
}

if(
	property_exists($Get, 'Name')
){
	$Character = new \Entities\Character();
	$Character->Name = $Get->Name;
	$Race = new \Entities\Race();
	if($Character->Verify($Race))
	{
		if(!$Database->Characters->CheckName($Character))
			$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
		else
			$Response->Set('Result', \Protocol\Response::ER_ALREADYEXISTS);
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
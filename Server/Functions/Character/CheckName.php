<?php
/**
 * Check to see if a name already exists
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

try
{
	if(
		property_exists($Post, 'FirstName') &&
		property_exists($Post, 'MiddleName') &&
		property_exists($Post, 'LastName')
	){
		$Character = new \Entities\Character();
		$Character->FirstName = $Post->FirstName;
		$Character->MiddleName = $Post->MiddleName;
		$Character->LastName = $Post->LastName;
		if($Character->Verify())
		{
			if($Database->Characters->CheckName($Character))
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
			else
				$Result->Set('Result', \Protocol\Result::ER_ALREADYEXISTS);
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
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
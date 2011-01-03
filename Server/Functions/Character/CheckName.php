<?php
/**
 * Check to see if a name already exists
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	if(
		property_exists($Get, 'Name')
	){
		$Character = new \Entities\Character();
		$Character->Name = $Get->Name;
		$Race = new \Entities\Race();
		if($Character->Verify($Race))
		{
			if(!$Database->Characters->CheckName($Character))
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
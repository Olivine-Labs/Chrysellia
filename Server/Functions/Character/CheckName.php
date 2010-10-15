<?php
/**
 * Check to see if a name already exists
 */
try
{
	if(isset($_SESSION['AccountId']))
	{
		if(
			property_exists($Post->Data, 'FirstName') &&
			property_exists($Post->Data, 'MiddleName') &&
			property_exists($Post->Data, 'LastName') &&
		){
			if($Character->Verify())
			{
				InitializeDatabase($Database);
				$Character = new \Entities\Character();
				$Character->FirstName = $Post->Data->FirstName;
				$Character->MiddleName = $Post->Data->MiddleName;
				$Character->LastName = $Post->Data->LastName;

				if($Database->Characters->CheckName($Character))
					$Result->Set('Result', \Protocol\ER_SUCCESS);
				else
					$Result->Set('Result', \Protocol\ER_ALREADYEXISTS);
			}
			else
			{
				$Result->Set('Result', \Protocol\ER_BADDATA);
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\ER_MALFORMED);
		}
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\ER_DBERROR);
}

?>
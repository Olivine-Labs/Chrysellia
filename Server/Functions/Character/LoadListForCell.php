<?php
/**
 * Character list in cell logic
 */
try
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if($Database->Characters->LoadPosition($Character))
	{
		$Result->Set('Data', $Database->Characters->LoadListForCell($Character));
		$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
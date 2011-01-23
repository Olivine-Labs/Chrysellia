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
		$Response->Set('Data', $Database->Characters->LoadListForCell($Character));
		$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
catch(Exception $e)
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	$Response->Set('Error', $e->getMessage());
}

?>
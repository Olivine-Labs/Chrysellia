<?php
/**
 * Character Count logic
 */


	try
	{
		$Result->Set('Data', $Database->Chat->LoadPublicChannelCount());
		$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}


?>
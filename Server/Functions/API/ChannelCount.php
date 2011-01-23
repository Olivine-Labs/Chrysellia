<?php
/**
 * Character Count logic
 */


	try
	{
		$Response->Set('Data', $Database->Chat->LoadPublicChannelCount());
		$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
	}
	catch(Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		$Response->Set('Error', $e->getMessage());
	}


?>
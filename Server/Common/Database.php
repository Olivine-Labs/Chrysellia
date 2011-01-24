<?php
/**
 * This file contains common functions related to database access.
 */

/**
 * Creates a database based on configuration and puts it in the $Database parameter.
 *
 * @param $Database
 *   The variable to fill with a \Database\Database class object.
 */
function InitializeDatabase(&$Config, $Response)
{
	$Result = false;
	try
	{
		switch($Config[CF_DB_TYPE])
		{
			case DB_MYSQL:
				$Result = new \Database\MySQL\Database(
					$Config[CF_DB_HOST],
					$Config[CF_DB_PORT],
					$Config[CF_DB_USER],
					$Config[CF_DB_PASS],
					$Config[CF_DB_BASE]
				);
				break;
			default:
				throw(new \Exception('Config - Incorrect DB Type'));
				break;
		}
		if(!$Result)
			throw new \Exception('Failed to initialize database connection.');
	}
	catch(\Exception $e)
	{
		//If there was an error connecting to the database, send error and exit script gracefully
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		$Response->AddError($e->getMessage());
		exit(0);
	}
	return $Result;
}
?>
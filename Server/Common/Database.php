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
function InitializeDatabase($Database)
{
	$Result = false;
	switch($_CONFIG[CF_DATABASE][CF_DB_TYPE])
	{
		case DB_MYSQL:
			$Database = new \Database\MySQL\Database(
				$_CONFIG[CF_DATABASE][CF_DB_HOST],
				$_CONFIG[CF_DATABASE][CF_DB_PORT],
				$_CONFIG[CF_DATABASE][CF_DB_USER],
				$_CONFIG[CF_DATABASE][CF_DB_PASS],
				$_CONFIG[CF_DATABASE][CF_DB_BASE]
			);
			$Result = true;
			break;
		default:
			throw(new \Exception('Config - Incorrect DB Type'));
			break;
	}
	return $Result;
}
?>
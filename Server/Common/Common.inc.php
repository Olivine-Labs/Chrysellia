<?php
/**
 * This file includes the necessary common functions for all requests to use.
 *
 */

//Set up autoloading classes.
include('./Common/autoload.php');

//Setup error handling
$ErrorHandler = new \Common\ErrorHandler();

//Application specific includes.
include('./Common/Config.php');
include('./Common/Utilities.php');
include('./Common/Database.php');

//Bring the Configuration variable into the local namespace
global $_CONFIG;

//Create the response object, which handles all output from this script.
$Response= new \Protocol\Response($_CONFIG[CF_OUTPUT]);

//Attempt to initialize configured database connection.
$Database = InitializeDatabase($_CONFIG[CF_DATABASE], $Response);
$Database->Log = $Response;//Temporary until I can implement proper logging.

//Initialize session
$SessionHandler = new \Common\Session($Database);
$SessionHandler->Start();

//Create the Request object to decode, decompress, and handle incoming data
$Request = null;
try
{
	$Request = new \Protocol\Request($_GET['Data'], $_CONFIG[CF_INPUT]);
}
catch(\Exception $e)
{
	$Response->AddError($e->getMessage());
	$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	Exit(0);
}
?>
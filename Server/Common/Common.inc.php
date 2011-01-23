<?php
/**
 * This file includes the necessary common functions for all requests to use.
 *
 */

function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler('handleError');

include('./Common/Compatibility.php');
include('./Common/Config.php');
global $_CONFIG;
include('./Common/autoload.php');
include('./Common/Utilities.php');

include('./Common/Database.php');
$Database = null;
$Message = null;
try
{
	InitializeDatabase($Database, $_CONFIG, $Message);
}
catch(\Exception $e)
{
	$Message = $e->getMessage();
}

include('./Common/Session.php');
$SessionHandler = new Session($Database);
if(!isset($Message))
{
	$SessionHandler->Start();
}

$Response= new \Protocol\Response($_CONFIG[CF_OUTPUT][CF_OP_COMPRESSION]);
$Database->Log = $Response;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

if(isset($Message))
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	$Response->Set('Error', $Message);
	exit(0);
}
?>
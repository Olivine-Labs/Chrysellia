<?php
/**
 * This file includes the necessary common functions for all requests to use.
 *
 */
include('./Common/Compatibility.php');
include('./Common/Config.php');
global $_CONFIG;
include('./Common/autoload.php');
include('./Common/Utilities.php');

include('./Common/Database.php');
$Database = null;
InitializeDatabase($Database, $_CONFIG);

include('./Common/Session.php');
$SessionHandler = new Session($Database);
$SessionHandler->Start();

$Response= new \Protocol\Response($_CONFIG[CF_OUTPUT][CF_OP_COMPRESSION]);

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$Database->Log = $Response;
?>
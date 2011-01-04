<?php
/**
 * This file includes the necessary common functions for all requests to use.
 *
 */
include('./Common/Compatibility.php');
include('./Common/Config.php');
include('./Common/autoload.php');
include('./Common/Utilities.php');

include('./Common/Database.php');
$Database = null;
InitializeDatabase($Database);

include('./Common/Session.php');
$SessionHandler = new Session($Database);
$SessionHandler->Start();

?>
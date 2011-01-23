<?php
/**
 * Character Count logic
 */

$Response->Set('Data', $Database->Chat->LoadPublicChannelCount());
$Response->Set('Result', \Protocol\Response::ER_SUCCESS);


?>
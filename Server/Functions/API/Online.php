<?php
namespace Functions\API;
/**
 * Online Count logic
 */

$Response->Set('Data', Array('Count'=>$Database->Sessions->GetOnline()));
$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
?>
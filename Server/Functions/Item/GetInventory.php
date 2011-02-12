<?php
namespace Functions\Item;
/**
 * Get Inventory
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new stdClass();
}

$Character = new \Entities\Character();
$Character->CharacterId = $_SESSION['CharacterId'];
if(is_array($Inventory = $Database->Items->LoadInventory($Character)))
{
	$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
	$Response->Set('Data', $Inventory);
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
}
?>
<?php
/**
 * Get Inventory
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
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
}
catch(Exception $e)
{
	$Response->Set('Result', \Protocol\Response::ER_DBERROR);
}

?>
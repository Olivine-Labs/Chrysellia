<?php
/**
 * Emotion
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
	/*if($Inventory = $Database->Items->LoadInventory($Character))
	{

	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}*/
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
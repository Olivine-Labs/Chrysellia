<?php
/**
 * Personal Message Logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

try
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	$ChatArray = $Database->Chat->LoadListForCharacter($Character, $_SESSION[$Character->CharacterId]);
	{
		$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
		$Result->Set('Data', $ChatArray);
		$_SESSION[$Character->CharacterId] = time();
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
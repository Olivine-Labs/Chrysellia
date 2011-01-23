<?php
/**
 * Emotion
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Message') &&
	property_exists($Get, 'Channel')
){
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadById($Character))
		{
			if($Database->Chat->Insert($Character, $Get->Channel, $Get->Message, 1))
			{
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
			}else
			{
				$Response->Set('Result', \Protocol\Response::ER_BADDATA);
			}
		}else
		{
			$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		}
	}
	catch(Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		$Response->Set('Error', $e->getMessage());
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
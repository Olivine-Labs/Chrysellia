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
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
			}else
			{
				$Result->Set('Result', \Protocol\Result::ER_BADDATA);
			}
		}else
		{
			$Result->Set('Result', \Protocol\Result::ER_DBERROR);
		}
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>
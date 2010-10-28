<?php
/**
 * Emotion
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(
	property_exists($Post, 'Message') &&
	property_exists($Post, 'Channel')
){
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadById($Character))
		{
			if($ChannelId = $Database->Chat->Insert($Character, $Post->Channel, $Post->Message, 1))
			{
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				//$Result->Set('Data', Array('ChannelId'=>$ChannelId));
			}
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
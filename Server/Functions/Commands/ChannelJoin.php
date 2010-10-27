<?php
/**
 * Join Channel
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(property_exists($Post, 'Channel'))
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($ChannelId = $Database->Chat->JoinChannel($Character, $Post->Channel))
		{
			$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
			$Result->Set('Data', Array('ChannelId'=>$ChannelId));
			$_SESSION['Channels'][$ChannelId] = new stdClass();
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
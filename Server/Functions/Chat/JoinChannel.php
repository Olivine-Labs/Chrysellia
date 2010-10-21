<?php
/**
 * Chat send logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(property_exists($Post, 'Channel')
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Rights = $Database->Chat->HasRights($Character, $Post->Channel))
		{
			if($Rights['Read'])
			{
				if($ChannelId = $Database->Chat->JoinChannel($Character, $Post->Channel))
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					$Result->Set('Data', Array('ChannelId'=>$ChannelId);
				}
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
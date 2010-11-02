<?php
/**
 * Create Channel
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(property_exists($Post, 'Channel') && property_exists($Post, 'Motd'))
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		$Database->startTransaction();
		$Success = false;
		if($ChannelId = $Database->Chat->CreateChannel($Post->Channel, $Post->Motd))
		{
			if($Database->Chat->SetRights($Character, $ChannelId, Array('Read'=>1,'Write'=>1,'Moderate'=>1,'Administrate'=>1,'isJoined'=>1)))
			{
				$Success = true;
				$Database->commitTransaction();
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				$Result->Set('Data', Array('ChannelId'=>$ChannelId, 'Name'=>$Post->Channel, 'Motd'=>$Post->Motd));
			}
		}
		if(!$Success)
		{
			$Database->rollbackTransaction();
			$Result->Set('Result', \Protocol\Result::ER_ALREADYEXISTS);
		}

	}
	catch(Exception $e)
	{
		$Database->rollbackTransaction();
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>
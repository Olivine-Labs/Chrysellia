<?php
/**
 * Create Channel
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(property_exists($Get, 'Channel') && property_exists($Get, 'Motd'))
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		$Database->startTransaction();
		$Success = false;
		if($ChannelId = $Database->Chat->CreateChannel($Get->Channel, $Get->Motd))
		{
			if($Database->Chat->SetRights($Character, $ChannelId, Array('Read'=>1,'Write'=>1,'Moderate'=>1,'Administrate'=>1,'isJoined'=>1)))
			{
				$Success = true;
				$Database->commitTransaction();
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				$Result->Set('Data', Array('ChannelId'=>$ChannelId, 'Name'=>$Get->Channel, 'Motd'=>$Get->Motd));
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
<?php
namespace Functions\Commands;
/**
 * Create Channel
 */

$Get = null;
if(property_exists($ARequest, 'Data'))
{
	$Get = $ARequest->Data;
}
else
{
	$Get = new stdClass();
}

if(
	property_exists($Get, 'Channel') &&
	property_exists($Get, 'Motd') &&
	property_exists($Get, 'PublicRead') &&
	property_exists($Get, 'PublicWrite')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	$Database->startTransaction();
	$Success = false;
	if($ChannelId = $Database->Chat->CreateChannel($Get->Channel, $Get->Motd, $Get->PublicRead, $Get->PublicWrite))
	{
		if($Database->Chat->SetRights($Character, $ChannelId, Array('Read'=>1,'Write'=>1,'Moderate'=>1,'Administrate'=>1,'isJoined'=>1)))
		{
			$Success = true;
			$Database->commitTransaction();
			$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
			$Response->Set('Data', Array('ChannelId'=>$ChannelId, 'Name'=>$Get->Channel, 'Motd'=>$Get->Motd, 'PublicRead'=>$Get->PublicRead, 'PublicWrite'=>$Get->PublicWrite));
			$_SESSION['Channels'][$ChannelId] = new stdClass();
		}
	}
	if(!$Success)
	{
		$Database->rollbackTransaction();
		$Response->Set('Result', \Protocol\Response::ER_ALREADYEXISTS);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
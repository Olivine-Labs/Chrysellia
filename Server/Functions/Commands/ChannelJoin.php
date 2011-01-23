<?php
/**
 * Join Channel
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(property_exists($Get, 'Channel'))
{
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];
	if(is_array($Rights = $Database->Chat->GetRightsByName($Character, $Get->Channel)))
	{
		if($Rights['Read'])
		{
			$Rights['isJoined'] = 1;
			if($Database->Chat->SetRights($Character, $Rights['ChannelId'], $Rights))
			{
				$Channel = $Database->Chat->LoadChannel($Rights['ChannelId']);
				$Channel['ChannelId'] = $Rights['ChannelId'];
				unset($Rights['ChannelId']);
				$Channel['Permissions'] = $Rights;
				$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
				$Response->Set('Data', $Channel);
				$_SESSION['Channels'][$Channel['ChannelId']] = new stdClass();
				$_SESSION['Channels'][$Channel['ChannelId']]->LastRefresh = time() - 300;
			}
			else
			{
				$Response->Set('Result', \Protocol\Response::ER_DBERROR);
			}
		}
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
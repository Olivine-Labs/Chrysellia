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
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if(is_array($Rights = $Database->Chat->GetRightsByName($Character, $Get->Channel)))
		{
			if(!isset($Rights['Read']))
				$Rights['Read'] = $Rights['defaultAccessRead'];

			if($Rights['Read'])
			{
				$Rights['isJoined'] = 1;
				if($Database->Chat->SetRights($Character, $Rights['ChannelId'], $Rights))
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					$Result->Set('Data', $Channel);
					$_SESSION['Channels'][$Channel["ChannelId"]] = new stdClass();
					$_SESSION['Channels'][$Channel["ChannelId"]]->LastRefresh = time() - 300;
				}
				else
				{
					$Result->Set('Result', \Protocol\Result::ER_DBERROR);
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
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
			if($Rights['Read'])
			{
				$Rights['isJoined'] = 1;
				if($Database->Chat->SetRights($Character, $Rights['ChannelId'], $Rights))
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					$Result->Set('Data', $Database->Chat->LoadChannel($Rights['ChannelId']));
					$_SESSION['Channels'][$Rights['ChannelId']] = new stdClass();
					$_SESSION['Channels'][$Rights['ChannelId']]->LastRefresh = time() - 300;
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
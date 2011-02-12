<?php
namespace Functions\Commands;
/**
 * Join Channel
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
	property_exists($Get, 'ChannelId') &&
	property_exists($Get, 'Parameter') &&
	property_exists($Get, 'Value')
){
	$Character = new \Entities\Character();
	$Character->CharacterId = $_SESSION['CharacterId'];

	if($Rights = $Database->Chat->GetRights($Character, $Get->ChannelId))
	{
		if($Rights['Administrate'])
		{
			$Channel = $Database->Chat->LoadChannel($Get->ChannelId);
			if(isset($Channel['Name']))
			{
				$Success = false;
				switch($Get->Parameter)
				{
					case 'Motd':
						$Channel['Motd'] = $Get->Value;
						$Success = true;
						break;
					case 'PublicRead':
						if(($Get->Value==1) || ($Get->Value==0))
						{
							$Channel['defaultAccessRead'] = $Get->Value;
							$Success = true;
						}
							break;
					case 'PublicWrite':
						if(($Get->Value==1) || ($Get->Value==0))
						{
							$Channel['defaultAccessWrite'] = $Get->Value;
							$Success = true;
						}
						break;
				}
				if($Success)
				{
					if($Database->Chat->UpdateChannel($Get->ChannelId, $Channel['Motd'], $Channel['defaultAccessRead'], $Channel['defaultAccessWrite']))
					{
						$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
					}
					else
					{
						$Response->Set('Result', \Protocol\Response::ER_DBERROR);
					}
				}
				else
				{
					$Response->Set('Result', \Protocol\Response::ER_BADDATA);
				}
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
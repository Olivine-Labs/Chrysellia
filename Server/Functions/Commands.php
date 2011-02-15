<?php
namespace Functions;

const ACTION_EMOTE = 0;
const ACTION_CHANNEL_JOIN = 1;
const ACTION_CHANNEL_CREATE = 2;
const ACTION_CHANNEL_PART = 3;
const ACTION_CHANNEL_SETRIGHTS = 4;
const ACTION_CHANNEL_SETPARAMETERS = 5;
const ACTION_ID = 6;

/**
 * Processor for Command Requests
 *
 * Process ARequest as a Command Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessCommandRequest($ARequest, $Response, $Database)
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(property_exists($ARequest, 'Action'))
		{
			switch($ARequest->Action)
			{
				case ACTION_EMOTE:
					include './Functions/Commands/Emote.php';
					break;
				case ACTION_CHANNEL_JOIN:
					include './Functions/Commands/ChannelJoin.php';
					break;
				case ACTION_CHANNEL_CREATE:
					include './Functions/Commands/ChannelCreate.php';
					break;
				case ACTION_CHANNEL_PART:
					include './Functions/Commands/ChannelPart.php';
					break;
				case ACTION_CHANNEL_SETRIGHTS:
					include './Functions/Commands/ChannelSetRights.php';
					break;
				case ACTION_CHANNEL_SETPARAMETERS:
					include './Functions/Commands/ChannelSetParameters.php';
					break;
				case ACTION_ID:
					include './Functions/Commands/Id.php';
					break;
				default:
					$Response->Set('Result', \Protocol\Response::ER_BADDATA);
					break;
			}
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_NOTLOGGEDIN);
	}
}
?>
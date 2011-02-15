<?php
namespace Functions;

const ACTION_SENDMESSAGE = 0;
const ACTION_GETMESSAGES = 1;

/**
 * Processor for Chat Requests
 *
 * Process ARequest as a Char Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessChatRequest($ARequest, $Response, $Database)
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(property_exists($ARequest, 'Action'))
		{
			switch($ARequest->Action)
			{
				case ACTION_SENDMESSAGE:
					include './Functions/Chat/SendMessageToChannel.php';
					break;
				case ACTION_GETMESSAGES:
					include './Functions/Chat/GetMessages.php';
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
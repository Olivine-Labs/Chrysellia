<?php
if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
{
	@define('ACTION_SENDMESSAGE', 0);
	@define('ACTION_GETMESSAGES', 1);

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
?>
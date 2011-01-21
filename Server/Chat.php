<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		define('ACTION_SENDMESSAGE', 0);
		define('ACTION_GETMESSAGES', 1);

		if(isset($_GET['Action']))
		{
			switch($_GET['Action'])
			{
				case ACTION_SENDMESSAGE:
					include './Functions/Chat/SendMessageToChannel.php';
					break;
				case ACTION_GETMESSAGES:
					include './Functions/Chat/GetMessages.php';
					break;
				default:
					$Result->Set('Result', \Protocol\Result::ER_BADDATA);
					break;
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_NOTLOGGEDIN);
	}
}
?>
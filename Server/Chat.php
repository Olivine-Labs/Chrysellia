<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		define('ACTION_SENDMESSAGE', 0);
		define('ACTION_GETMESSAGES', 1);

		if(isset($_POST['Action']))
		{
			switch($_POST['Action'])
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
$Result->Output();
?>
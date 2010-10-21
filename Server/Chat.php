<?php
require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	if(isset($_SESSION['AccountId']))
	{
		define('ACTION_SENDMESSAGE', 0);
		define('ACTION_GETMESSAGESFROMCHANNEL', 1);
		define('ACTION_GETMESSAGESFORCHARACTER', 2);
		define('ACTION_JOINCHANNEL', 3);

		if(isset($_POST['Action']))
		{
			switch($_POST['Action'])
			{
				case ACTION_SENDMESSAGE:
					include './Functions/Chat/SendMessageToChannel.php';
					break;
				case ACTION_GETMESSAGESFROMCHANNEL:
					include './Functions/Chat/GetMessagesFromChannel.php';
					break;
				case ACTION_GETMESSAGESFORCHARACTER:
					include './Functions/Chat/GetMessagesForCharacter.php';
					break;
				case ACTION_JOINCHANNEL:
					include './Functions/Chat/JoinChannel.php';
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
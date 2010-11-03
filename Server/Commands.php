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
		define('ACTION_EMOTE', 0);
		define('ACTION_CHANNEL_JOIN', 1);
		define('ACTION_CHANNEL_CREATE', 2);
		define('ACTION_CHANNEL_PART', 3);
		define('ACTION_CHANNEL_SETRIGHTS', 4);

		if(isset($_POST['Action']))
		{
			switch($_POST['Action'])
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
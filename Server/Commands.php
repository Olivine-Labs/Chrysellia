<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		define('ACTION_EMOTE', 0);
		define('ACTION_CHANNEL_JOIN', 1);
		define('ACTION_CHANNEL_CREATE', 2);
		define('ACTION_CHANNEL_PART', 3);
		define('ACTION_CHANNEL_SETRIGHTS', 4);
		define('ACTION_CHANNEL_SETPARAMETERS', 5);
		define('ACTION_ID', 6);

		if(isset($_GET['Action']))
		{
			switch($_GET['Action'])
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
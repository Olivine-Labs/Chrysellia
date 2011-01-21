<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	define('ACTION_TOP', 0);//Top List
	define('ACTION_COUNT', 1);//Gets total number of characters based on criteria
	define('ACTION_ONLINE', 2);//Gets online users count
	define('ACTION_CHANNELS', 3);//Lists all public channels
	define('ACTION_CHANNELCOUNT', 4);//Count of all public channels

	if(isset($_GET['Action']))
	{
		switch($_GET['Action'])
		{
			case ACTION_TOP:
				include './Functions/API/Top.php';
				break;
			case ACTION_COUNT:
				include './Functions/API/Count.php';
				break;
			case ACTION_ONLINE:
				include './Functions/API/Online.php';
				break;
			case ACTION_CHANNELS:
				include './Functions/API/Channels.php';
				break;
			case ACTION_CHANNELCOUNT:
				include './Functions/API/ChannelCount.php';
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

?>
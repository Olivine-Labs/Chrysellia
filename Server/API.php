<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

require('./Common/Common.inc.php');
$Result = new \Protocol\Result();
$Database->Log = $Result;

if ( 'GET' == $_SERVER['REQUEST_METHOD'] )
{
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
				$Result->Set('Result', \Protocol\Result::ER_BADDATA);
				break;
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
	}
}
$Result->Output();
?>
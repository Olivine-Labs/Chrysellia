<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

require('./Common/Common.inc.php');
$Result = new \Protocol\Result();
$Database->Log = $Result;

if ( 'GET' == $_SERVER['REQUEST_METHOD'] )
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(microtime(true) > $_SESSION['NextAction'])
		{
			define('ACTION_BUY', 0);
			define('ACTION_SELL', 1);
			define('ACTION_REVIVE', 2);

			if(isset($_GET['Action']))
			{
				switch($_GET['Action'])
				{
					case ACTION_BUY:
						include './Functions/Places/Buy.php';
						break;
					case ACTION_SELL:
						include './Functions/Places/Sell.php';
						break;
					case ACTION_REVIVE:
						include './Functions/Places/Revive.php';
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
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_NOTLOGGEDIN);
	}
}
$Result->Output();
?>
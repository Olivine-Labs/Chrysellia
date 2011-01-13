<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

require('./Common/Common.inc.php');
$Result = new \Protocol\Result();
$Database->Log = $Result;

if ( 'GET' == $_SERVER['REQUEST_METHOD'] )
{
		define('ACTION_TOP', 0);
		define('ACTION_ONLINE', 0);
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
$Result->Output();
?>
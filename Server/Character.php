<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

require('./Common/Common.inc.php');
$Result = new \Protocol\Result();
$Database->Log = $Result;

if ( 'GET' == $_SERVER['REQUEST_METHOD'] )
{
	if(isset($_SESSION['AccountId']))
	{
		define('ACTION_CREATE', 0);
		define('ACTION_LIST', 1);
		define('ACTION_CHECKNAME', 2);
		define('ACTION_SELECTCHARACTER', 3);
		define('ACTION_GETCURRENTCHARACTER', 4);
		define('ACTION_LEVELUP', 5);
		define('ACTION_LOADLISTINCELL', 6);

		if(isset($_GET['Action']))
		{
			switch($_GET['Action'])
			{
				case ACTION_CREATE:
					include './Functions/Character/Create.php';
					break;
				case ACTION_LIST:
					include './Functions/Character/List.php';
					break;
				case ACTION_CHECKNAME:
					include './Functions/Character/CheckName.php';
					break;
				case ACTION_SELECTCHARACTER:
					include './Functions/Character/Select.php';
					break;
				case ACTION_GETCURRENTCHARACTER:
					include './Functions/Character/Load.php';
					break;
				case ACTION_LEVELUP:
					include './Functions/Character/LevelUp.php';
					break;
				case ACTION_LOADLISTINCELL:
					include './Functions/Character/LoadListInCell.php';
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
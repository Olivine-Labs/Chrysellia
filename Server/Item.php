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
		define('ACTION_GETINVENTORY', 0);
		define('ACTION_EQUIP', 1);
		define('ACTION_UNEQUIP', 2);

		if(isset($_GET['Action']))
		{
			switch($_GET['Action'])
			{
				case ACTION_GETINVENTORY:
					include './Functions/Item/GetInventory.php';
					break;
				case ACTION_EQUIP:
					include './Functions/Item/Equip.php';
					break;
				case ACTION_UNEQUIP:
					include './Functions/Item/Unequip.php';
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
<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	try
	{
		if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
		{
			define('ACTION_GETINVENTORY', 0);
			define('ACTION_EQUIP', 1);
			define('ACTION_UNEQUIP', 2);
			define('ACTION_SENDTRADE', 3);
			define('ACTION_ACCEPTTRADE', 4);
			define('ACTION_CANCELTRADE', 5);

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
					case ACTION_SENDTRADE:
						include './Functions/Item/SendTrade.php';
						break;
					case ACTION_ACCEPTTRADE:
						include './Functions/Item/AcceptTrade.php';
						break;
					case ACTION_CANCELTRADE:
						include './Functions/Item/CancelTrade.php';
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
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_NOTLOGGEDIN);
		}
	}
	catch(\ErrorException $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_CORE);
		$Response->AddError($e->getMessage());
	}
	catch(\Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		$Response->AddError($e->getMessage());
	}
}
?>
<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(microtime(true) > $_SESSION['NextAction'])
		{
			define('ACTION_BUY', 0);
			define('ACTION_SELL', 1);
			define('ACTION_REVIVE', 2);
			define('ACTION_WITHDRAW', 3);
			define('ACTION_DEPOSIT', 4);
			define('ACTION_TRANSFER', 5);

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
					case ACTION_WITHDRAW:
						include './Functions/Places/Withdraw.php';
						break;
					case ACTION_DEPOSIT:
						include './Functions/Places/Deposit.php';
						break;
					case ACTION_TRANSFER:
						include './Functions/Places/GoldTransfer.php';
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
?>
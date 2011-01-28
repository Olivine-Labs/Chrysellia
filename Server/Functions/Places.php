<?php
namespace Functions;

const ACTION_BUY = 0;
const ACTION_SELL = 1;
const ACTION_REVIVE = 2;
const ACTION_WITHDRAW = 3;
const ACTION_DEPOSIT = 4;
const ACTION_TRANSFER = 5;

/**
 * Processor for Place Requests
 *
 * Process ARequest as a Place Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessPlaceRequest($ARequest, $Response, $Database)
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(microtime(true) > $_SESSION['NextAction'])
		{
			if(property_exists($ARequest, 'Action'))
			{
				switch($ARequest->Action)
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
						$Response->Set('Result', \Protocol\Response::ER_BADDATA);
						break;
				}
			}
			else
			{
				$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
			}
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_NOTLOGGEDIN);
	}
}
?>
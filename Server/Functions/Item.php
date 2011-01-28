<?php
namespace Functions;

const ACTION_GETINVENTORY = 0;
const ACTION_EQUIP = 1;
const ACTION_UNEQUIP = 2;
const ACTION_SENDTRADE = 3;
const ACTION_ACCEPTTRADE = 4;
const ACTION_CANCELTRADE = 5;

/**
 * Processor for Item Requests
 *
 * Process ARequest as an Item Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessItemRequest($ARequest, $Response, $Database)
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(property_exists($ARequest, 'Action'))
		{
			switch($ARequest->Action)
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
?>
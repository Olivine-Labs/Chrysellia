<?php
namespace Functions;

const ACTION_CREATE = 0;
const ACTION_LIST = 1;
const ACTION_CHECKNAME = 2;
const ACTION_SELECTCHARACTER = 3;
const ACTION_GETCURRENTCHARACTER = 4;
const ACTION_LEVELUP = 5;
const ACTION_LOADLISTFORCELL = 6;
const ACTION_FIGHT = 7;

/**
 * Processor for Character Requests
 *
 * Process ARequest as a Character Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessCharacterRequest($ARequest, $Response, $Database)
{
	if(isset($_SESSION['AccountId']))
	{
		if(property_exists($ARequest, 'Action'))
		{
			switch($ARequest->Action)
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
				case ACTION_LOADLISTFORCELL:
					include './Functions/Character/LoadListForCell.php';
					break;
				case ACTION_FIGHT:
					include './Functions/Character/Fight.php';
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
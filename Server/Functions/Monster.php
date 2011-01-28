<?php
namespace Functions;

const ACTION_FIGHT = 0;

/**
 * Processor for Monster Requests
 *
 * Process ARequest as a Monster Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessMonsterRequest($ARequest, $Response, $Database)
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(microtime(true) > $_SESSION['NextAction'])
		{
			if(property_exists($ARequest, 'Action'))
			{
				switch($ARequest->Action)
				{
					case ACTION_FIGHT:
						include './Functions/Monster/Fight.php';
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
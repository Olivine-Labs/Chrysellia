<?php
if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
{
	if(microtime(true) > $_SESSION['NextAction'])
	{
		@define('ACTION_FIGHT', 0);

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
?>
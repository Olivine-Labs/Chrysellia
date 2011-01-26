<?php
if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
{
	if(microtime(true) > $_SESSION['NextAction'])
	{
		define('ACTION_MOVE', 0);
		define('ACTION_CHANGEMAP', 1);

		if(property_exists($ARequest, 'Action'))
		{
			switch($ARequest->Action)
			{
				case ACTION_MOVE:
					include './Functions/Map/Move.php';
					break;
				case ACTION_CHANGEMAP:
					include './Functions/Map/ChangeMap.php';
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
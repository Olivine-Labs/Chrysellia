<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		if(microtime(true) > $_SESSION['NextAction'])
		{
			define('ACTION_MOVE', 0);
			define('ACTION_CHANGEMAP', 1);

			if(isset($_GET['Action']))
			{
				switch($_GET['Action'])
				{
					case ACTION_MOVE:
						include './Functions/Map/Move.php';
						break;
					case ACTION_CHANGEMAP:
						include './Functions/Map/ChangeMap.php';
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
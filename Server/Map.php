<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	try
	{
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
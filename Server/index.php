<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	try
	{
		define('TYPE_ACCOUNT', 0);
		define('TYPE_CHARACTER', 1);
		define('TYPE_CHAT', 2);
		define('TYPE_COMMAND', 3);
		define('TYPE_ITEM', 4);
		define('TYPE_MAP', 5);
		define('TYPE_MONSTER', 6);
		define('TYPE_PLACE', 7);

		foreach($Request->Data AS $ARequest)
		{
			if(property_exists($ARequest, 'Type'))
			{
				switch($ARequest->Type)
				{
					case TYPE_ACCOUNT:
						include './Account.php';
						break;
					case TYPE_CHARACTER:
						include './Character.php';
						break;
					case TYPE_CHAT:
						include './Chat.php';
						break;
					case TYPE_COMMAND:
						include './Commands.php';
						break;
					case TYPE_ITEM:
						include './Item.php';
						break;
					case TYPE_MAP:
						include './Map.php';
						break;
					case TYPE_MONSTER:
						include './Monster.php';
						break;
					case TYPE_PLACE:
						include './Places.php';
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
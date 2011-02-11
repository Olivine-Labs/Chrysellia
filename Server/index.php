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
		define('TYPE_API', 8);

		foreach($Request->Data AS &$ARequest)
		{
			if(property_exists($ARequest, 'Type'))
			{
				if(property_exists($ARequest, 'Id'))
					$Response->Set('Id', $ARequest->Id);

				switch($ARequest->Type)
				{
					case TYPE_ACCOUNT:
						include_once('./Functions/Account.php');
						\Functions\ProcessAccountRequest($ARequest, $Response, $Database);
						break;
					case TYPE_CHARACTER:
						include_once('./Functions/Character.php');
						\Functions\ProcessCharacterRequest($ARequest, $Response, $Database);
						break;
					case TYPE_CHAT:
						include_once('./Functions/Chat.php');
						\Functions\ProcessChatRequest($ARequest, $Response, $Database);
						break;
					case TYPE_COMMAND:
						include_once('./Functions/Commands.php');
						\Functions\ProcessCommandRequest($ARequest, $Response, $Database);
						break;
					case TYPE_ITEM:
						include_once('./Functions/Item.php');
						\Functions\ProcessItemRequest($ARequest, $Response, $Database);
						break;
					case TYPE_MAP:
						include_once('./Functions/Map.php');
						\Functions\ProcessMapRequest($ARequest, $Response, $Database);
						break;
					case TYPE_MONSTER:
						include_once('./Functions/Monster.php');
						\Functions\ProcessMonsterRequest($ARequest, $Response, $Database);
						break;
					case TYPE_PLACE:
						include_once('./Functions/Places.php');
						\Functions\ProcessPlaceRequest($ARequest, $Response, $Database);
						break;
					case TYPE_API:
						include_once('./Functions/API.php');
						\Functions\ProcessAPIRequest($ARequest, $Response, $Database);
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
			$Response->NextResponse();
		}
	}
	catch(\ErrorException $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_CORE);
		$Response->AddError($e->getMessage().' in '.$e->getFile().' at line '.$e->getLine());
	}
	catch(\Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
		$Response->AddError($e->getMessage());
	}
}
?>
<?php
require './Common/Common.inc.php';
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	if(isset($_SESSION['AccountId']))
	{
		define('CREATE', 0);
		define('LIST', 0);
		define('CHECKNAME', 0);

		if(isset($_POST['Data']))
		{
			$Post = json_decode($_POST['Data']);
			if(property_exists($Post->Action))
			{
				switch($Post->Action)
				{
					case CREATE:
						include './Functions/Character/Create.php';
						break;
					case LIST:
						include './Functions/Character/List.php';
						break;
					case CHECKNAME:
						include './Functions/Character/CheckName.php';
						break;
					default:
						$Result->Set('Result', ER_BADDATA);
						break;
				}
			}
			else
			{
				$Result->Set('Result', ER_MALFORMED);
			}
		}
		else
		{
			$Result->Set('Result', ER_MALFORMED);
		}
	}
}
$Result->Output();
?>
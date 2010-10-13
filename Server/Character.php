<?php
require './Common/Common.inc.php';
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	define('CREATE', 0);

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
$Result->Output();
?>
<?php
require './Common/Common.inc.php';
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	define('LOGIN', 0);
	define('REGISTER', 1);

	if(isset($_POST['Data']))
	{
		$Post = json_decode($_POST['Data']);
		if(property_exists($Post->Action))
		{
			switch($Post->Action)
			{
				case LOGIN:
					include './Functions/Account/Login.php';
					break;
				case REGISTER:
					include './Functions/Account/Register.php';
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
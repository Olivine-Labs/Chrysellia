<?php
if ( 'GET' === $_SERVER['REQUEST_METHOD'] )
{
	include('./Common/Common.inc.php');
	define('ACTION_LOGIN', 0);
	define('ACTION_REGISTER', 1);
	define('ACTION_LOGOUT', 2);

	if(isset($_GET['Action']))
	{
		switch($_GET['Action'])
		{
			case ACTION_LOGIN:
				include './Functions/Account/Login.php';
				break;
			case ACTION_REGISTER:
				include './Functions/Account/Register.php';
				break;
			case ACTION_LOGOUT:
				include './Functions/Account/Logout.php';
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
?>
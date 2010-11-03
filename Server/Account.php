<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	define('ACTION_LOGIN', 0);
	define('ACTION_REGISTER', 1);
	define('ACTION_LOGOUT', 2);

	if(isset($_POST['Action']))
	{
		switch($_POST['Action'])
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
				$Result->Set('Result', \Protocol\Result::ER_BADDATA);
				break;
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
	}
}
$Result->Output();
?>
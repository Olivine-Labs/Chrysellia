<?php
define('ACTION_LOGIN', 0);
define('ACTION_REGISTER', 1);
define('ACTION_LOGOUT', 2);

if(property_exists($ARequest, 'Action'))
{
	switch($ARequest->Action)
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
?>
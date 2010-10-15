<?php
require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	define('ACTION_LOGIN', 0);
	define('ACTION_REGISTER', 1);

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
$Result->Output();
?>
<?php
namespace Functions;

const ACTION_LOGIN = 0;
const ACTION_REGISTER = 1;
const ACTION_LOGOUT = 2;

/**
 * Processor for Account Requests
 *
 * Process ARequest as an Account Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessAccountRequest($ARequest, $Response, $Database)
{
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
}
?>
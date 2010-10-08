<?php
require './autoload.php';
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	define('LOGIN', 0);
	define('REGISTER', 1);

	$Post = json_decode($_POST['Data']);
switch($Post->action)
{
	case LOGIN:
		$AnAccount = new \Entities\Account();
		$AnAccount->Name = $Post->Data->UserName;
		$AnAccount->Password = $Post->Data->Password;
		if($AnAccount->Verify())
		{
			try
			{
				$Database = new \Database\MySQL\Database('localhost', '3306', 'root', '', 'neflaria');
				if($Database->Accounts->Login($AnAccount))
				{
					$Result->Set('Result', \Protocol\ER_SUCCESS);
				}
			}
			catch(Exception $e)
			{
				$Result->Set('Result', ER_DBERROR);
			}
		}
		break;
	case REGISTER:
		//TODO
		break;
}
}
$Result->Output();
?>
<?php
require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	//TODO
	//define('ACTION_SENDCHAT', 0);
	//define('ACTION_REFRESHCHAT', 1);

	if(isset($_POST['Action']))
	{
		switch($_POST['Action'])
		{
			default:
				$Result->Set('Result', \Protocol\ER_BADDATA);
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
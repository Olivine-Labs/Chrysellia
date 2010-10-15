<?php
require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	//TODO
	//define('ACTION_SENDCHAT', 0);
	//define('ACTION_REFRESHCHAT', 1);

	if(isset($_POST['Data']))
	{
		$Post = json_decode($_POST['Data']);
		if(property_exists($Post, 'Action'))
		{
			switch($Post->Action)
			{
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
$Result->Output();
?>
<?php
require('./Common/Common.inc.php');
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	if(isset($_SESSION['AccountId']) && isset($_SESSION['CharacterId']))
	{
		define('ACTION_EMOTE', 0);
		define('ACTION_JOINCHANNEL', 1);
		define('ACTION_CREATECHANNEL', 2);
		define('ACTION_PARTCHANNEL', 3);

		if(isset($_POST['Action']))
		{
			switch($_POST['Action'])
			{
				case ACTION_EMOTE:
					include './Functions/Commands/Emote.php';
					break;
				case ACTION_JOINCHANNEL:
					include './Functions/Commands/JoinChannel.php';
					break;
				case ACTION_CREATECHANNEL:
					include './Functions/Commands/CreateChannel.php';
					break;
				case ACTION_PARTCHANNEL:
					include './Functions/Commands/PartChannel.php';
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
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_NOTLOGGEDIN);
	}
}
$Result->Output();
?>
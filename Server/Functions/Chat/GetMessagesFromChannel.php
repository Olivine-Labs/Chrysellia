<?php
/**
 * Channel refresh logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

try
{
	if(property_exists($Post, 'Channel'))
	{
		if(strlen($Post->Channel) == 28)
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			$ChatArray = $Database->Chat->LoadListForChannel($Character, $Post->Channel, $_SESSION[$Post->Channel]);
			{
				$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				$Result->Set('Data', $ChatArray);
				$_SESSION[$Post->Channel] = time();
			}
		}
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
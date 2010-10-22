<?php
/**
 * Chat send logic
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(property_exists($Post, 'Channel'))
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadById($Character))
		{
			if($Rights = $Database->Chat->GetRights($Character, $Post->Channel))
			{
				if($Rights['Write'])
				{
					if($Database->Chat->Insert($Character, $Post->Channel, $Post->Message))
					{
						$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
					}
				}
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_BADDATA);
		}
	}
	catch(Exception $e)
	{
		$Result->Set('Result', \Protocol\Result::ER_DBERROR);
	}
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}

?>
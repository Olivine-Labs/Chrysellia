<?php
/**
 * Chat send logic
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

if(
	property_exists($Get, 'Channel') &&
	property_exists($Get, 'Message')
)
{
	try
	{
		$Character = new \Entities\Character();
		$Character->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadById($Character))
		{
			if(is_array($Rights = $Database->Chat->GetRights($Character, $Get->Channel)))
			{
				if($Rights['Write'])
				{
					if($Database->Chat->Insert($Character, $Get->Channel, $Get->Message))
					{
						$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
					}
				}
			}
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_BADDATA);
		}
	}
	catch(Exception $e)
	{
		$Response->Set('Result', \Protocol\Response::ER_DBERROR);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}

?>
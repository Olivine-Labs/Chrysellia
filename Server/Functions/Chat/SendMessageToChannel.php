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
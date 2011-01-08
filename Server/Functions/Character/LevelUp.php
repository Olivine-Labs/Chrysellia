<?php
/**
 * try to spend a freelevel
 */

$Get = (object)Array('Data'=>'');
if(isset($_GET['Data']))
{
	$Get = json_decode($_GET['Data']);
}

try
{
	if(
		property_exists($Get, 'Stat')
	){
		if(($Get->Stat >= 0) && ($Get->Stat < 5))
		{
			$Character = new \Entities\Character();
			$Character->CharacterId = $_SESSION['CharacterId'];
			if($Database->Characters->LoadTraits($Character))
			{
				if($Character->FreeLevels > 0)
				{
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				}
			}
			else
			{
				$Result->Set('Result', \Protocol\Result::ER_DBERROR);
			}
		}
		else
		{
			$Result->Set('Result', \Protocol\Result::ER_BADDATA);
		}
	}
	else
	{
		$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
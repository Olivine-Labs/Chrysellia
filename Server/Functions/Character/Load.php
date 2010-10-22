<?php
/**
 * Load a character in it's entirety - called on first selecting a character
 */
try
{
	if(isset($_SESSION['CharacterId']))
	{
		$ACharacter = new \Entities\Character();
		$ACharacter->CharacterId = $_SESSION['CharacterId'];
		if($Database->Characters->LoadById($ACharacter))
		{
			if($Database->Characters->LoadTraits($ACharacter))
			{
				if($Database->Characters->LoadPosition($ACharacter))
				{
					if($ACharacter->Pin > 0)
						$ACharacter->HasPin = true;
					else
						$ACharacter->HasPin = false;
					$ACharacter->Pin = null;
					$Result->Set('Data', $ACharacter);
					$Result->Set('Result', \Protocol\Result::ER_SUCCESS);
				}
				else
				{
					$Result->Set('Result', \Protocol\Result::ER_DBERROR);
				}
			}
			else
			{
				$Result->Set('Result', \Protocol\Result::ER_DBERROR);
			}
		}
	}
}
catch(Exception $e)
{
	$Result->Set('Result', \Protocol\Result::ER_DBERROR);
}

?>
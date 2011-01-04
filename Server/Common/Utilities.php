<?php

function VerifyEmailAddress($EMail)
{
	list($User, $Domain) = explode("@", $EMail);
	$Result = checkdnsrr($Domain, 'MX');
	return($Result);
}

function IsProxy($IP)
{
	$Result = FALSE;//Innocent until proven Guilty
	$BlackList = array(	'dnsbl.kempt.net',
					'blackholes.five-ten-sg.com',
					'0spam.fusionzero.com',
					'dnsbl.ahbl.org',
					'bl.spamcop.net'
	);
	if (preg_match("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", $IP, $Matches))
	{
		foreach ($BlackList as $Server) 
		{
			echo $Server;
			$ServerHost = $Matches[4] . "." . $Matches[3] . "." . $Matches[2] . "." . $Matches[1] . "." . $Server;
			$Resolved = gethostbyname($ServerHost);
			if ($Resolved != $ServerHost)
			{
				$Result = TRUE;//GUILTY!
				break;
			}
		}
	}
	return $Result;
}
?>
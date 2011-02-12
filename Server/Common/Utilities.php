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
	if (preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)/", $IP, $Matches))
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

// N(0,1)
// returns random number with normal distribution:
// mean=0
// std dev=1
function gauss()
{
	// auxilary vars
	$x=random_0_1();
	$y=random_0_1();

	// two independent variables with normal distribution N(0,1)
	$u=sqrt(-2*log($x))*cos(2*pi()*$y);

	return $u;
}

// N(m,s)
// returns random number with normal distribution:
// mean=m
// std dev=s
function gauss_ms($m=0.0, $s=1.0)
{
	return gauss()*$s+$m;
}

// auxiliary function
// returns random number with flat distribution from 0 to 1
function random_0_1()
{
	return (float)rand()/(float)getrandmax();
} 
?>
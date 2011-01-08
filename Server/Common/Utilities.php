<?php
namespace \;

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

function InverseCumulativeStandardDistribution($p)
{
	//Constants
	$a1 = -39.6968302866538;
	$a2 = 220.946098424521;
	$a3 = -275.928510446969;
	$a4 = 138.357751867269;
	$a5 = -30.6647980661472;
	$a6 = 2.50662827745924;
	$b1 = -54.4760987982241;
	$b2 = 161.585836858041;
	$b3 = -155.698979859887;
	$b4 = 66.8013118877197;
	$b5 = -13.2806815528857;
	$c1 = -7.78489400243029E-03;
	$c2 = -0.322396458041136;
	$c3 = -2.40075827716184;
	$c4 = -2.54973253934373;
	$c5 = 4.37466414146497;
	$c6 = 2.93816398269878;
	$d1 = 7.78469570904146E-03;
	$d2 = 0.32246712907004;
	$d3 = 2.445134137143;
	$d4 = 3.75440866190742;

	//Limits
	$p_low = 0.02425;
	$p_high = 1 - $p_low;

	//?
	$q = 0.0;
	$r = 0.0;

	//Argument out of range
	if($p < 0 || $p > 1)
	{
		throw new Exception("ICSD: Argument out of range.");
	}
	else
	//NormSInv Calculation
	if($p < $p_low)
	{
		$q = pow(-2 * log($p), 2);
		$NormSInv = ((((($c1 * $q + $c2) * $q + $c3) * $q + $c4) * $q + $c5) * $q + $c6) / (((($d1 * $q + $d2) * $q + $d3) * $q + $d4) * $q + 1);
	}
	else
	if($p <= $p_high)
	{
		$q = $p - 0.5;
		$r = $q * $q;
		$NormSInv = ((((($a1 * $r + $a2) * $r + $a3) * $r + $a4) * $r + $a5) * $r + $a6) * $q / ((((($b1 * $r + $b2) * $r + $b3) * $r + $b4) * $r + $b5) * $r + 1);
	}
	else
	{
		$q = pow(-2 * log(1 - $p), 2);
		$NormSInv = -((((($c1 * $q + $c2) * $q + $c3) * $q + $c4) * $q + $c5) * $q + $c6) / (((($d1 * $q + $d2) * $q + $d3) * $q + $d4) * $q + 1);
	}
	return $NormSInv;
}

function gauss()
{ // N(0,1)
// returns random number with normal distribution:
// mean=0
// std dev=1

// auxilary vars
$x=random_0_1();
$y=random_0_1();

// two independent variables with normal distribution N(0,1)
$u=sqrt(-2*log($x))*cos(2*pi()*$y);

return $u;
}

function gauss_ms($m=0.0,$s=1.0)
{ // N(m,s)
// returns random number with normal distribution:
// mean=m
// std dev=s

return gauss()*$s+$m;
}

function random_0_1()
{ // auxiliary function
// returns random number with flat distribution from 0 to 1
return (float)rand()/(float)getrandmax(); } 
?>
<?php

if (!function_exists('checkdnsrr'))
{
function checkdnsrr($Domain, $Type = 'MX')
{
	$Result = FALSE;
	@exec("nslookup -type=$Type $Domain", $Output);
	while((list($Junk, $Line) = each($Output)) && $Result === FALSE)
	{
		if(eregi("^$Domain", $Line))
		{
			$Result = TRUE;
		}
	}
	return($Result);
}
}

?>
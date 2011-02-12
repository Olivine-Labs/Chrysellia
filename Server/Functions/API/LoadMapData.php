<?php
namespace Functions\API;
/**
 * Load Map Data logic
 */

$Get = null;
if(property_exists($Request, 'Data'))
{
	$Get = $Request->Data;
}
else
{
	$Get = new stdClass();
}

if(
	property_exists($Get, 'MapId') &&
	property_exists($Get, 'XLow') &&
	property_exists($Get, 'YLow') &&
	property_exists($Get, 'XHigh') &&
	property_exists($Get, 'YHigh')
){
	if(
		($Get->XLow >= 0) &&
		($Get->YLow >= 0) &&
		($Get->XHigh >= 0) &&
		($Get->YHigh >= 0)
	){
		$DiffX = abs($Get->XHigh - $Get->XLow);
		$DiffY = abs($Get->YHigh - $Get->YLow);
		if(
			($DiffX <= 5) &&
			($DiffY <= 5)
		){
			$Map = new \Entities\Map();
			$Map->MapId = $Get->MapId;
			if($Database->Maps->LoadMapById($Map))
			{
				if(
					($Get->XLow < $Map->DimensionX) &&
					($Get->YLow < $Map->DimensionY) &&
					($Get->XHigh < $Map->DimensionX) &&
					($Get->YHigh < $Map->DimensionY)
				){
					if($Data = $Database->Maps->LoadCellRange($Map, $Get->XLow, $Get->YLow, $Get->XHigh, $Get->YHigh)){
						$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
						$Response->Set('Data', $Data);
					}else{
						$Response->Set('Result', \Protocol\Response::ER_BADDATA);
					}
				}
				else
				{
					$Response->Set('Result', \Protocol\Response::ER_BADDATA);
				}
			}
			else
			{
				$Response->Set('Result', \Protocol\Response::ER_BADDATA);
			}
		}
		else
		{
			$Response->Set('Result', \Protocol\Response::ER_BADDATA);
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_BADDATA);
	}
}
else
{
	$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
}
?>
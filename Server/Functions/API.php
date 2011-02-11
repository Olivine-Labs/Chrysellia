<?php
namespace Functions;

const ACTION_TOP = 0;//Top List
const ACTION_COUNT = 1;//Gets total number of characters based on criteria
const ACTION_ONLINE = 2;//Gets online users count
const ACTION_CHANNELS = 3;//Lists all public channels
const ACTION_CHANNELCOUNT = 4;//Count of all public channels
const ACTION_LOADMAPDATA = 5;//Loads an area of map data

/**
 * Processor for API Requests
 *
 * Process ARequest as an API Request
 *
 * @param $ARequest
 *   The request object to process.
 */
function ProcessAPIRequest($ARequest, $Response, $Database)
{
	if(property_exists($Request->Data, 'Action'))
	{
		switch($Request->Data->Action)
		{
			case ACTION_TOP:
				include './Functions/API/Top.php';
				break;
			case ACTION_COUNT:
				include './Functions/API/Count.php';
				break;
			case ACTION_ONLINE:
				include './Functions/API/Online.php';
				break;
			case ACTION_CHANNELS:
				include './Functions/API/Channels.php';
				break;
			case ACTION_CHANNELCOUNT:
				include './Functions/API/ChannelCount.php';
				break;
			case ACTION_LOADMAPDATA:
				include './Functions/API/LoadMapData.php';
				break;
			default:
				$Response->Set('Result', \Protocol\Response::ER_BADDATA);
				break;
		}
	}
	else
	{
		$Response->Set('Result', \Protocol\Response::ER_MALFORMED);
	}
}

?>
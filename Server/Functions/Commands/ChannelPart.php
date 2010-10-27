<?php
/**
 * Join Channel
 */

$Post = (object)Array('Data'=>'');
if(isset($_POST['Data']))
{
	$Post = json_decode($_POST['Data']);
}

if(property_exists($Post, 'Channel'))
{
	unset($_SESSION['Channels'][$ChannelId]);
}
else
{
	$Result->Set('Result', \Protocol\Result::ER_MALFORMED);
}
?>
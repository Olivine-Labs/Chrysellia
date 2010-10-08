<?php
require './autoload.php';
$Result = new \Protocol\Result();

if ( 'POST' == $_SERVER['REQUEST_METHOD'] )
{
	//Login
	//TODO

	$Result->Set('Result', 255);

	//Register
	//TODO
}

$Result->Output();
?>
<?php
require './autoload.php';

$Database = new \Database\MySQL\Database('localhost', '3306', 'root', '', 'neflaria');
//Login
$Result = new \Protocol\Result();
$Result->Data["result"] = '0';
$Result->Output();

//Register

?>
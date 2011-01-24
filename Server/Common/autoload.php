<?php

/**
 * This is a special PHP function that auto-includes class files based on their name.
 *
 * @param $ClassName
 *   This is the full canonical name of the class that we need to load, including namespace.
 */
function __autoload($ClassName)
{
	$FileName = './';
	$Pieces = explode("\\", $ClassName);
	foreach($Pieces AS $Piece)
		$FileName .= $Piece.'/';
	$FileName[strlen($FileName)-1] = '.';
	$FileName .= 'class.php';
	include($FileName);
}

?>
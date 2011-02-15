<?php
namespace Common;
/**
 * This file implements an error handler to figure out what to do with errors
 *
 *
 */

class ErrorHandler
{
	public function __construct()
	{
		set_error_handler(array(&$this, 'HandleError'));
	}

	function HandleError($errno, $errstr, $errfile, $errline, array $errcontext)
	{
		// error was suppressed with the @-operator
		if (0 === error_reporting())
		{
			return false;
		}
		throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
	}

}
?>
<?php
namespace Common;

/**
 * This file implements a session handler to store sessions in the database.
 *
 *
 */
class Session
{
	private $Database = null;

	public function __construct(\Database\Database $Database)
	{
		$this->Database = $Database;
		session_set_save_handler(
			array($this,	"_start"),
			array($this,	"_end"),
			array($this,	"_read"),
			array($this,	"_write"),
			array($this,	"_destroy"),
			array($this,	"_gc")
		);
	}

	public function Start()
	{
		session_name('ChryselliaSessionId');
		session_start();
	}

	public function _start($path, $name)
	{
		return true;
	}

	public function _end()
	{
		return true;
	}

	public function _read($Id)
	{
		return $this->Database->Sessions->Load($Id);
	}

	public function _write($Id, $Data)
	{
		$AccountId=null;
		if(array_key_exists('AccountId', $_SESSION))
			$AccountId=$_SESSION['AccountId'];
		$CharacterId=null;
		if(array_key_exists('CharacterId', $_SESSION))
			$CharacterId = $_SESSION['CharacterId'];
		return $this->Database->Sessions->Replace($Id, $AccountId, $CharacterId, $Data);
	}

	public function _gc($Seconds)
	{
		return $this->Database->Sessions->Clean($Seconds);
	}

	public function _destroy($Id)
	{
		return $this->Database->Sessions->Delete($Id);
	}

	public function __destruct()
	{
		session_write_close();
	}
}
?>
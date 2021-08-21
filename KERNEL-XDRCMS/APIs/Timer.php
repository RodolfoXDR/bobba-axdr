<?php
class Timer {
	private $Name = '';
	public $NowCreated = false;

	static $foo = null;

	function Timer($name)
	{
		$this->Name = $name;

		if(isset($_SESSION['timers'][$name]))
			return;
		
		$_SESSION['timers'][$name] = time();
		$this->NowCreated = true;
	}

	public function Reload()
	{
		$_SESSION['timers'][$this->Name] = time();
	}

	public function IsExpired($m)
	{
		return time() - $_SESSION['timers'][$this->Name] > ($m * 60) || $this->NowCreated;
	}
}
?>
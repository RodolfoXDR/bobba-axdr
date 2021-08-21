<?php
const SQL_NUM = MYSQLI_NUM;
const SQL_ASSOC = MYSQLI_ASSOC;
const SQL_BOTH = MYSQLI_BOTH;

class SQL {
	static $_mysqli;
	static $_info;
	
	public static $affected_rows;
	public static $insert_id;
	public static $error;
	public static $server_info;
	
	public static $QueryCount = 0;
	public static $Character;
	
	public static $Logs;

	public static function Connect($c)
	{
		self::$_info = $c;
		if(DEBUG)
		{
			self::$Logs = [];
			self::RealConnect();
		}
	}
	
	public static function prepare($q)
	{
		if(self::$_mysqli == null && DEBUG)
			return;
		if(self::$_mysqli == null)
			self::RealConnect();

		$stmt = self::$_mysqli->prepare($q);
		if(!$stmt)
            error_log('MySQLi Controler: ' . self::$_mysqli->error . '. q: ' . $q, 0);
		
		if(Tool::StartsWith($q, 'INSERT', 'REPLACE', 'UPDATE'))
			return new SQLSTMTInsert($stmt);
		else
			return new SQLSTMTSelect($stmt, self::$QueryCount);
	}
	
	public static function query($q)
	{
		if(self::$_mysqli == null && DEBUG)
			return;
		if(self::$_mysqli == null)
			self::RealConnect();

		++self::$QueryCount;
		$r = self::$_mysqli->query($q);
		
		if(!$r)
            error_log('MySQLi Controler: ' . self::$_mysqli->error . '. q: ' . $q, 0);

		self::Update();
		return $r === false ? false : new SQLResult($r);
	}
	
	public static function multi_query($q)
	{
		if(self::$_mysqli == null && DEBUG)
			return;
		if(self::$_mysqli == null)
			self::RealConnect();

		++self::$QueryCount;
		$r = self::$_mysqli->multi_query($q);

		do	{$a[] = new SQLResult(self::$_mysqli->store_result());	if(!self::$_mysqli->more_results())	break;}while (self::$_mysqli->next_result());

		if(!$r)
            error_log('MySQLi Controler: ' . self::$_mysqli->error . '. q: ' . $q, 0);

		self::Update();

		return $a;
	}
	
	public static function close()
	{
		self::$_mysqli->close();
	}
	
	static function RealConnect()
	{
		self::$_mysqli = @new mysqli(self::$_info['host'], self::$_info['userName'], self::$_info['passWord'], self::$_info['dbName'], self::$_info['port']);
		if (self::$_mysqli->connect_error)
		{
			if(DEBUG)
			{
				$GLOBALS['coreLogs'][] = ['IconErrorEncoded', 'aXDR.Core.SQL', 'Cancelada ejecución de todas las peticiones a la base de datos.'];
				self::$Logs[] = ['IconErrorEncoded', 'aXDR.Core.SQL', 'No se ha podido conectar al servidor SQL. <br /> <strong>Error ' . self::$_mysqli->connect_errno . '</strong>: ' . self::$_mysqli->connect_error];

				self::$_mysqli = null;
			}
			else
				die('Error MySQLi(with Azure API) connection, (' . self::$_mysqli->connect_errno . ') '. self::$_mysqli->connect_error);
			return;
		}

		
		self::$_info = null;
		self::$server_info = self::$_mysqli->server_info;
		self::$Character = self::$_mysqli->character_set_name();
		self::$_mysqli->set_charset("utf8");
		self::Update();
	}

	static function Update()
	{
		self::$affected_rows = self::$_mysqli->affected_rows;
		self::$insert_id = self::$_mysqli->insert_id;
		self::$error = self::$_mysqli->error;
	}
}

class SQLResult
{
	private $_result;
	
	private $num_rows = null;

	function __construct($r)
	{
		$this->_result = $r;
	}
	
	public function __get($p)
	{
		if($p != 'num_rows')
		{
			$trace = debug_backtrace();
			trigger_error('Undefined variable: ' . $p . ' in <b>' . $trace[0]['file'] . '</b> on line ' . $trace[0]['line'], E_USER_NOTICE);
			
			return null;
		}

		if($this->_result != null && $this->_result != false && isset($this->_result->num_rows))
			$this->num_rows = $this->_result->num_rows;

		return $this->num_rows;
	}

	public function fetch_assoc()
	{
		return $this->_result->fetch_assoc();
	}
	
	public function fetch_array($t = SQL_ASSOC)
	{
		return $this->_result->fetch_array($t);
	}
	
	public function fetch_all($t = SQL_ASSOC)
	{
		$a = [];
		while($dataRow = $this->fetch_array($t))
			array_push($a, $dataRow);
		
		return $a;
	}
}

class SQLSTMTInsert
{
	private $_stmt;
	private $_i;

	function __construct($stmt, &$i)
	{
		$this->_stmt = $stmt;
		$this->_i = &$i;
	}
	
	public function execute($t = '', ...$p)
	{
		if(!empty($t))
			$this->_stmt->bind_param($t, ...$p);

		++$this->_i;
		return $this->_stmt->execute();
	}
}

class SQLSTMTSelect
{
	private $_stmt;
	private $_i;

	function __construct($stmt, &$i)
	{
		$this->_stmt = $stmt;
		$this->_i = &$i;
	}
	
	public function execute($t = '', ...$p)
	{
		if(!empty($t))
			$this->_stmt->bind_param($t, ...$p);

		$this->_stmt->execute();
		++$this->_i;

		return new SQLResult($this->_stmt->get_result());
	}
}
?>
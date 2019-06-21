<?php
//params to connect to db
define("DB_HOST",		"localhost");
define("DB_NAME",		"borland");
define("DB_USER",		"borland");
define("DB_PASS",		"3183191aA");

class DB
{
	protected static $instance = null;

	protected function __construct() {}
	protected function __clone() {}

	public static function instance()
	{
			if (self::$instance === null)
			{
					$opt  = array(
							PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
							PDO::ATTR_EMULATE_PREPARES   => FALSE,
					);
					$dsn = 'pgsql:host='.DB_HOST.';dbname='.DB_NAME;
					self::$instance = new PDO($dsn, DB_USER, DB_PASS, $opt);
			}
			return self::$instance;
	}

	public static function __callStatic($method, $args)
	{
			return call_user_func_array(array(self::instance(), $method), $args);
	}

	public static function prep($sql) {
		$stmt = self::instance()->prepare($sql);
		return $stmt;
	}


	public static function run($sql, $args = []) {
		if (!$args) {
			return self::instance()->query($sql);
		}

		$stmt = self::instance()->prepare($sql);
		$stmt->execute($args);
		return $stmt;
	}
}

function clean($string) {
	$string = trim($string);
	$string = htmlspecialchars($string);
	$string = pg_escape_string($string);
	return $string;
};

?>
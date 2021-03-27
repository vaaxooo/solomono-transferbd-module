<?php

ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once("DB.php");

if(isset($_POST['data']))
{
	$data = $_POST['data'];

	if(file_exists('tempdb.php'))
	{
		unlink('tempdb.php');
	}

   $file = fopen('tempdb.php', 'w');
   fwrite($file, $data);

   fclose($file);
}

$tempdb = json_decode(@file_get_contents("tempdb.php"), true);
mysqli_report(MYSQLI_REPORT_STRICT);

try {
	$oc_mysqli = new MySQLi($tempdb['opencart']['host'], $tempdb['opencart']['user'], $tempdb['opencart']['password'], $tempdb['opencart']['name']);
	$oc_database = new DB($oc_mysqli);
} catch (Exception $e)
{
	exit(json_encode(["message" => "OpenCart database not connected! Check your details!", "connection" => false]));
}

try {
	$solomono_mysqli = new MySQLi($tempdb['solomono']['host'], $tempdb['solomono']['user'], $tempdb['solomono']['password'], $tempdb['solomono']['name']);
	$solomono_database = new DB($solomono_mysqli);
} catch (Exception $e)
{
	exit(json_encode(["message" => "Solomono database not connected! Check your details!", "connection" => false]));
}

exit(json_encode(["message" => "Database connected!", "connection" => true]));

?>
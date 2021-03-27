<?php

require_once("DB.php");

if(!file_exists("tempdb.php")) {
	exit(["message" => "Database not connected!", "ok" => false]);
}

$tempdb = json_decode(@file_get_contents("tempdb.php"), true);

$oc_database = new DB($tempdb['opencart']['host'], $tempdb['opencart']['user'], $tempdb['opencart']['password'], $tempdb['opencart']['name']);
$solomono_database = new DB($tempdb['solomono']['host'], $tempdb['solomono']['user'], $tempdb['solomono']['password'], $tempdb['solomono']['name']);
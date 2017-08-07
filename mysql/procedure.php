<?php
require_once 'mysql.ini.php';
$database = 'aaa';
$mysqli = new mysqli ( $servername, $username, $password, $database );
if ($mysqli->connect_error) {
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
//IN INOUT OUT
if (! $mysqli->query ( "DROP PROCEDURE IF EXISTS p" ) 
		|| ! $mysqli->query ( "CREATE PROCEDURE p(IN id_val INT) BEGIN INSERT INTO test(id) VALUES(id_val); END;" ))
{
	echo "Stored procedure creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (! $mysqli->query ( "CALL p(4)" )) {
	echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (! ($res = $mysqli->query ( "SELECT id FROM test" ))) {
	echo "SELECT failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
var_dump ( $res->fetch_assoc () );
var_dump ( $res->fetch_all () );
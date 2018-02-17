<?php
	# Common functions for the lyric API.

	# returns: a new database connection
	function get_db() {
		$db = new PDO("mysql:host=127.0.0.1;dbname=hw7;charset=utf8", "root", "root");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

	# Inserts a lyric into the given database.
	# params:
	#		$db: a database connection
	#		$lyric: a lyric to be inserted
	function insert($db, $lyric) {
		$insert = "INSERT INTO Lyrics (lyirc) ";
		$values = "VALUES ('$lyric');";
		$db->exec($insert . $values);
	}

	# Removes a lyric from the given database.
	# params:
	#		$db: a database connection
	#		$lyric: a lyric to be removed
	function delete($db, $lyric) {
		$db->exec("DELETE FROM Lyrics WHERE lyric = '$lyric';");
	}

	# Creates an error response for when a request is made with invalid parameters
	# params:
	#		$params: an array of length 1 or 2 of the missing parameters
	#		$conjoiner: "and" or "or" for when there are two parameters
	# returns:
	#		An error respsonse JSON object
	function missing_param($params, $conjoiner = null) {
		header("HTTP/1.1 400 Invalid Request");
		$paramOne = $params[0];
		$error = "Missing $paramOne";
		if($params[1]) {
			$error = $error . " " . $conjoiner . " " . $params[1];
		}
		$error = $error . " parameter";
		$output["error"] = $error;
		return $output;
	}
?>
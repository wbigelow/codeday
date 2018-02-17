<?php
	function get_db() {
		$db = new PDO("mysql:host=127.0.0.1;dbname=hw7;charset=utf8", "root", "root");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

	function insert($db, $lyric) {
		$insert = "INSERT INTO Lyrics (lyirc) ";
		$values = "VALUES ('$lyric');";
		$db->exec($insert . $values);
	}

	function delete($db, $lyric) {
		$db->exec("DELETE FROM Lyrics WHERE lyric = '$lyric';");
	}

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
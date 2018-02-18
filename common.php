<?php
	# Common functions for the lyric/phrase API.

	# returns: a new database connection
	function get_db() {
		$db = new PDO("mysql:host=wbigelow.vergil.u.washington.edu;port=12546;dbname=codeday;charset=utf8", "root", "root");
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}

	# Inserts a phrase into the given database.
	# params:
	#		$db: a database connection
	#		$phrase: a phrase to be inserted
	function insert($db, $phrase) {
		$insert = "INSERT INTO Phrases (phrase) ";
		$values = "VALUES ('$phrase');";
		$db->exec($insert . $values);
	}

	# Removes a phrase from the given database.
	# params:
	#		$db: a database connection
	#		$phrase: a phrase to be removed
	function delete($db, $phrase) {
		$db->exec("DELETE FROM Phrases WHERE phrase = '$phrase';");
	}

	# Checks to see if a phrase is in the given database.
	# params:
	#		$db: a database connection
	#		$phrase: a phrase to be checked
	# returns:
	#		an error if the phrase is in the database
	function contains($db, $phrase) {
		$count = count($db->query("SELECT * FROM Phrases WHERE phrase = '$phrase';")->fetchAll());
		if($count) {
			$output["error"] = "Error: Phrase already in database.";
			return $output;
		}
	}

	# Gets all phrases containing the word
	# params:
	#		$db: a database connection
	#		$phrase: a phrase to be checked
	# returns:
	#		an error if the phrase is in the database
	function findall($db, $word) {
		return $db->query("SELECT * FROM Phrases WHERE phrase LIKE '%$word %';")->fetchAll();
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
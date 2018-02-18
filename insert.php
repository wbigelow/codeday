<?php
	# Takes a post parameter "phrase" and inserts the
	# phrase into the quote/lyric database
	# Gives a 400 error message if no name parameter is passed.
	include("common.php");
	$phrase = $_POST["phrase"];
	if(!$phrase) {
		$output = missing_param(["phrase"]);
	} else {
		$db = get_db();
		insert($db, $phrase);
		$output["success"] = "Successfully added phrase to database";
	}
	header("Content-Type: application/json");
	print(json_encode($output));
?>
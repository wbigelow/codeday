<?php
	# Takes get parameter "word" and returns all phrases containing that word
	include("common.php");
	$word = $_GET["word"];
	if(!$word) {
		$output = missing_param(["word"]);
	} else {
		$db = get_db();
		$output["phrases"] = findall($db, $word);
	}
	header("Content-Type: application/json");
	print(json_encode($output));
?>
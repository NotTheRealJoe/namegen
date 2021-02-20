<?php

$adverbs = explode("\n", file_get_contents('adverb.list'));
$verbs = explode("\n", file_get_contents('verb.list'));

do {
	$adverb_index = rand(0, count($adverbs) - 1);
	$verb_index = rand(0, count($verbs) - 1);
	$adverb = $adverbs[$adverb_index];
	$verb = $verbs[$verb_index];
} while (substr($adverb, -2) !== 'ly' || strpos($verb, '_') || strpos($adverb, '_'));

$new_name = ucwords("${adverb} ${verb}it");

renderView(selectAppropriateView());


// Helper functions

function renderView($view) {
	global $new_name;
	require(__DIR__ . "/views/${view}.php");
	die();
}

function selectAppropriateView() {
	foreach (getSortedMIMEs() as $mimeDescriptior) {
		
		// I am parsing the thing out here instead of in getSortedMIMEs because it saves
		// one loop but it could just be done with an array map in there
		$mime = explode(';', $mimeDescriptior)[0];
		
		// Don't put a default here as it will bypass quality ranking
		switch($mime) {
			case 'application/json':
				return 'json';
			case 'text/plain':
				return 'text';
			case 'text/html':
			case 'application/xhtml+xml':
			case 'application/xml':
				return 'html';
		}
	}
	
	// This is the default view to render if we couldn't find an appropriate one
	return 'html';
}

function getSortedMIMEs() {
	$arr = explode(',', getallheaders()['Accept'] ?? '');
	usort($arr, 'sortMIMEs');
	return $arr;
}

function sortMIMEs($a, $b){
	// sort function doesn't allow non-integer returns
	$val = getQualityValue($b) - getQualityValue($a);
	if($val === 0) {
		return 0;
	}
	return $val / abs($val);
}

function getQualityValue($header) {
	// 1 is the default quality value if none is supplied
	// https://developer.mozilla.org/en-US/docs/Glossary/Quality_values
	return floatval(explode(';q=', $header)[1] ?? 1);
}


?>

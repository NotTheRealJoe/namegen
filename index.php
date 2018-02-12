<?php
$adverbs = explode("\n", file_get_contents("adverb.list"));
$verbs = explode("\n", file_get_contents("verb.list"));

do {
	$adverb_index = rand(0, count($adverbs) - 1);
	$verb_index = rand(0, count($verbs) - 1);
	$adverb = $adverbs[$adverb_index];
	$verb = $verbs[$verb_index];
} while (substr($adverb, -2) !== 'ly' || strpos($verb, '_') || strpos($adverb, '_'));

$new_name = ucwords("$adverb $verb" . "it");
?>
<!DOCTYPE html>
<html>
<body style="text-align: center">
	<h2>Your new name is...</h2>
	<h1><?php echo $new_name; ?></h1>
	<span style="font-size: 0.7em; color: #404040">Copyright &copy; 2018 Joe Tortorello. Uses components from Princeton University WordNet&reg;. <a style="color:inherit" href="http://wordnet.princeton.edu">http://wordnet.princeton.edu</a></span> 
</body>
</html

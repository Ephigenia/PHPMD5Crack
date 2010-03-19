<?php

/**
 * Try to crack an md5 string using a dictionary
 * 
 * usage:
 * ------
 * 	$ php md5_dictionary_crack.php [md5] [dictFilename] [salt]
 * 
 * @author Marcel Eichner // Ephigenia <love@ephigenia.de>
 * @since 2010-01-17
 */

$md5 = @$argv[1];
$filename = @$argv[2];
$salt = @$argv[3];
$startTime = microtime(true);

// parameter tests
if (empty($filename)) {
	die(sprintf("No dictionary file passed.\n"));
} elseif (!file_exists($filename)) {
	die(sprintf("Dictionary file: '%s' not found\n", $filename));
}
if (empty($md5) || strlen($md5) !== 32) {
	die(sprintf("No md5 string passed\n"));
}

// main script
$fp = fopen($filename, 'r');
$i = 0;
while(!feof($fp)) {
	$line = trim(fgets($fp, 64));
	if (md5($line.$salt) == $md5) {
		sprintf("Password found: %s\n", $line);
		break;
	}
	$i++;
}
fclose($fp);

die (sprintf("%d strings tested, operation took %s seconds\n", $i, round(microtime(true) - $startTime), 2));
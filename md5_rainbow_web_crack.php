<?php

/**
 * Try cracking MD5 Hash using web service
 * 
 * Usage:
 * ------
 * 
 * 
 * 
 * 
 * 
 * @author Marcel Eichner // Ephigenia <love@ephigenia.de>
 * @since 2010-03-19
 */

/**
 * Parameter parsing and cleanup
 */
if (!empty($argv[1])) {
	// phpfile hashlist.txt
	if (file_exists($argv[1])) {
		echo "reading hashes from ${argv[1]} …\n";
		$hashes = file_existsle($argv[1]);
	// phpfile hash1 hash2 hash3 hash4
	} else {
		$hashes = array_slice($argv, 1);
	}
} else {
	$hashes = file('php://stdin');
}
$hashes = array_filter(array_map('trim', $hashes));

if (empty($hashes)) {
	die("no hashes passed\n");
}

$results = array(
	'notfound' => 0,
	'found' => 0,
);

// iterator over hashes
foreach($hashes as $index => $hash) {
	// check if csv file
	if ($fields = str_getcsv($hash, ';')) {
		// find hash
		$hash = $fields[count($fields)-1];
	}
	if (count($fields) > 1) {
		echo "Trying hash: ".implode(', ', $fields)." … ";
	} else {
		echo "Trying hash: '${hash}' … ";
	}
	// use curl to send request to md5crack
	$curl = curl_init('http://md5crack.com/crackmd5.php');
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POSTFIELDS => array(
			'term' => $hash,
			'crackbtn' => true,
		),
	));
	// search for result string
	if (preg_match('@Found:\s+md5\("(?P<source>.+)"\)\s=\s+([a-z0-9]+)@mi', curl_exec($curl), $found)) {
		echo "'${found['source']}'\n";
		$results['found']++;
	} else {
		echo "not found\n";
		$results['notfound']++;
	}
}

// print report
echo "found ${results['found']}/$index found (${results['notfound']} not found)\n";
echo "done!\n";
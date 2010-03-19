<?php

/**
 * Try cracking MD5 Hash using web service
 * @author Marcel Eichner // Ephigenia <love@ephigenia.de>
 * @since 2010-03-19
 */

require dirname(__FILE__).'/lib/Console.php';

/**
 * @package PHPMD5Crack
 * @since 2010-03-19
 * @author Marcel Eichner // Ephigenia <love@ephigenia.de>
 */
class MD5RainbowWebCrackConsole extends Console
{
	protected $hashes = array();
	
	public function init()
	{
		if (!empty($this->argv[1])) {
			// phpfile hashlist.txt
			if (file_exists($argv[1])) {
				$this->hashes = file($this->argv[1]);
			// phpfile hash1 hash2 hash3 hash4
			} else {
				$this->hashes = array_slice($this->argv, 1);
			}
		} else {
			$this->hashes = file('php://stdin');
		}
		$this->hashes = array_filter(array_map('trim', $this->hashes));
		// check if hashes set or any left
		if (empty($this->hashes)) {
			$this->error('no hashes found');
			$this->quit();
		}
		return true;
	}
	
	public function main()
	{
		// load CURL class
		require dirname(__FILE__).'/lib/CURL.php';
		// iterator over hashes
		foreach($this->hashes as $index => $hash) {
			// check if csv line data
			$fields = str_getcsv($hash, ';');
			if (count($fields) > 1) {
				$this->out('Trying hash: '.implode(', ', $fields).' … ', false);
				$hash = $fields[count($fields)-1];
			} else {
				$this->out('Trying hash: '.$hash.' … ', false);
			}
			// use curl to send request to md5crack
			$CURL = new CURL('http://md5crack.com/crackmd5.php', array(
				CURLOPT_POSTFIELDS => array(
					'term' => $hash,
					'crackbtn' => true,
				),
			));
			// search for result string
			if (preg_match('@Found:\s+md5\("(?P<source>.+)"\)\s=\s+([a-z0-9]+)@mi', $CURL->read(), $found)) {
				$this->out($found['source']);
			} else {
				$this->out('not found');
			}
		}
		$this->quit('done!');
	}
}

$console = new MD5RainbowWebCrackConsole();
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

require dirname(__FILE__).'/lib/Console.php';

class MD5DictCrackConsole extends Console
{
	protected $md5;
	protected $filename;
	protected $salt;
	
	public function init()
	{
		$this->md5 = @$this->args[1];
		$this->filename = @$this->args[2];
		$this->salt = @$this->args[3];
		if (empty($this->filename)) {
			$this->error('No Dictionary File passed!');
			$this->quit();
		} elseif (!file_exists($this->filename)) {
			$this->error('File not found: '.$this->filename);
			$this->quit();
		} elseif (!is_readable($this->filename)) {
			$this->error('Dictionary file is not readable to me: '.$this->filename);
			$this->quit();
		}
		if (empty($this->md5) || strlen($this->md5) != 32) {
			$this->error('MD5 not valid!');
			$this->quit();
		}
		return true;
	}
	
	public function main()
	{
		$this->out('Try cracking md5 hash: '.$this->md5);
		$fp = fopen($this->filename, 'r');
		$i = 1;
		while(!feof($fp)) {
			$line = trim(fgets($fp, 256));
			if ($i > 0 && $i % 10000 == 0) {
				if ($i % 100000 == 0) {
					$this->out(' '.$i.' tried');
				} else {
					$this->out('.', false);
				}
			}
			if (md5($line.$this->salt) == $this->md5) {
				$this->out('Password found: '.$line);
				break;
			}
			$i++;
		}
		fclose($fp);
		$this->out('done!');
	}
}

$console = new MD5DictCrackConsole();
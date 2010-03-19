<?php

/**
 * Simple Console Wrapper Class
 * 
 * @author Marcel Eichner // Ephigenia <love@ephigenia.de>
 * @since 2010-03-19
 * @package PHPMD5Crack
 * @subpackage PHPMD5Crack.lib.console
 */
class Console
{
	protected $argv = array();
	
	public function __construct()
	{
		global $argv;
		$this->args = $argv;
		$this->init();
		while($this->main()) {}
		$this->quit();
	}
	
	protected function init()
	{
		return true;
	}
	
	protected function main()
	{
		return true;
	}
	
	protected function quit($message = null)
	{
		$this->out($message);
		exit;
	}
	
	/**
	 * Halts PHP waiting for Enter to be pressed and returns the characters
	 * @param string $message
	 * @param integer $bufferSize Size of the read buffer
	 * @return string
	 */
	protected function read($message = null, $bufferSize = 2048)
	{
		if ($message !== null) {
			$this->out($message);
		}
		$string = '';
		while($string == '') {
			$string .= fgets(STDIN, $bufferSize);
		}
		return $string;
	}

	/**
	 * Pauses execution until enter is pressed
	 * @return string String entered till Enter was pressed
	 */
	protected function pause()
	{
		return $this->read();
	}
	
	/**
	 * Write the passed $message to the standard error output
	 * @param string $str
	 * @return Console
	 */
	protected function error($str) 
	{
		fputs(STDERR, $str);
		return $this;
	}
	
	/**
	 * Write $string to standard output
	 * @param string $str
	 * @return Console
	 */
	protected function out($str, $newline = true) 
	{
		if (empty($str)) return false;
		if ($newline) $str .= "\n";
		fputs(STDOUT, $str);
		return $this;
	}
}
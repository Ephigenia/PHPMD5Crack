<?php

/**
 * Simple PHP CURL Wrapper
 * 
 * @package PHPMD5Crack
 * @subpackage PHPMD5Crack.lib.console
 * @author Marcel Eichner // Ephigenia <love@ephigenia.de>
 * @since 2010-03-19
 */
class CURL
{
	private $handle;
	
	public function __construct($url = null, $params = array())
	{
		$this->handle = curl_init($url);
		$this->params($params);
		return $this;
	}
	
	public function params(Array $params = array())
	{
		curl_setopt_array($this->handle, $params);
		return $this;
	}
	
	public function set($option, $value)
	{
		curl_setopt($this->handle, $option, $value);
		return $this;
	}
	
	public function read()
	{
		$this->set(CURLOPT_RETURNTRANSFER, true);
		return curl_exec($this->handle);
	}
}
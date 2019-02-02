<?php 
namespace RainSunshineCloud;
Trait Source 
{

	protected  	$stream_file_func = [];
	protected   $source = null;

	/**
	 * [filePath description]
	 * @param  [type] $file_path [description]
	 * @return [type]            [description]
	 */
	public function file($file_path)
	{
		$this->source = fopen($file_path,'rb');
		return $this;
	}

	/**
	 * 资源流
	 * @return [type] [description]
	 */
	public function source($source)
	{
		$this->source = $source;
		return $this;
	}

	/**
	 * 字符串
	 * @param  [type]  $string [description]
	 * @param  integer $int    [description]
	 * @return [type]          [description]
	 */
	public function string($string ,$int = 1024)
	{
		$this->source = fopen('php://temp','w');
		$res = fwrite ($this->source,$string,$int);
		rewind($this->source);
		return $this;
	}

	public function getLine ($sept = "\r\n")
	{
		while(!feof($this->source)) {
			yield stream_get_line($this->source,200,$sept);
		}

		yield '';
	}

}


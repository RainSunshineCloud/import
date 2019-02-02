<?php 
namespace RainSunshineCloud;
Trait Source 
{
	protected $source = null;
	protected $line_set = ["\r\n",1024];

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

	public function getLine ()
	{
		while(!feof($this->source)) {
			yield stream_get_line($this->source,$this->line_set[1],$this->line_set[0]);
		}

		yield '';
	}

	/**
	 * 设置行分隔符符和最大取值数量
	 * @param [type]  $sept     [description]
	 * @param integer $max_size [description]
	 */
	public function setSept($sept,$max_size = 1024)
	{
		$this->line_set = [$sept,$max_size];
		return $this;
	}



}


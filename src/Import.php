<?php 
namespace RainSunshineCloud;

use RainSunshineCloud\Source;

class Import
{
	use Source;

	private $content_arr = [];
	private $total_line = 0;
	private $out_num_limit = 100;
	private $out_func = [];
	private $middle = [];
	private $notify = null;

	public function __construct()
	{
		$this->notify = new Notify();
	}

	/**
	 * 添加中间件
	 * @param [type] $func  [description]
	 * @param [type] $class [description]
	 */
	public function addMiddle ($func, $class = null) 
	{
		if ($func instanceof Closure) {
			array_push($this->middle,$func);
		} else if (is_string($func) && !empty($func) && function_exists($func)) {
			array_push($this->middle,$func);
		} else if ($class && class_exists($class) && method_exists($class,$func)) {
			array_push($this->middle,function ($reduce_val,$funcs) use ($class,$func) {
				return call_user_func([$class,$func],$reduce_val,$funcs);
			});
		} else {
			$this->notify->error('未有该函数或方法');
		}
		
		return $this;
	}

	/**
	 * 添加出口
	 * @param  [type] $func  [description]
	 * @param  [type] $class [description]
	 * @return [type]        [description]
	 */
	public function addOut ($func, $class = null) 
	{
		if ($func instanceof Closure) {
			array_push($this->out_func,$func);
		} else if (is_string($func) && !empty($func) && function_exists($func)) {
			array_push($this->out_func,$func);
		} else if ($class && class_exists($class) && method_exists($class,$func)) {
			array_push($this->out_func,function ($reduce_val,$funcs) use ($class,$func) {
				return call_user_func([$class,$func],$reduce_val,$funcs);
			});
		} else {
			$this->notify->error('未有该函数或方法');
		}
		
		return $this;
	}

	/**
	 * 输出
	 * @return [type] [description]
	 */
	public function out()
	{

		foreach ($this->getLine() as $content) {
			
			//中间件
			if ($content != '') {
				$this->total_line += 1;
				$this->notify->setTotalLine();
				$this->notify->setLastContent($content);
				$content = array_reduce($this->middle,function ($reduce_val,$func) {
	
					return $func ($reduce_val,$this->notify);
				},$content);
				array_push($this->content_arr,$content);
			}

			//最终输出
			if (($this->total_line >= $this->out_num_limit || $content == '') && !empty($this->content_arr)) {
				foreach ($this->out_func as $v) {
					$v($this->content_arr,$this->notify);
				}
				$this->notify->setImportedLastContent();
				$this->notify->setImportedLine($this->total_line);
				$this->total_line = 0;
				$this->content_arr = [];
			}
		}

		$this->notify->success('ok');
	}

	/**
	 * 限制每次导入的行数
	 * @return [type] [description]
	 */
	public function limit (int $limit) 
	{
		if ($limit <= 0) {
			$this->notify->error('必须是大于0的整数');
		}
		$this->out_num_limit= $limit;
		return $this;
	}
}



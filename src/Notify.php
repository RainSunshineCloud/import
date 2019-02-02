<?php 
namespace RainSunshineCloud;

class Notify
{
	//总条数
	protected $total_line = 0;
	//导入的最后一条
	protected $last_line_content = '';
	//已导入的条数
	protected $already_import_line = 0;
	//最后一条已导入的行数
	protected $last_import_line_content = '';

	/**
	 * 信息
	 * @param  [type] $msg [description]
	 * @return [type]      [description]
	 */
	public function info($msg)
	{
		echo $msg;
	}

	/**
	 * 成功
	 * @param  [type] $msg [description]
	 * @return [type]      [description]
	 */
	public function success($msg)
	{
		echo $msg;
	}

	/**
	 * 失败
	 * @param  [type] $msg [description]
	 * @return [type]      [description]
	 */
	public function error($msg)
	{
		throw new ImportException($msg);
	}

	/**
	 * 总行数
	 * @param [type] $num [description]
	 */
	public function setTotalLine() 
	{
		$this->total_line += 1;
	}

	/**
	 * 最后一条的内容
	 * @param [type] $content [description]
	 */
	public function setLastContent($content)
	{
		$this->last_line_content = $content;
	}

	/**
	 * 最后一条已导入的内容
	 * @param [type] $content [description]
	 */
	public function setImportedLastContent()
	{
		$this->last_import_line_content = $this->last_line_content;
	}

	/**
	 * 总行数
	 * @param [type] $num [description]
	 */
	public function setImportedLine($num) 
	{
		$this->already_import_line += $num;
	}

	public function __get($val)
	{
		if (property_exists($this,$val)) {
			return $this->{$val};
		}
		throw new ImportException('属性不存在');
	}

}

class ImportException extends \Exception {}
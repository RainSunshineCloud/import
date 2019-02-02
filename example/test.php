<?php 
include '../../autoload.php';

use RainSunshineCloud\Import;

try{
	$import = new Import();
	$import->file('./1.csv')->limit(4)->addMiddle('explodeH','Middle')->addOut('out','Middle')->addOut('out2','Middle')->out();
} catch (RainSunshineCloud\ImportException $e) {
	var_dump($e->getMessage());
}


/**
 * 中间件
 */
class Middle 
{
	public static function explodeH ($val,$notify) 
	{
		return explode(',',$val);
	}

	/**
	 * 输出
	 * @param  [type] $content [description]
	 * @param  [type] $notify  [description]
	 * @return [type]          [description]
	 */
	public static function out($content,$notify) 
	{
		var_dump($content);
		echo '<br>';
	}

	public static function out2($content,$notify) 
	{
		var_dump($content);
		echo '<br>';
	}
}
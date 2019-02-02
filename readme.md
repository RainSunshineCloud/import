### 这是一个导入的调度类
#### 文件说明
- source是资源来源的trait，其中string 采用temp缓存
- Import是调度类
- Notify是通知类

#### 使用方法
```
<?php 

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
     * 输出1
     * @param  [type] $content [description]
     * @param  [type] $notify  [description]
     * @return [type]          [description]
     */
    public static function out($content,$notify) 
    {
        var_dump($content);
        echo '<br>';
    }

    /**
     * 输出2
     * @param  [type] $content [description]
     * @param  [type] $notify  [description]
     * @return [type]          [description]
     */
    public static function out2($content,$notify) 
    {
        var_dump($content);
        echo '<br>';
    }
}
```
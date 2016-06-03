<?php
namespace App\Services;

use Log;
use App\Models\ErrorLog;

/**
 * 记录到数据库表中的错误日志操作类
 */
class DBLog
{

    /**
     * 记录告警级别日志
     * @param $content 日志内容
     */
    public function warn($content)
    {
        return $this->writeLog(0, $content);
    }

    /**
     * 记录错误级别日志
     * @param $content 日志内容
     */
    public function error($content)
    {
        return $this->writeLog(1, $content);
    }

    /**
     * 记录严重级别日志
     * @param $content 日志内容
     */
    public function fatal($content)
    {
        return $this->writeLog(2, $content);
    }

    /**
     * 邮箱地址打码
     * @param $level 日志级别：0-WARN; 1-ERROR; 2-FATAL
     * @param $content 日志内容
     */
    protected function writeLog($level, $content)
    {
        try {
            $log = new ErrorLog;
            $log->level = $level;
            $log->content = $content;
            $log->save();
        } catch (\Exception $e) {
            Log::error('Write db error: '.$e);
        }
    }
    
}

?>
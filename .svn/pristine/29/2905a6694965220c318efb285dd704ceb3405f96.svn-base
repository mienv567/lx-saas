<?php
namespace App\Services;

/**
 * 通用工具服务类
 */
class CommonUtils
{

    /**
     * 手机号码打码
     * @param $phone 手机号码
     * @return 打码后的手机号码
     */
    public function maskPhone($phone)
    {
        return $this->maskMiddleChar($phone);
    }

    /**
     * 邮箱地址打码
     * @param $email 邮箱地址
     * @return 打码后的邮箱地址
     */
    public function maskEmail($email)
    {
        if (empty($email)) return '';
        $pos = strpos($email, '@');
        $name = ($pos === false) ? $email : substr($email, 0, $pos);
        $suffix = ($pos === false) ? '' : substr($email, $pos);
        return $this->maskMiddleChar($name).$suffix;
    }
    
    /**
     * 对字符串中间位置打码
     * @param $str 待打码字符串
     * @return 打码后的字符串
     */
    public function maskMiddleChar($str)
    {
        if (empty($str)) return '';
        $len = strlen($str);
        $start = round($len / 3);
        $end = $start * 2;
        return substr($str, 0, $start).sprintf("%'*".($end-$start)."s", "").substr($str, $end);
    }

    /**
     * 打码整个字符串
     * @param $str 待打码字符串
     * @return 打码后的字符串
     */
    public function maskAllChar($str)
    {
        if (empty($str)) return '';
        $len = strlen($str);
        return sprintf("%'*".($len)."s", "");
    }
    
    /**
     * 根据给定文件路径或文件名获取文件后缀
     * @param string $file 文件路径或文件名
     * @return 文件后缀
     */
    public function getFileExt($file)
    {
        if (empty($file)) {
            return '';
        } else {
            $pos = strrpos($file, '.');
            return ($pos === false) ? '' : substr($file, strrpos($file, '.') + 1);
        }
    }

    /**
     * curl 请求
     * @param $url 请求地址
     * @param $curlPost 请求参数
     * @return 结果返回
     */

    public function curlRequest($url,$curlPost){
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url );
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt ($ch, CURLOPT_POST, 1 ); //启用POST提交
        curl_setopt ($ch, CURLOPT_POSTFIELDS,$curlPost);
        $result = curl_exec ($ch);
        curl_close($ch);
        return $result;
    }

    
}

?>
<?php
if (!function_exists('ding')) {
    function ding($msg, $id = 7)
    {
        if (is_string($msg)) {
            $message = $msg;
        } else {
            $message = var_export($msg, true);
        }
        if (empty($message)) {
            return false;
        }
        if ($id == 7) {
            $id = mt_rand(1, 5);
        }
        switch ($id) {
            case 1:
                $webhook = "https://oapi.dingtalk.com/robot/send?access_token=b1e83fa0c0b3e1252375064b0d9fc3cd2e35aa28821642cd23a41429ed9a5f16";
                break;
            case 2:
                $webhook = "https://oapi.dingtalk.com/robot/send?access_token=37e4a6a2949e3f6becb09c063ea51def5d579f003a7533b477b1d332615817e1";
                break;
            case 3:
                $webhook = "https://oapi.dingtalk.com/robot/send?access_token=7a8df195f8decfde24a1478dc7ac486c54825cf4f409c7bb1f4d4f4eac617648";
                break;
            case 4:
                $webhook = "https://oapi.dingtalk.com/robot/send?access_token=3d313b569015d5d9addc22503c466dae45fa7bfc2fded3cf4f5573e684f36ee1";
                break;
            case 5:
                $webhook = "https://oapi.dingtalk.com/robot/send?access_token=6c3cba8aca89d246214354513aa4d473b610532e3bc151edd5052b3ca8134627";
                break;
            default:
                $webhook = "https://oapi.dingtalk.com/robot/send?access_token=b1e83fa0c0b3e1252375064b0d9fc3cd2e35aa28821642cd23a41429ed9a5f16";
        }
        //$webhook = 'https://oapi.dingtalk.com/robot/send?access_token=b1e83fa0c0b3e1252375064b0d9fc3cd2e35aa28821642cd23a41429ed9a5f16';
        $data = array('msgtype' => 'text', 'text' => array('content' => '调试:' . PHP_EOL . $message), 'at' => array('isAtAll' => false));
        $data_string = json_encode($data);
        $result = request_by_curl($webhook, $data_string);
        return $result;
    }
}

if (!function_exists('dd')) {
    /**
     * 浏览器友好的变量输出,并结束程序
     * @param   mixed $var 变量
     * @return  null|string
     */
    function dd($var)
    {
        dump($var);
        die();
    }
}

if (!function_exists('request_by_curl')) {
    //全局函数ding依赖的函数
    function request_by_curl($remote_server, $post_string)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
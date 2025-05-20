<?php
namespace Org\Util;

class sendSMS{
    static  private $username = '70203902';

    public  static function send($phone,$content,$time='',$sid='2047'){
        $http = 'http://sms.2office.net/WebService/services/SmsService?wsdl';
        $data = array
        (
            'account'=>"2520738",
            'pwd_custom'=>"ranshine",
            'pwd_secret'=>"d7f21d3c413fd6babe0deb2b102cb069",
            'channel'=>"252073838",
            'password'=>md5("ranshined7f21d3c413fd6babe0deb2b102cb069"),
            'mobile'=>$phone,
            'content'=>$content,
            'smsid'=>microtime(true)*100, 'sendType'=>'1',
//            'time'=>$time,
//            'encode'=>'GBK'
//            'account'=>"2520738",
        );

//        require("/SmsPusher/Source/NuSoap.php");
//        require(dirname(__FILE__)."/SmsPusher/Source/NuSoap.php");
//        $kk = new NuSoap();

//        $header = new SoapHeader('http://tempuri.org/','SecurityHeader',$data);
//        $client=new SoapClient('http://116.228.55.12/app26GS/MaintainService.asmx?wsdl');
////        $this->client=new SoapClient('http://61.191.40.114/SSAGClient/MaintainService.asmx?wsdl');
//        $client->__setSoapHeaders($header);
//
//        var_dump(new nusoap_client($http,true));
//        exit;
//        var_dump(vendor("NuSoap"));
        $kk=new nusoap_client($http,true);

        $client = $kk->nusoap_client($http,true);
        $kk->decode_utf8 = false;
        $kk->soap_defencoding = 'UTF-8';
        $kk->xml_encoding = 'GBK';
        $err = $kk->getError();
        if ($err)
        {
            echo 'no2_office_soap: constructor error ' . $err;
            return $err;
        }

        if (isset($_REQUEST['isdebug']))
        {
            var_dump($data);
        }
        $result = $kk->call('SendSms3', array('parameters' => $data), '', '', false, true,'document','encoded');
        var_dump($result);
        var_dump($client);
        if (isset($_REQUEST['isdebug']))
        {
            var_dump($data);
        }
        return $result['out'];
        //return mb_convert_encoding($result['out'], "GBK", "UTF-8");
//    }
//catch (Exception $e)
//{
//var_dump ($e);
//return "exception";
//}

//        dump($data);
//        if(!$data['time']){
//            unset($data['time']);
//        }
//        $re= self::postSMS($http,$data);
////        return $re;
//        $re = (array)simplexml_load_string($re);
//        dump($re);
//        if($re["@attributes"]["result"]==1)
//        {
//            return true;
//        }
//        else
//        {
//            return false;
//        }
    }

    // Xml 转 数组, 包括根键
    public  static  function xml_to_array( $xml )
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches))
        {
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++)
            {
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml ))
                {
                    $arr[$key] = xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    private static function postSMS($http,$data){
        $post='';
        $row = parse_url($http);
        $host = $row['host'];
        $port = !empty($row['port']) ? $row['port']:80;
        $file = $row['path'];
        while (list($k,$v) = each($data))
        {
            $post .= rawurlencode($k)."=".rawurlencode($v)."&";
        }
        $post = substr( $post , 0 , -1 );
        $len = strlen($post);
        $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.0\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp)) {
                $receive .= fgets($fp, 128);
            }
            $receive = explode("\r\n\r\n",$receive);
//            dump($receive);
            unset($receive[0]);
            return implode("",$receive);
        }
    }
}
?>
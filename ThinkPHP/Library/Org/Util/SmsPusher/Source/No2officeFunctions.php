<?php

function sms_of_no2_office__send ($mobile, $content, $smsid, $sign)
{
	try
	{
		if (!strpos($content,'【'))
			$content = $content.'【'.$sign.'】';

		$cfg = libsmsGetConfigOfNo2officeAppid();
		if (!isset($cfg['account']) || !isset($cfg['soap_uri_to_send']))
		{
			echo 'cfg_is_null';
			return "cfg_is_null";
		}

		if (!$smsid)
			 $smsid = microtime(true)*100;
		$password = md5($cfg['pwd_custom'].$cfg['pwd_secret']);
		$param = array('account'=>$cfg['account'], 'password'=>$password, 'mobile'=>$mobile, 'content'=>$content, 'channel'=>$cfg['channel'], 'smsid'=>$smsid, 'sendType'=>'1');

		$client = new nusoap_client($cfg['soap_uri_to_send'],true);
		$client->decode_utf8 = false;
		$client->soap_defencoding = 'UTF-8';
		$client->xml_encoding = 'GBK';
		$err = $client->getError();
		if ($err)
		{
			echo 'no2_office_soap: constructor error ' . $err;
			return $err; 
		}

		if (isset($_REQUEST['isdebug']))
		{
			var_dump($param);
		}
		$result = $client->call('SendSms3', array('parameters' => $param), '', '', false, true,'document','encoded');
		if (isset($_REQUEST['isdebug']))
		{
			var_dump($result);
		}
		return $result['out'];
		//return mb_convert_encoding($result['out'], "GBK", "UTF-8");
	}
	catch (Exception $e)
	{
		var_dump ($e);
		return "exception"; 
	}
}

function sms_of_no2_office__query_blance ()
{
	try
	{
		$cfg = SmsGetConfigOfNo2officeAppid();
		if (!isset($cfg['account']) || !isset($cfg['soap_uri_to_query_balance']))
		{
			echo 'cfg_is_null';
			return "cfg_is_null";
		}

		$client = new nusoap_client($cfg['soap_uri_to_query_balance'],true);
		$client->decode_utf8 = false;
		$client->soap_defencoding = 'GBK';
		$client->xml_encoding = 'GBK';
		$err = $client->getError();
		if ($err)
		{
			echo 'no2_office_soap: constructor error</h2><pre>' . $err . '</pre>';
			return ""; 
		}

		$password = md5($cfg['pwd_custom'].$cfg['pwd_secret']);
		$param = array('in0'=>$cfg['account'], 'in1'=>$password);
		$result = $client->call('GetSmsMoney2', array('parameters' => $param), '', '', false, true,'document','encoded');
		if (isset($_REQUEST['isdebug']))
		{
			echo ("<br/>soap call: ");
			var_dump($result);
		}
		return mb_convert_encoding($result['out'], "GBK", "UTF-8");
	}
	catch (Exception $e)
	{
		var_dump ($e);
		return ""; 
	}
}


?>

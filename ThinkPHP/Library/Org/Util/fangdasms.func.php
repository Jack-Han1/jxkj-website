<?php

/**
 * [WEIZAN System] Copyright (c) 2014 wdlcms.com
 * WEIZAN is NOT a free software, it under the license terms, visited http://www.wdlcms.com/ for more details.
 */
//defined ( 'IN_IA' ) or exit ( 'Access Denied' );
require_once THINK_PATH . "/Library/Org/Util/sms/nusoap.php";


function sms_send($mobile = '', $content = '', $signature = '', $check = true) {
	global $_W;
	
	$setting = setting_load ( 'sms' );
	$smsconfig = array (
			"balance" => 0,
			"signature" => $_W ['setting'] ['sitename'] 
	);
	$row = pdo_fetch ( "SELECT `notify` FROM " . tablename ( 'uni_settings' ) . " WHERE uniacid = :uniacid", array (
			':uniacid' => $_W ['uniacid'] 
	) );
	$row ['notify'] = @iunserializer ( $row ['notify'] );
	if (! empty ( $row ['notify'] ) && ! empty ( $row ['notify'] ['sms'] )) {
		$smsconfig = $row ['notify'] ['sms'];
	}
	if ($check) {
		if (intval ( $smsconfig ['balance'] ) <= 0) {
			return error ( 1, "短信条数不足，请联系客服人员" );
		}
	}
	if (empty ( $signature )) {
		$signature = $smsconfig ['signature'];
	}
	
	$smsmoney=floatval(sms_of_no2_office__query_blance());
	if($smsmoney<=0.5)
	{
		return error ( 1, "短信余额不足，请联系客服人员" );
	}
	
	
	
	$code=rand(100000,999999);
	$content = "【" . $signature . "】" . "您的验证码是：".$code."，请尽快完成验证。";
	
	
	$sql="select count(0) as count from ims_uni_verifycode where (createtime  BETWEEN  ".(time()-3600)." and  ".time()." ) and uniacid=".$_W ['uniacid']." and receiver='".$mobile."' and isuse=1 ";
	$counts=pdo_fetch($sql,array());
	$count=$counts['count'];
	
	if($count>=5)
	{
		return error ( 1, "多次下发，如无法接收短信请更换手机号码" );
	}

	
	$sendret=sms_of_no2_office__send($mobile,$content);
	
	pdo_insert ('uni_verifycode',array('uniacid'=>$_W ['uniacid'],'receiver'=>$mobile,'verifycode'=>$code,'total'=>1,'createtime'=>time()));
	$insid=pdo_insertid();
	
	if (empty ( $insid )) {
		$row ['notify'] ['sms'] ['balance'] = intval ( $row ['notify'] ['sms'] ['balance'] ) - 1;
		pdo_update ( 'uni_settings', array (
				'notify' => iserializer ( $row ['notify'] )
		), array (
				'uniacid' => $_W ['uniacid']
		) );
		return true;
	} 	
	return error ( 200, "发送成功" );
}




function sms_of_no2_office__send ($mobile, $content)
{
	$mgr_uri = "http://www.2office.net";
	$account = "2520738"; //厂家亦称之为门牌号
	$pwd_custom = "ranshine"; //厂家系统中的登陆码
	$pwd_secret = "d7f21d3c413fd6babe0deb2b102cb069"; //厂家亦称之为授权码
	$channel = "252073838";
	$uri = "http://sms.2office.net/WebService/services/SmsService?wsdl";

	try
	{
		$client = new nusoap_client($uri,true);
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		$client->xml_encoding = 'UTF-8';
		$err = $client->getError();
		if ($err)
		{			
			return "1";
		}
		$smsid = microtime(true)*100;
		$password = md5($pwd_custom.$pwd_secret);
		$param = array('account'=>$account,'password'=>$password,'mobile'=>$mobile,'content'=>$content,'channel'=>$channel,'smsid'=>$smsid,'sendType'=>'1');
		$result = $client->call('SendSms3', array('parameters' => $param), '', '', false, true,'document','encoded');
//        var_dump($result);
		return $result;
		
	}
	catch (Exception $e)
	{		
		return "2";
	}
}


function sms_of_no2_office__query_blance ()
{
	$mgr_uri = "http://www.2office.net";
	$account = "2520738"; //厂家亦称之为门牌号
	$pwd_custom = "ranshine"; //厂家系统中的登陆码
	$pwd_secret = "d7f21d3c413fd6babe0deb2b102cb069"; //厂家亦称之为授权码
	$channel = "252073838";
	$uri = "http://sms.2office.net/WebService/services/SmsService?wsdl";

	try
	{		
		$client = new nusoap_client($uri,true);
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;
		$client->xml_encoding = 'UTF-8';
		$err = $client->getError();
		if ($err)
		{
			echo 'no2_office_soap: constructor error</h2><pre>' . $err . '</pre>';
			return "";
		}

		$password = md5($pwd_custom.$pwd_secret);
		$param = array('in0'=>$account, 'in1'=>$password);
		$result = $client->call('GetSmsMoney2', array('parameters' => $param), '', '', false, true,'document','encoded');
		
		return mb_convert_encoding($result['out'], "GBK", "UTF-8");
	}
	catch (Exception $e)
	{		
		return "";
	}
}




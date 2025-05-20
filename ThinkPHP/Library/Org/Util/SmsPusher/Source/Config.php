<?php

// some limits 
function libsmsGetConfigOfPushLimit()
{
	$cfg['ui_disable_push'] = 60;          //两次连续下发的最短时间间隔(仅仅指页面上动画效果，后台逻辑中因为已经设置了‘time_disable_new’，所以不再做限制)
	$cfg['time_disable_new'] = 1800;       //若干时间内不允许重新生成验证码
	$cfg['timeout'] = 12*3600;             //验证码超时
	$cfg['push_per_day'] = 5;              //单个号码一天最多下发几条短信
	if ($cfg['time_disable_new'] >= $cfg['timeout'])
		$cfg['time_disable_new']  = $cfg['timeout'];
	return $cfg;
}

// no2office Appid
function libsmsGetConfigOfNo2officeAppid()
{
	$cfg['mgr_uri'] = "http://www.2office.net";
	$cfg['account'] = "2520738"; //厂家亦称之为门牌号
	$cfg['pwd_custom'] = "ranshine"; //厂家系统中的登陆码
	$cfg['pwd_secret'] = "d7f21d3c413fd6babe0deb2b102cb069"; //厂家亦称之为授权码
	$cfg['channel'] = "252073838";

	$cfg['soap_uri_to_send'] = "http://sms.2office.net/WebService/services/SmsService?wsdl";
	$cfg['soap_uri_to_query_balance'] = "http://sms.2office.net/WebService/services/SmsService?wsdl";

	$cfg['logfile_path'] = "d:/panr/wenhua/svn_base/source/Base/system/libraries/SmsPusher/LogsOfSms";
	return $cfg;
}


// sms-templates registed at no2office system. 
function libsmsBuildArguments($mobile, $busytag, $action, $verifycode, $dat001,$dat002,$dat003)
{
	if ($action == 'debug')
	{
		$txt = "您的验证码是D0PNSWTL，xxxx优惠券aaaa".date('Y-m-d H:i:s');
	}
	else if ($action == 'change_attr_mobile')
	{
		$txt = "您的验证码是".$verifycode."，请在30分钟内使用，勿告知他人".date('Y-m-d H:i:s');
	}
	else
	{
		$txt = false;
	}

	//var_dump($action);
	if (!$txt)
		return false;
	return array('txt'=>$txt, 'template_id'=>false, 'busytag'=>$busytag, 'action'=>$action, 'verifycode'=>$verifycode);
}





?>

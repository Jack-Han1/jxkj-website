<?php
//
// 最后修改时间: 20150817.1330
// 最后修改人员: panr
// 调用参考范例: SmsPusherLib.php
//
///////////////////
//
// 下发验证码
// libsmsVerifycodePush($mobile, $busytag,$action,$verifycode, $db_mysqli)
//	参数
//    $mobile 接受人手机号
//	  $busytag 业务名称。当前备案业务包括网购宝,聚优惠,优生活
//	  $action 如regist_by_mobile, edit_attr_mobile, reset_password, 
//	  $verifycode 验证码内容
//	  $db_mysqli 日志数据库
//	返回值
//	  'well', 成功
//	  'CountOfDay', 管理员设置了单号码每日下发短信数量，由于该限制而下发失败
//	  'unknown_mobile', 无效的手机号码
//	  'unknown_db', 无效的数据库
//	  'unknown_act', 无效的$busytag,$action,$verifycode
//	  false, 其它原因导致下发失败
//	  [其它值], 其它原因导致下发失败
//
// libsmsVerifycodeCheck($mobile, $busytag,$action,$verifycode, $db_mysqli)
//	参数
//    $mobile 接受人手机号
//	  $busytag 业务名称。当前备案业务包括网购宝,聚优惠,优生活
//	  $action 如regist_by_mobile, edit_attr_mobile, reset_password, 
//	  $verifycode 验证码内容
//	  $db_mysqli 日志数据库
//	返回值
//	  'well', 成功
//	  'timeout', 验证码是正确的，但已过了有效期
//	  false, 其它原因导致下发失败
//	  [其它值], 其它原因导致下发失败
//	
//	
//
// 直接下发短信。//该方法为不记日志的接口功能测试方法，若在控制器使用须自行调用libsmsDbAddLogSms/libsmsDbAddLogSys添加日志
// libsmsSmsPush($mobile, $content,$smsid, $busytag)
//	参数
//    $mobile 接受人手机号
//	  $content 下发短信文本
//	  $smsid 保留
//	  $busytag 业务名称。当前备案业务包括网购宝,聚优惠,优生活
//	返回值不可用
//
//

include(dirname(__FILE__)."/Source/NuSoap.php");

include(dirname(__FILE__)."/Source/Config.php");
include(dirname(__FILE__)."/Source/DbWorks.php");
include(dirname(__FILE__)."/Source/No2officeFunctions.php");
//var_dump(include(dirname(__FILE__)."/Source/No2officeFunctions.php"));
//exit;
function libsmsVerifycodeNew($busytag, $action, $mobile, $db_mysqli)
{
	$verifycode = libsmsDbVerifyNew($busytag, $action, $mobile, $db_mysqli, false);
	if (strlen($verifycode) < 3)
		return false;
	return $verifycode;
}

function libsmsVerifycodePush ($mobile, $verifycode, $busytag,$action, $db_mysqli)
{
	$contents = libsmsBuildArguments($mobile, $busytag,$action,$verifycode,false,false,false);
	if (!$contents)
		return 'unknown_act';

	$limit = libsmsGetConfigOfPushLimit();
	$last = libsmsDbCore_LoadLastVerify($busytag, $action, $mobile, $db_mysqli);
	$CountOfDay = libsmsDbCore_LoadPushcountOfDay($busytag, $action, $mobile, $db_mysqli);
	$is_repeat = isset($last['id']) && isset($last['verifycode']) && $last['verifycode']==$verifycode;
	//var_dump($CountOfDay);
	//var_dump($limit['push_per_day']);
	//var_dump($CountOfDay >= $limit['push_per_day']);
	if ((0+$CountOfDay) >= $limit['push_per_day'])
	{
		libsmsDbAddLogSms ('verifycode.'.$action.'.push.CountOfDay', $mobile, $contents, $db_mysqli);
		libsmsDbAddLogSys ('verifycode.'.$action.'.push.CountOfDay', $mobile, $contents, $db_mysqli);
		return 'CountOfDay';
	}
	else if ($is_repeat)
	{
		libsmsDbCore_NotifyPushMore('msg_content', $last['id'], $db_mysqli);
	}
	else
	{
		if (!libsmsDbVerifyStart ($mobile, $contents, $db_mysqli))
		{
			libsmsDbAddLogSms ('verifycode.'.$action.'.push.fail', $mobile, $contents, $db_mysqli);
			libsmsDbAddLogSys ('verifycode.'.$action.'.push.fail', $mobile, $contents, $db_mysqli);
			return false;
		}
	}


	$push_rets = '0,被panr拦截了就当作是成功吧';
	$push_rets = sms_of_no2_office__send($mobile, $contents['txt'], $contents['template_id'], $busytag);
	//var_dump($push_rets);
	if (!$push_rets)
		return false;

	$contents['arg1'] = $push_rets;
	libsmsDbAddLogSms ('verifycode.'.$action.'.push.well', $mobile, $contents, $db_mysqli);
	libsmsDbAddLogSys ('verifycode.'.$action.'.push.well', $mobile, $contents, $db_mysqli);
	return 'well';
}

function libsmsVerifycodeCheck ($mobile, $verifycode, $busytag,$action, $db_mysqli)
{
	$contents = libsmsBuildArguments($mobile, $busytag,$action,$verifycode,false,false,false);
	if (!$contents)
		return 'unknown_act';

	$limit = libsmsGetConfigOfPushLimit();
	$last = libsmsDbCore_LoadLastVerify($busytag, $action, $mobile, $db_mysqli);
	$is_repeat = isset($last['id']) && isset($last['verifycode']) && $last['verifycode']==$verifycode;
	$is_timeout = isset($last['id']) && isset($last['second_passed']) && ($last['second_passed'] >= $limit['timeout']);
	if ($is_timeout)
	{
		$contents['txt'] = false;
		libsmsDbAddLogSms ('verifycode.'.$action.'.check.Timeout', $mobile, $contents, $db_mysqli);
		libsmsDbAddLogSys ('verifycode.'.$action.'.check.Timeout', $mobile, $contents, $db_mysqli);
		return 'timeout';
	}
	else if ($is_repeat)
	{
		$contents['txt'] = false;
		libsmsDbAddLogSms ('verifycode.'.$action.'.check.well', $mobile, $contents, $db_mysqli);
		libsmsDbAddLogSys ('verifycode.'.$action.'.check.well', $mobile, $contents, $db_mysqli);
		return 'well';
	}
	else
	{
		$contents['txt'] = false;
		libsmsDbAddLogSms ('verifycode.'.$action.'.check.fail', $mobile, $contents, $db_mysqli);
		libsmsDbAddLogSys ('verifycode.'.$action.'.check.fail', $mobile, $contents, $db_mysqli);
		return false;
	}
}

function libsmsSmsPush ($mobile, $content, $smsid,$busytag)
{
	return sms_of_no2_office__send ($mobile, $content, $smsid,$busytag);
}

function libsmsQueryBlanceOfNo2office ()
{
	return sms_of_no2_office__query_blance();
}

?>

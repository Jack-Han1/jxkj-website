<?php

var_dump('注意：提交到之前必须打开本行'); 
exit ; //提交到svn上之前必须打开本行


/* 函数说明请参考入口文件SmsPusherLib.php顶部注释部分。请确保传入的数据库是mysqli 连接（可以这样获得'new mysqli(...)'）

	public function PanrDebug()
	{
		$mobile = '13588433977';
		//$mobile = '18758117509';


		// the db-handler is from 'new mysqli(...)'
		$db_mysqli = new mysqli('mysqli_host', 'login', 'password', 'db_name'); 
		$db_mysqli->set_charset("utf8");
		echo "<br/><br/><br/>"; var_dump($db_mysqli);

		// sms calls demo here
		require(SYSDIR.'/libraries/SmsPusher/SmsPusherLib.php');
		$verifycode = libsmsVerifycodeNew ('网购宝','change_attr_mobile',$mobile, $db_mysqli);
		$pushresult = libsmsVerifycodePush ($mobile, $verifycode, '网购宝','change_attr_mobile', $db_mysqli);
		$checkreault = libsmsVerifycodeCheck ($mobile, $verifycode, '网购宝','change_attr_mobile', $db_mysqli);
		echo "<br/><br/><br/>"; var_dump(array('NOW'=>date("Y-m-d H:i:s"), 'mobile'=>$mobile, 'verifycode'=>$verifycode, 'pushresult'=>$pushresult, 'checkreault'=>$checkreault));

		// if you want push sms directly, call this func. 
		//libsmsSmsPush ($mobile, "您的验证码是D0PNSWTL，xxxx优惠券aaaa".date('Y-m-d H:i:s'), false, '网购宝');
	}

*/



define('SMSPUSHER_PATH', dirname(__FILE__));
include(SMSPUSHER_PATH."/SmsPusherLib.php");

echo "<br/><br/>";
echo "<br/>SmsPush trying...";
$ret = '0,被panr拦截了demo就当作是成功吧';
//$ret = libsmsSmsPush("13588433977", "您的验证码是D0PNSWTL，xxxx优惠券aaaa".date('Y-m-d H:i:s'), false, '网购宝');
echo "<br/>SmsPush rets: "; var_dump($ret);



// do private testing for no2office.
echo "<br/><br/><br/>";
echo "<br/>No2office::QueryBlance trying...";
$ret = libsmsQueryBlanceOfNo2office();
echo "<br/>No2office::QueryBlance rets: "; var_dump($ret);

echo "<br/><br/><br/>";
echo "<br/>No2office::GetConfig trying...";
$ret = SmsGetConfigOfNo2officeAppid();
echo "<br/>No2office::GetConfig rets: "; var_dump($ret);
?>

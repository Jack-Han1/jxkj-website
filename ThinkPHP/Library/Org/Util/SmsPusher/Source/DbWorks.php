<?php
function libsmsDbCore_NewVerifycode()
{
	$verifycode = date('His');
	//$verifycode = 'A1B2C3';
	return $verifycode;
}

function libsmsDbCore_LoadPushcountOfDay($busytag, $action, $mobile, $db)
{
	$time_bar = date('Y-m-d');
	$sql = "select count(*) as cnt from sys_msg_content where mobile='".$mobile."' and msg_type='".$action."' and is_use=0 and CHAR_LENGTH(msg_content)>0 and createtime>'".$time_bar."'";
	$dat=-1; $result = $db->query($sql);
	if ($result)
	{
		if($result->num_rows>0)
		{
			$row = $result->fetch_array();
			$dat = isset($row[0]) ? $row[0] : 0;
		}
		$result->free_result();
	}

	//echo '<br/>libsmsDbCore_LoadPushcountOfDay:'; var_dump($sql);
	//echo '<br/>libsmsDbCore_LoadPushcountOfDay:'; var_dump($dat);
	return $dat<0 ? 0 : $dat;
}

function libsmsDbCore_LoadLastVerify ($busytag, $action, $mobile, $db)
{
	$fields = "id, msg_type, msg_content, createtime, sendnum, mobile";
	$sql = "select ".$fields." from sys_msg_content where mobile='".$mobile."' and msg_type='".$action."' and is_use=0 and CHAR_LENGTH(msg_content)>0 order by id desc";
	$dat=false; $result = $db->query($sql);
	if ($result)
	{
		if($result->num_rows>0)
		{
			$row = $result->fetch_array();
			$dat = array('id'=>$row[0], 'action'=>$row[1], 'verifycode'=>$row[2], 'createtime'=>$row[3], 'pushcnt'=>$row[4]);
			$dat['second_passed'] = isset($dat['createtime']) ? (strtotime(date("Y-m-d H:i:s"))-strtotime($dat['createtime'])) : 0;
		}
		$result->free_result();
	}

	//echo '<br/>libsmsDbCore_LoadLastVerify:'; var_dump($sql);
	//echo '<br/>libsmsDbCore_LoadLastVerify:'; var_dump($dat);
	return $dat;
}

function libsmsDbCore_AddData($tablename, $sender, $mobile, $contents, $db)
{
	$action = isset($contents['action']) ? $contents['action'] : false;

	$msg_txt = isset($contents['txt']) ? $contents['txt'] : false;
	$smsid = isset($contents['smsid']) ? $contents['smsid'] : $msg_txt;
	$arg1 = isset($contents['verifycode']) ? $contents['verifycode'] : false;
	$arg2 = isset($contents['arg1']) ? $contents['arg1'] : false;
	$arg3 = isset($contents['arg2']) ? $contents['arg2'] : false;
	$arg4 = isset($contents['arg3']) ? $contents['arg3'] : false;
	$arg5 = isset($contents['arg4']) ? $contents['arg4'] : false;

	$sql = "INSERT INTO ".$tablename."(msg_type, mobile, sender, msg_temp,msg_content,msg_content2,msg_content3,msg_content4,msg_content5
		) VALUES ('".$action."', '".$mobile."', '".$sender."', '".$smsid."','".$arg1."','".$arg2."','".$arg3."','".$arg4."','".$arg5."')";
$exec_result = $db ? $db->query($sql) : false;
	//echo '<br/>libsmsDbCore_AddData:'; var_dump($sql);
	//echo '<br/>libsmsDbCore_AddData:'; var_dump($exec_result);
return $exec_result!=false;
}

function libsmsDbCore_NotifyPushMore($tablename, $id, $db)
{
	$sql = "update ".$tablename." set sendnum=sendnum+1 where id='".$id."'";
	$exec_result = $db ? $db->query($sql) : false;
	//echo '<br/>libsmsDbCore_NotifyPushMore:'; var_dump($sql);
	//echo '<br/>libsmsDbCore_NotifyPushMore:'; var_dump($exec_result);
	return $exec_result!=false;
}

function libsmsDbCore_NotifyUsed($tablename, $id, $db)
{
	$sql = "update ".$tablename." set is_use=1 where id='".$id."'";
	$exec_result = $db ? $db->query($sql) : false;
	//echo '<br/>libsmsDbCore_NotifyUsed:'; var_dump($sql);
	//echo '<br/>libsmsDbCore_NotifyUsed:'; var_dump($exec_result);
	return $exec_result!=false;
}







// verifycode process
function libsmsDbVerifyNew($busytag, $action, $mobile, $db, $fail_if_not_new)
{
	$limit = libsmsGetConfigOfPushLimit();
	$last = libsmsDbCore_LoadLastVerify($busytag, $action, $mobile, $db);
	if (isset($limit['time_disable_new']) && $limit['time_disable_new']>5)
	{
		if (isset($last['second_passed']) && ($last['second_passed'] < $limit['time_disable_new']))
		{
			if ($fail_if_not_new)
			{
				return false;
			}
			else
			{
				libsmsDbCore_NotifyPushMore('sys_msg_content', $last['id'], $db);
				return $last['verifycode'];
			}
		}
	}

	$verifycode = libsmsDbCore_NewVerifycode();
	return $verifycode;
}


function libsmsDbVerifyStart($mobile, $contents, $db)
{
	if (!libsmsDbCore_AddData('sys_msg_content', '', $mobile, $contents, $db))
		return false;
	return 'well';
}




// system logs
function libsmsDbAddLogSys ($logtag, $mobile, $contents, $db)
{
}

// msg_send_log logs
function libsmsDbAddLogSms ($logtag, $mobile, $contents, $db)
{
	$contents['action'] = $logtag;
	libsmsDbCore_AddData('sys_msg_send_log', '', $mobile, $contents, $db);
	return ;
}

?>

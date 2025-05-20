<?php


//load/save functions about config-in-a-file. 
function load_cfg ($seq_path, $default)
{
	try
	{
		$fp = fopen($seq_path, "r");
		if (!$fp)
			return $default;

		$data="";
		while (!feof($fp))
			$data.=fread($fp,4096);
		fclose($fp);
		return $data;
	}
	catch (Exception $e)
	{
		return $default;
	}
} 

function save_cfg ($seq_path, $cfg_value)
{
	try
	{
		$fp = fopen($seq_path, "w");
		if (!$fp)
			return false;

		fwrite ($fp, "".$cfg_value);
		return true;
	}
	catch (Exception $e)
	{
		return false; 
	}
}



?>

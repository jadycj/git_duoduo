<?php
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
date_default_timezone_set('PRC');
define('DDROOT', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));

if(!is_file(DDROOT.'/data/conn.php')){
    header('Location:install/index.php');
}

$mod=isset($_GET['mod'])?$_GET['mod']:'index'; //当前模块
$act=isset($_GET['act'])?$_GET['act']:'index'; //当前行为
define('MOD',$mod);
define('ACT',$act);
define('TODAY',date('Ymd'));

include (DDROOT . '/data/conn.php');
include (DDROOT . '/comm/lib.php');

$banben=include(DDROOT.'/data/banben.php');
define('BANBEN',$banben);

$duoduo = new duoduo();
$duoduo->dbserver=$dbserver;
$duoduo->dbuser=$dbuser;
$duoduo->dbpass=$dbpass;
$duoduo->dbname=$dbname;
$duoduo->BIAOTOU=BIAOTOU;
$duoduo_link=$duoduo->connect();

if(!defined('ADMIN')){
	$webset=dd_get_cache('webset');
	$constant=dd_get_cache('constant');
	
	if(empty($webset) || empty($constant)){  //个别网站配置文件没了
		$duoduo->webset();
		$webset=dd_get_cache('webset');
	}
	$duoduo->webset=$webset;
	
	foreach($constant as $k=>$v){
    	define($k,$v);
	}
}
else{
	$webset=$duoduo->webset(101);
	$duoduo->webset=$webset;
}

define('SITEURL', 'http://'.URL);
define('TIME',$_SERVER['REQUEST_TIME']+$webset['corrent_time']);
$sj=date('Y-m-d H:i:s',TIME);
define('SJ',$sj);

$plugin_include=dd_get_cache('plugin_include');
if(!empty($plugin_include)){
	foreach($plugin_include as $code){
		include(DDROOT.'/plugin/comm/'.$code.'.php');
	}
}
?>
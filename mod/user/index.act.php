<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}

$spend_jifenbao=$duoduo->sum('duihuan','spend','`mode`=1 and status=1 and uid="'.$dduser['id'].'"');
$spend_jifen=$duoduo->sum('duihuan','spend','`mode`=2 and status=1 and uid="'.$dduser['id'].'"');

$data=array('lastlogintime'=>SJ);
$duoduo->update('user',$data,'id="'.$dduser['id'].'"');
unset($data);

$web_level=back_arr($webset['level']);
$m=WEB_USER_LEVEL-1;
foreach($web_level as $k=>$v){
	if($dduser['level']>=$k){
    	$dengji_img = "<img src='images/v".$m.".gif' alt='".$v."' />";
		break;
	}
	$m--;
}

$default_pwd=$dd_user_class->get_default_pwd($dduser['id']);

$sign=0;
if($webset['sign']['open']==1){
	$todaytime=strtotime(date('Y-m-d 00:00:00'));
	if($dduser['signtime']<$todaytime){
		$sign=1;
	}
	else{
		$sign=0;
	}
}

if($app_show==1){
    $apilogin_id=$duoduo->select('apilogin','id','uid="'.$dduser['id'].'"');
	$apilogin_id=$apilogin_id>0?$apilogin_id:0;
}

if($app_show==1 && $apilogin_id==0){
	$api_login_tip=1;
}
else{
	$api_login_tip=0;
}

if($dduser['alipay']=='' && $dduser['tenpay']=='' && $dduser['bank_code']==''){
	$caiwu_tip=1;
}
else{
	$caiwu_tip=0;
}

if($webset['sms']['open']==1 && ($dduser['mobile']=='' || $dduser['mobile_test']==0)){
	$mobile_tip=1;
}
else{
	$mobile_tip=0;
}
?>
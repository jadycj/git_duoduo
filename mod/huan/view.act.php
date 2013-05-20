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

$msgset=dd_get_cache('msgset');

if(($webset['sms']['open']==1 && $webset['sms']['need_yz']==1) && ($msgset[4]['sms_open']==1 || $msgset[5]['sms_open']==1) && $dduser['mobile_test']==0){ //提现短信开启
	$huan_sms_open=1;
}
else{
	$huan_sms_open=0;
}

if($huan_sms_open==1 && $dduser['id']>0 && ($dduser['mobile']=='' || $dduser['mobile_test']==0)){
	jump(u('user','info',array('do'=>'mobile')),'请验证您的手机号码');
}

//类型
$type_all=dd_get_cache('type');
$huan_type=$type_all['huan_goods'];
$id =(int)$_GET['id'];
$good=$duoduo->select('huan_goods','id,title,img,jifenbao,jifen,num,`limit`,content,sdate,edate','id="'.$id.'"');

if($good['limit']==0){ //兑换无限制，最多兑换商品全部数量
	$good['limit']=$good['num'];
}
else{
	if($good['limit']<=$good['num']){ //兑换限制比商品总数少
		$good['limit']=$good['limit'];
	}
	else{
		$good['limit']=$good['num'];
	}
}

$jifenbao_dh_status=1;
$jifen_dh_status=1;
$jifenbao_dh_msg=TBMONEY.'兑换';
$jifen_dh_msg='积分兑换';

if($good['num']<=0){
    $jifenbao_dh_status=0;
    $jifen_dh_status=0;
    $jifenbao_dh_msg='暂无库存';
    $jifen_dh_msg='暂无库存';
}

if($dduser['id']>0){
    if($dduser['dhstate']==1){
	    $jifenbao_dh_status=0;
		$jifenbao_dh_msg='您提交的兑换申请正在处理中';
		$jifen_dh_status=0;
		$jifen_dh_msg='您提交的兑换申请正在处理中';
	}
	else{
	    if($dduser['live_jifenbao']<$good['jifenbao']){
		    $jifenbao_dh_status=0;
		    $jifenbao_dh_msg='您的'.TBMONEY.'不足';
		}
		if($dduser['live_jifen']<$good['jifen']){
		    $jifen_dh_status=0;
		    $jifen_dh_msg='您的积分不足';
		}
	}
}
?>
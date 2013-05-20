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

if(isset($_POST['sub'])){
	if($_POST['sms']['pwd']==DEFAULTPWD){
		$_POST['sms']['pwd']=$webset['sms']['pwd'];
	}
	
	if($_POST['sms']['content']!=''){
		$content=$_POST['sms']['content'];
		$ddopen=fs('ddopen');
		$re=$ddopen->sms_content_check($content);
		if($re['s']==1){
			jump(-1,'短信内容包含敏感词“'.$re['r'].'”，请去掉');
		}
	}
	
	include(DDROOT.ADMINDIR.'/mod/public/set.act.php');
}
else{
	$dd_open_status=dd_get(DD_OPEN_URL.'/1.txt');

	if($webset['sms']['pwd']!=''){
		$ddopen=fs('ddopen');
		$ddopen->sms_ini($webset['sms']['pwd']);
		$a=$ddopen->get_user_sms();
		if($a['s']==1){
			$sms_tip='<span style="color:#060">您的剩余短信（<b>'.$a['r']['sms'].'</b>条）</span>';
		}
		else{
			$sms_tip=$a['r'];
		}
	}
}
?>
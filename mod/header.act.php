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

//获取推荐人信息
if(isset($_GET["rec"])){
    if((int)$_GET["rec"]>0){
        set_cookie('tjr',(int)$_GET["rec"],3600);
    }
}

$apps = dd_get_cache('apps');
if(!empty($apps)){
	$app_show=1;
}
else{
	$app_show=0;
}

$nav=dd_get_cache('nav');

if($webset['yiqifaapi']['open']==1 || $webset['wujiumiaoapi']['open']==1){
	$mallapiopen=1;
}

$userlogininfo=unserialize(get_cookie('userlogininfo')); 
$hcookieuid = $userlogininfo['uid']; 
$hcookiepassword = $userlogininfo['ddpassword']; 
$hcookiesavetime = $userlogininfo['ddsavetime']; 
$dduser['name'] = '';
$dduser['id'] = 0;
$dduser['level'] = 0;
if($hcookieuid>0 && $hcookiepassword<>NULL){	
	$user=$duoduo->select('user','id,ddusername,ddpassword,money,jifenbao,jifen,level,txstatus,tbtxstatus,dhstate,realname,qq,alipay,tenpay,bank_name,bank_code,email,mobile,mobile_test,yitixian,tbyitixian,hart,tjr,ucid,fxb,lastlogintime,signtime,txtool',"id='".$hcookieuid."' and ddpassword='".$hcookiepassword."'");
	if($user['id']>0){
	    $dduser['name'] = $user['ddusername'];
		$dduser['id'] = $user['id'];
		$dduser['ddpassword'] = $user['ddpassword'];
		$dduser['level'] = $user['level'];
		$dduser['money'] = $user['money'];
		$dduser['jifenbao'] = jfb_data_type($user['jifenbao']);
		$dduser['jifen'] = $user['jifen'];
		$dduser['qq'] = $user['qq'];
		$dduser['alipay'] = $user['alipay'];
		$dduser['tenpay'] = $user['tenpay'];
		$dduser['txstatus'] = $user['txstatus'];
		$dduser['tbtxstatus'] = $user['tbtxstatus'];
		$dduser['dhstate'] = $user['dhstate'];
		$dduser['realname'] = $user['realname'];
		$dduser['email'] = $user['email'];
		$dduser['mobile_test'] = $user['mobile_test'];
		$dduser['mobile'] = $user['mobile']=='0'?'':$user['mobile'];
		if($dduser['mobile']==''){
			$dduser['mobile_test']=0;
		}
		$dduser['yitixian'] = $user['yitixian'];
		$dduser['tbyitixian'] = $user['tbyitixian'];
		$dduser['hart'] = $user['hart'];
		$dduser['tjr'] = $user['tjr'];
		$dduser['ucid'] = $user['ucid'];
		$dduser['fxb'] = $user['fxb'];
		$dduser['signtime'] = $user['signtime'];
		$dduser['lastlogintime'] = $user['lastlogintime'];
		$dduser['txtool'] = $user['txtool'];
		$dduser['bank_name']=$user['bank_name'];
		$dduser['bank_code']=$user['bank_code']!=0?$user['bank_code']:'';
		
		$msgnum = $duoduo->count('msg',"uid='".$dduser['id']."' and see=0");

		user_login($hcookieuid,$hcookiepassword,$hcookiesavetime);
		
		//if(MOD=='user' || MOD=='ajax'){  //只在会员和ajax模块计算冻结佣金
			$dduser=$duoduo->freeze_user($dduser);
		//}
    }
	else{
        set_cookie('userlogininfo','',0);
    }
}
else{
    set_cookie('userlogininfo','',0);
}
?>
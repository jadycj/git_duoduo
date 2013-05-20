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

define('MOBILE_YZM_EFFECT',$webset['sms']['yzmjg']?$webset['sms']['yzmjg']:60);
$default_pwd=$dd_user_class->get_default_pwd($dduser['id']);

//会员信息
$do=$_GET['do']?$_GET['do']:'myinfo';

if($do=='myinfo'){
	if($_POST['sub']!=''){
		$old_password=trim($_POST['old_password']);
		$qq=trim($_POST['qq']);
		$email=trim($_POST['email']);
		$mobile=trim($_POST['mobile']);
		
		$field_arr['qq']=$qq;
		$field_arr['email']=$email;
		
		if($webset['sms']['open']==0){
			$field_arr['mobile']=$mobile;
		}
		
		if($webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
        	include_once DDROOT.'/uc_client/client.php';
			$uc_name = iconv("utf-8", "utf-8", $dduser['name']);
			$ucresult = uc_user_edit($uc_name, $old_password, $old_password, $email);
			
			if ($ucresult == -1) {
				jump(-1,'密码错误！');	
			}
			elseif ($ucresult == -4) {
				jump(-1,'email格式错误！');
			}
			elseif ($ucresult == -5) {
				jump(-1,'email已被使用！');
			}
			elseif ($ucresult == -6) {
				jump(-1,'email已被使用！');
			}
		}
		
		if($duoduo->check_oldpass($old_password,$dduser['id'])=='false'){
		    jump(-1,'密码错误！');
		}
		if(reg_email($email)==0){
		    jump(-1,'email格式错误！');
		}
		if($mobile!='' && reg_mobile($mobile)==0){
		    jump(-1,'手机号码格式错误！');
		}

		if($duoduo->check_my_email($email,$dduser['id'])>0){
		    jump(-1,'email已被使用！');
		}

		$duoduo->update('user', $field_arr, 'id='.$dduser['id']);
		
		$userlogininfo=unserialize(get_cookie('userlogininfo')); 
		
	    $goto=u('user','info');

	    if($webset['phpwind']['open']==1){
		    $user['id']=$dduser['id'];
		    $user['name']=$dduser['name'];
		    $user['password']=$old_password;
		    $user['email']=$email;
	        $goto=$duoduo->phpwind($user,$goto);
	    }
		jump($goto);
	}
}
elseif($do=='apilogin'){
    $api=$duoduo->select_all('api','title,code','open=1 order by sort desc');
	$user_api=$duoduo->sel_one_arr_sql('apilogin','web','uid="'.$dduser['id'].'"');
}
elseif($do=='mobile'){
	$mobile_yzm_time=get_cookie('mobileYzmTime');
	if(isset($_GET['send_yzm']) && $_GET['send_yzm']==1){
		$mobile=$_POST['mobile'];
		if($dduser['mobile_test']==1){
			$mobile=$dduser['mobile'];
		}

		if($mobile_yzm_time>0 && TIME-$mobile_yzm_time<MOBILE_YZM_EFFECT){
			jump(-1,69);
		}
		
		$mobile_test=(int)$duoduo->select('user','mobile_test','mobile="'.$mobile.'" and mobile_test=1 and id<>"'.$dduser['id'].'"');
		if($mobile_test==1){
			jump(-1,68);
		}
		
		$mobileYzmNum=(int)get_cookie('mobileYzmNum');
		$mobileYzmNum++;
		
		if($webset['sms']['limit']>0 && $mobileYzmNum>$webset['sms']['limit']){
			$re=array('s'=>0,'id'=>67);
		}
		else{
			$yzm=rand(100000,999999);
			$content=$duoduo->select('msgset','sms','id=11');
			$content=str_replace('{yzm}',$yzm,$content);
		
			$ddopen=fs('ddopen');
			$ddopen->sms_ini($webset['sms']['pwd']);
			$re=$ddopen->sms_send($mobile,$content);
			if($re['s']==1){
				set_cookie('mobileYzm',$yzm,MOBILE_YZM_EFFECT*10);
				set_cookie('mobileYzmNum',$mobileYzmNum,3600*24);
				set_cookie('mobileYzmTime',TIME,3600*24);
			}
			else{
				$re=array('s'=>0,'id'=>999);
			}
		}

		echo dd_json_encode($re);
		dd_exit();
	}
	if($_POST['sub']!=''){
		$mobile_yzm=(int)get_cookie('mobileYzm');
		$mobile=$_POST['mobile'];
		$yzm=$_POST['yzm'];

		if($mobile_yzm==$yzm){
			set_cookie('mobileYzm','',0);
			$data=array('mobile'=>$mobile,'mobile_test'=>1);
			$duoduo->update('user',$data,'id="'.$dduser['id'].'"');
			$re=json_encode(array('s'=>1));
			dd_exit($re);
		}
		else{
			jump(-1,5);
		}
	}
}
elseif($do=='caiwu'){
	if($webset['sms']['open']==1 && $webset['sms']['need_yz']==1 && $dduser['mobile_test']==0){
		jump(u('user','info',array('do'=>'mobile')),'请验证您的手机号码');	
	}
	
	$txtool_arr=array();
	if($webset['tixian']['need_alipay']==1){
		$txtool_arr[1]='支付宝';
	}
	if($webset['tixian']['need_tenpay']==1){
		$txtool_arr[2]='财付通';
	}
	if($webset['tixian']['need_bank']==1){
		$bank_1=dd_get_cache('bank');
		$bank=array(0=>'选择银行');
		foreach($bank_1 as $row){
			$bank[]=$row['name'];
		}
		$txtool_arr[3]='银行';
	}

    if($_POST['sub']!=''){
		$field_arr['old_password']=trim($_POST['old_password']);
		$field_arr['realname']=trim($_POST['realname']);
		$field_arr['alipay']=trim($_POST['alipay']);
		$field_arr['tenpay']=trim($_POST['tenpay']);
		$field_arr['bank_name']=trim($_POST['bank_name']);
		$field_arr['bank_id']=trim($_POST['bank_id']);
		$field_arr['bank_code']=trim($_POST['bank_code']);
		$field_arr['txtool']=trim($_POST['txtool']);
		
		if($webset['sms']['open']==1){
			$yzm=$_POST['yzm'];
			$mobile_yzm=(int)get_cookie('mobileYzm');
			if($mobile_yzm!=$yzm){
				jump(-1,5);
			}
		}
		
		/*$txtool=$_POST['txtool'];
		if(!isset($txtool_arr[$txtool])){
			jump(-1,65);  //提现工具未选择
		}*/
		
		if($duoduo->check_oldpass($field_arr['old_password'],$dduser['id'])=='false'){
		    jump(-1,4); //密码错误
		}
		
		if($dduser['realname']!=''){
		    unset($field_arr['realname']);
		}
		
		if($dduser['alipay']!=''){
		    unset($field_arr['alipay']);
		}
		elseif($field_arr['alipay']!=''){
			if(reg_alipay($field_arr['alipay'])==0){
		    	jump(-1,35);  //支付格式错误
			}
			if($duoduo->check_my_field('alipay',$field_arr['alipay'],$dduser['id'])>0){
		    	jump(-1,37);  //支付宝已被使用
			}
		}
		
		if($dduser['tenpay']!=''){
		    unset($field_arr['tenpay']);
		}
		elseif($field_arr['tenpay']!=''){
			if(reg_tenpay($field_arr['tenpay']==0)){
		    	jump(-1,62);  //财付通格式错误
			}
			if($duoduo->check_my_field('tenpay',$field_arr['tenpay'],$dduser['id'])>0){
		    	jump(-1,63);  //财付通已被使用
			}
		}
		
		if($dduser['bank_name']!=''){
		    unset($field_arr['bank_id']);
		}
		elseif(isset($field_arr['bank_id']) && $field_arr['bank_id']!==''){
			$bank_id=(int)$field_arr['bank_id'];
			if(!isset($bank[$bank_id])){
				jump(-1,59);  //银行id格式错误
			}
			else{
				unset($bank[0]);
				$field_arr['bank_name']=$bank[$bank_id];
			}
		}
		
		if($dduser['bank_code']!=''){
		    unset($field_arr['bank_code']);
		}
		elseif($field_arr['bank_code']==''){
			if($bank_id>0){
				jump(-1,60);  //银行账号格式错误
			}
			$field_arr['bank_code']=0;
		}
		elseif($field_arr['bank_code']!=''){
			if(reg_bank_code($field_arr['bank_code']==0)){
		    	jump(-1,60);  //银行账号格式错误
			}
			if($duoduo->check_my_field('bank_code',$field_arr['bank_code'],$dduser['id'])>0){
		    	jump(-1,61);  //银行账号已被使用
			}
			if(!isset($field_arr['bank_name'])){
				jump(-1,58);  //未选择银行
			}
		}
		unset($field_arr['bank_id']);
		unset($field_arr['old_password']);
		$duoduo->update('user', $field_arr, 'id='.$dduser['id']);
		$re=json_encode(array('s'=>1));
		dd_exit($re);
	}
	else{
		$dduser['bank_id']=array_search($dduser['bank_name'],$bank);
	}
}
elseif($do=='pwd'){
    if($_POST['sub']!=''){
		
		if($_POST['ddpwd']!=$_POST['pwd_confirm']){ //两次密码对比
		    $re=json_encode(array('s'=>0,'id'=>34));
		    dd_exit($re);
		}
		if(reg_password($_POST['ddpwd'])==0){ //密码格式
		    $re=json_encode(array('s'=>0,'id'=>3));
		    dd_exit($re);
		}

		if($duoduo->check_oldpass($_POST['old_pwd'],$dduser['id'])=='false'){
		    $re=json_encode(array('s'=>0,'id'=>4));
		    dd_exit($re);
		}
		
		if($webset['ucenter']['open']==1){
			include DDROOT.'/comm/uc_define.php';
        	include_once DDROOT.'/uc_client/client.php';
			$uc_name = iconv("utf-8", "utf-8", $username);
			$ucresult = uc_user_edit($dduser['name'], $_POST['old_pwd'], $_POST['ddpwd']);
			if($ucresult<=0){
				$re=json_encode(array('s'=>0,'id'=>4));
		    	dd_exit($re);
			}
		}
		
		$field_arr['ddpassword']=md5($_POST['ddpwd']);
		$duoduo->update('user', $field_arr, 'id='.$dduser['id']);
		user_login($dduser['id'],$field_arr['ddpassword'],$userlogininfo['ddsavetime']); //重置登陆状态
		$re=json_encode(array('s'=>1));
		dd_exit($re);
	}
}
?>
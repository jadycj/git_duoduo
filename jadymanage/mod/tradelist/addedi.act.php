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

if(!defined('ADMIN')){
	exit('Access Denied');
}

if($_POST['sub']!=''){
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	if($id>0){
		$do=(int)$_POST['do'];
		if($do==1){  //退款订单
	    	$re=$duoduo->refund($id,1);
			jump('-2',$re);
		}
		elseif($do==2){
			if($_POST['uname']==''){
				jump('-1','会员名不能为空');
			}
	    	$user=$duoduo->select('user','id,ddusername,level,tjr','ddusername="'.$_POST['uname'].'"');
			if(!$user['id']){
		    	jump('-1','会员不存在');
			}
			$trade=$duoduo->select('tradelist','*','id="'.$id.'"');
			$duoduo->rebate($user,$trade,8); //确认淘宝返利
			jump('-2','确认成功');
		}
	}
	else{
		if($_POST['uname']==''){
			jump('-1','会员名不能为空');
		}
	    $user=$duoduo->select('user','id,ddusername,level,tjr','ddusername="'.$_POST['uname'].'"');
		if(!$user['id']){
		   	jump('-1','会员不存在');
		}
		unset($_POST['sub']);
		unset($_POST['uname']);
		unset($_POST['do']);
		unset($_POST['id']);
		$_POST['outer_code']=$user['id'];
		$_POST['uid']=$user['id'];
		$_POST['checked']=2;
		$_POST['qrsj']=TIME;
		$_POST['commission_rate']=round($_POST['commission_rate']/100,2);
		
		$id=$duoduo->select('tradelist','id','trade_id="'.$_POST['trade_id'].'"');
		if($id>0){
			jump(-1,'订单号不可重复');
		}
		
		$id=$duoduo->insert('tradelist',$_POST);
		
		$trade=$duoduo->select('tradelist','*','id="'.$id.'"');
		$duoduo->rebate($user,$trade,8); //确认淘宝返利
		jump('-1','添加成功');
	}
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}
?>
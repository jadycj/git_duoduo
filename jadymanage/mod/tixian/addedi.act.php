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

if($_GET['do']=='cancel'){
	$id=(int)$_GET['id'];
	$a=$ddopen->cancel_jifenbao($id);
	if($a['s']==1){
		$data=array('wait'=>0,'api_return'=>'');
		$duoduo->update(MOD,$data,'id='.$id);
	}
	jump(-1,$a['r']);
}

if($_POST['sub']!=''){
    $id=empty($_POST['id'])?0:(int)$_POST['id'];
	$do=$_POST['do'];
	$re=$duoduo->tixian($id,$do);
	if($re['s']==0){
		$word=$re['r'];
		jump('-2',$word);
	}
	elseif($re['s']==1){
		$word='确认成功';
	}
	jump('-2',$word);
}
else{
	$id=empty($_GET['id'])?0:(int)$_GET['id'];
	$do=$_GET['do'];
    if($id==0){
	    $row=array();
	}
	else{
	    $row=$duoduo->select(MOD,'*','id="'.$id.'"');
	}
}
?>
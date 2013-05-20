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

$select_arr=array('item_title'=>'商品名','trade_id'=>'订单号','uname'=>'会员名','uid'=>'会员id');
$select2_arr=array('0'=>'全部','1'=>'电脑','2'=>'手机');
$checked_arr['']='全部';
$checked_arr=$checked_arr+$checked_status;

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];
$se=$_GET['se'];
$se2=$_GET['se2'];
$checked=$_GET['checked'];
$stime=$_GET['stime'];
$dtime=$_GET['dtime'];

$page_arr=array('q'=>$q,'se'=>$se,'checked'=>$checked,'stime'=>$stime,'dtime'=>$dtime);

if($checked==''){
    unset($checked);
}

if(!isset($checked)){
    $where=' ';
}
else{
    $where=' a.checked="'.$checked.'" and ';
}

if(!array_key_exists($se,$select_arr)){
    $se='item_title';
}

if($se=='uname'){
    $uid=$duoduo->select('user','id','ddusername="'.$q.'"');
	$where.='a.uid="'.$uid.'"';
}
else{
    $where.='a.`'.$se.'` like "%'.$q.'%"';
}

if(isset($se2) && $se2>0){
	$where.=' and a.`platform`='.$se2;
	$page_arr['se2']=$se2;
}

if($stime!='' && $dtime!=''){
   $where.='and a.pay_time >= "'.$stime.'" and a.pay_time < "'.$dtime.'"';
}

$total=$duoduo->count(MOD.' as a',$where);
$row=$duoduo->left_join(MOD.' as a','user AS b ON a.uid = b.id','a.*,b.ddusername as uname',$where.' order by a.pay_time desc limit '.$frmnum.','.$pagesize);
?>
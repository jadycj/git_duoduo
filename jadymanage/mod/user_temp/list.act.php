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

$select1_arr=array('ddusername'=>'会员名','id'=>'会员ID','tjr'=>'推荐人名','qq'=>'QQ号码','alipay'=>'支付宝号','email'=>'邮箱','mobile'=>'手机号码','realname'=>'姓名');
$select2_arr=array('money'=>'金额','jifenbao'=>TBMONEY,'jifen'=>'积分','level'=>'等级','loginnum'=>'登陆次数');

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$by_field='';
$q=$_GET['q'];
$se2=$_GET['se2']; 
$se1=$_GET['se1']; 
$linput=$_GET['linput']!==''?$_GET['linput']:-999999; 
$hinput=$_GET['hinput']!==''?$_GET['hinput']:999999999; 
$page_arr=array();

$where='a.id=b.id';
if($se1=='tjr'){
    $q=$duoduo->select('user','id','ddusername="'.$q.'"');
}

if(isset($se1) && $q!=''){
    $where.=' and `'.$se1.'` = "'.$q.'"';
	
	$page_arr['q']=$q;
	$page_arr['se1']=$se1;
}

if(isset($se2)){
    $where.=' and ('.$se2.'>='.$linput.' and '.$se2.'<='.$hinput.')';
	
	$page_arr['linput']=$linput;
	$page_arr['hinput']=$hinput;
	$page_arr['se2']=$se2;
}

$by_field_arr=array('level','money','jifenbao','jifen','loginnum','lastlogintime');

foreach($_GET as $k=>$v){
    if(in_array($k,$by_field_arr)){
	    $by_field=$k;
	}
}

if($by_field!=''){
    if($_GET[$by_field]!='desc' && $_GET[$by_field]!='asc'){
	    $_GET[$by_field]='asc';
	}
	$by=$by_field.' '.$_GET[$by_field].',';
	$page_arr[$by_field]=$_GET[$by_field];
}
else{
    $by='';
}
if($_GET[$by_field]=='desc'){
    $listorder='asc';
}
else{
    $listorder='desc';
}

$total=$duoduo->count(MOD.' as a,user as b',$where);
$row=$duoduo->select_all(MOD.' as a,user as b','b.*',$where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize);
if($se1=='tjr'){
    $q=$_GET['q'];
	$page_arr['q']=$q;
}
?>
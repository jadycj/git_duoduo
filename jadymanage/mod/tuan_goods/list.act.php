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

$page = !($_GET['page'])?'1':intval($_GET['page']);
$pagesize=20;
$frmnum=($page-1)*$pagesize;
$q=$_GET['q'];

$where='';
if(isset($_GET['mall_id'])){
    $mall_id=(int)$_GET['mall_id'];
	if($mall_id>0){
	   $where=' and a.mall_id="'.$mall_id.'"';
	}
}

if(isset($_GET['sort'])){
    $by.='sort desc,';
}

$total=$duoduo->count('tuan_goods as a',"a.`title` like '%$q%'".$where);
$row=$duoduo->select_all('tuan_goods as a,mall as b','a.*,b.title as mallname','a.`title` like "%'.$q.'%" and a.mall_id=b.id'.$where.' order by '.$by.' id desc limit '.$frmnum.','.$pagesize);
?>
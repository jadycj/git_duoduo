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

if(isset($_GET['sort'])){
	$sort=$_GET['sort'];
    $by='sort desc,';
}
else{
    $by='';
}

$total=$duoduo->count(MOD,"`title` like '%$q%' or nick like '%$q%'");
$row=$duoduo->select_all(MOD,'*','`title` like "%'.$q.'%" or nick like "%'.$q.'%" order by '.$by.' id desc limit '.$frmnum.','.$pagesize);
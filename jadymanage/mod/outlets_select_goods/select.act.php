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
if($_POST){print_r($_POST);exit();}
if($_POST['nick']){
	$seller_nicks = $_POST['nick'];
}
	include (DDROOT . '/comm/Taoapi.php');
	include (DDROOT . '/comm/ddTaoapi.class.php');
	$ddTaoapi = new ddTaoapi;
	$taobao_itemcats_get=$ddTaoapi->taobao_itemcats('0');


	
	
	
$coupon_sort=array (
  'default' => '默认排序',
  'price_desc' => '折扣价格从高到低',
  'price_asc'=>'折扣价格从低到高',
  'credit_desc'=>'信用等级从高到低',
  'credit_asc'=>'信用等级从低到高',
  'commissionRate_desc'=>'佣金比率从高到低',
  'commissionRate_asc'=>'佣金比率从低到高',
  'volume_desc'=>'成交量成高到低',
  'volume_asc'=>'成交量从低到高',
);

$sort = array(
//  'default' => '默认排序',//api接口不支持
  'price_desc' => '折扣价格从高到低',
  'price_asc'=>'折扣价格从低到高',
  'credit_desc'=>'信用等级从高到低',
  'commissionRate_desc'=>'佣金比率从高到低',
  'commissionRate_asc'=>'佣金比率从低到高',
  'commissionNum_desc'=>'成交量成高到低',
  'commissionNum_asc'=>'成交量从低到高',
  'commissionVolume_desc'=>'总支出佣金从高到低',
  'commissionVolume_asc'=>'总支出佣金从低到高',
  'delistTime_desc'=>'商品下架时间从高到低',
  'delistTime_asc'=>'商品下架时间从低到高',
  
);
$shop_sort =array(
'default' => '默认排序',
'commissionRate_desc' => '佣金比率从高到低',
'commissionRate_asc' => '佣金比率从低到高',
'credit_desc' => '信用等级从高到低',
'credit_asc' => '信用等级从低到高',
);

$rate=array(
    1000=>'10%',
	2000=>'20%',
	3000=>'30%',
	4000=>'40%',
	5000=>'50%',
	6000=>'60%',
	7000=>'70%',
	8000=>'80%',
	9000=>'90%',
);

$credit=array(
    '1heart'=>'一心',
	'2heart'=>'二心',
	'3heart'=>'三心',
	'4heart'=>'四心',
	'5heart'=>'五心',
	'1diamond'=>'一钻',
	'2diamond'=>'二钻',
	'3diamond'=>'三钻',
	'4diamond'=>'四钻',
	'5diamond'=>'五钻',
	'1crown'=>'一冠',
	'2crown'=>'二冠',
	'3crown'=>'三冠',
	'4crown'=>'四冠',
	'5crown'=>'五冠',
	'1goldencrown'=>'一皇冠',
	'2goldencrown'=>'二皇冠',
	'3goldencrown'=>'三皇冠',
	'4goldencrown'=>'四皇冠',
	'5goldencrown'=>'五皇冠',
);
?>
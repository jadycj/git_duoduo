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
if(!defined('PAGE')) exit('miss page');

$_GET=/*array (
  'date' => '20130415',
  'time' => '145013',
  'type' => '2',
  'promotionID' => '1053',
  'promotionName' => '唯品会CPS推广',
  'extinfo' => '0',
  'userinfo' => '',
  'comm' => '2.0160',
  'totalPrice' => '48.0000',
  'OCD' => '13041510261428',
  'goodDetails' => '2/4.2%/0.0000/48/1/[39000007900102]',
  'sig' => '93537adee8210c6034a7362b9ccecbf0',
  'p' => 'getchanet',
)*/;

$get=var_export($_GET, true)."\r\n";
$dir =DDROOT.'/data/chanet_'.substr(md5(DDKEY),0,16).'/'. date("Y").'/'.date('md').'.txt';
create_file($dir,$get,1);

$date=$_GET['date'];
$time=$_GET['time'];
$type=$_GET['type'];
$promotionID=$_GET['promotionID'];
$promotionName=$_GET['promotionName'];
$mall=$duoduo->select('mall','id,title,type','chanetid="'.$promotionID.'"');
$mallname=$mall['title']?$mall['title']:preg_replace('/ cps推广/i','',$promotionName);
$extinfo=$_GET['extinfo'];
$userinfo=$_GET['userinfo'];
$comm=$_GET['comm'];
$totalPrice=$_GET['totalPrice'];
$ocd=$_GET['OCD'];
$goodDetails=$_GET['goodDetails'];
$sig=$_GET['sig'];
$key=$webset['chanet']['key'];
$status=0;

$params=$date."&".$time."&".$promotionID."&".$comm."&".$totalPrice."&".$ocd;
$signature= md5($params."&".$key);
if($signature!=$sig){
    dd_exit('error sig');
}

$userinfo=(int)$userinfo;

$num=0;
$arr=explode(':',$goodDetails);
foreach($arr as $row){
	$a=explode('/',$row);
	$num+=$a[4];
}

$dduser=$duoduo->select('user','id,ddusername,level,tjr','id="'.$userinfo.'"');
$fxje=fenduan($comm,$webset['mallfxbl'],$dduser['level']);
$jifen=round($fxje*$webset['jifenbl']);
if($mall['type']==2){  //返积分
	$fxje=0;
}

if($user['tjr']>0){
	$tgyj=round($fxje*$webset['tgbl']);
}
else{
	$tgyj=0;
}

$unique_id=$ocd;  //唯一编号，成果订单号可确定唯一
$mall_order = $duoduo->select("mall_order", "id,mall_name,status,fxje,jifen,commission,order_code", 'unique_id="'.$unique_id.'"'); //用订单编号查
if ($mall_order['id'] == '') { //交易不存在
	$field_arr = array (
		'adid' => $promotionID,
		'lm' => 1,
		'order_time' => strtotime($date.' '.$time),
		'mall_name' => $mallname,
		'mall_id'=>(int)$mall['id'],
		'uid' => $userinfo,
		'order_code' => $ocd,
		'item_count' => $num,
		'item_price' => round($totalPrice/$num,2),
		'sales' => round($totalPrice,2),
		'commission' => $comm,
		'status' => $status,
		'fxje' => $fxje,
		'jifen' => $jifen,
		'tgyj' => $tgyj,
		'addtime'=>TIME,
		'unique_id'=>$unique_id
	);
	$duoduo->insert("mall_order", $field_arr);
	echo 1;
}
else{
    echo 0;
}
?>
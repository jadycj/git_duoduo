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

if(isset($_POST['sub']) && $_POST['sub']!=''){
	$fxbl=$_POST['fxbl'];
	$mallfxbl=$_POST['mallfxbl'];
	$paipaifxbl=$_POST['paipaifxbl'];
	$level_name=$_POST['level_name'];
	$jishu_arr=array();
	foreach($level_name as $v){
		if(in_array($v,$jishu_arr)){
			jump(-1,'会员等级名称不能相同');
		}
		$jishu_arr[]=$v;
	}
	$level_dengji=$_POST['level_dengji'];
	$jishu_arr=array();
	foreach($level_dengji as $v){
		if(in_array($v,$jishu_arr)){
			jump(-1,'会员等级级别不能相同');
		}
		$jishu_arr[]=$v;
	}

	for($i=0;$i<4;$i++){
	    $level[$level_dengji[$i]]=$level_name[$i];
		$fxbl_arr[$level_dengji[3-$i]]=round($fxbl[3-$i]/100,2);
		$mallfxbl_arr[$level_dengji[3-$i]]=round($mallfxbl[3-$i]/100,2);
		$paipaifxbl_arr[$level_dengji[3-$i]]=round($paipaifxbl[3-$i]/100,2);
	}
	
	

    krsort($fxbl_arr);
	krsort($mallfxbl_arr);
	krsort($paipaifxbl_arr);
	$diff_arr=array('level_name','level_dengji','sub');
	$_POST=logout_key($_POST, $diff_arr);
	
	dd_string($fxbl_arr);  //小数在序列化后会产生多位，转化成字符型数据
	dd_string($mallfxbl_arr);
	dd_string($paipaifxbl_arr);

	$_POST['tgbl']=round($_POST['tgbl']/100,2);
	$_POST['jifenbl']=round($_POST['jifenbl']/100,2);
	
	$_POST['fxbl']=$fxbl_arr;
	$_POST['mallfxbl']=$mallfxbl_arr;
	$_POST['paipaifxbl']=$paipaifxbl_arr;
	$_POST['level']=$level;

	$webset_field=$duoduo->select_2_field('webset','id,var','1=1');

	foreach($_POST as $k=>$v){
		$duoduo->set_webset($k,$v);
	}
	$duoduo->webset(); //配置缓存
	define('UPDATECACHE',1);
	include(ADMINROOT.'/mod/public/mod.update.php');
	jump('-1','保存成功');
	
}
else{
	ksort($webset['fxbl']);
	ksort($webset['mallfxbl']);
	ksort($webset['paipaifxbl']);
}
?>
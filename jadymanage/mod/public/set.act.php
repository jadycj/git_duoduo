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
	$diff_arr=array('sub');
	$_POST=logout_key($_POST, $diff_arr);
	$webset_field=$duoduo->select_2_field('webset','id,var','1=1');
	foreach($_POST as $k=>$v){
		if(MOD=='user' && $k=='user'){
			$ips=str_replace('.','\.',$v['limit_ip']);
			dd_set_cache('user_limit_ip',strtoarray($ips));
			//continue;
		}
		$duoduo->set_webset($k,$v);
	}
	$duoduo->webset(); //配置缓存
	jump('-1','保存成功');
}
else{
	
}
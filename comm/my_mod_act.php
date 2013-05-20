<?php
/**
 * ============================================================================
 * 版权所有 2008-2013 多多科技，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

if(!defined('INDEX')){
	exit('Access Denied');
}
//二次开发自增模块和行为 前台模块示例 $front_mod_arr[]='mysql';
//add by jady  2013-5-1

$front_mod_arr[]='outlets';
$outlets_act_arr[]='index';
$ajax_act_arr[]='seer_shop_items_get';
$ajax_act_arr[]='get_taobao_itemcats';
$ajax_act_arr[]='get_outlets_items';
$ajax_act_arr[]='get_outlets_items_coupon';
$ajax_act_arr[]='get_outlets_items_shop';

//add end  2013-5-1
?>
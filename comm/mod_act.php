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

$front_mod_arr[]='index'; //前台模块
$front_mod_arr[]='tao';
$front_mod_arr[]='shop';
$front_mod_arr[]='mall';
$front_mod_arr[]='user';
$front_mod_arr[]='ajax';
$front_mod_arr[]='article';
$front_mod_arr[]='fxb';
$front_mod_arr[]='jump';
$front_mod_arr[]='sitemap';
$front_mod_arr[]='huan';
$front_mod_arr[]='huodong';
$front_mod_arr[]='baobei';
$front_mod_arr[]='api';
$front_mod_arr[]='tuan';
$front_mod_arr[]='help';
$front_mod_arr[]='cache';
$front_mod_arr[]='about';
$front_mod_arr[]='paipai';

$index_act_arr[]='index';  //index模块行为

$tao_act_arr[]='index';  //tao模块行为
$tao_act_arr[]='list';
$tao_act_arr[]='view';
$tao_act_arr[]='shop';
$tao_act_arr[]='report';
$tao_act_arr[]='cache';
$tao_act_arr[]='zhe';
$tao_act_arr[]='session';
$tao_act_arr[]='jifenbao';
$tao_act_arr[]='juhuasuan';
$tao_act_arr[]='coupon';
$tao_act_arr[]='cha';
$tao_act_arr[]='jiu';

$shop_act_arr[]='list';  //shop模块行为

$mall_act_arr[]='list';  //mall模块行为
$mall_act_arr[]='view';
$mall_act_arr[]='goods';

$huan_act_arr[]='list';  //huan模块行为
$huan_act_arr[]='view';

$baobei_act_arr[]='list';  //baobei模块行为
$baobei_act_arr[]='view';
$baobei_act_arr[]='user';

$huodong_act_arr[]='list';  //huodong模块行为
$huodong_act_arr[]='view';

$user_act_arr[]='index';
$user_act_arr[]='register';
$user_act_arr[]='login';
$user_act_arr[]='exit';
$user_act_arr[]='tradelist';
$user_act_arr[]='mingxi';
$user_act_arr[]='msg';
$user_act_arr[]='info';
$user_act_arr[]='getpassword';
$user_act_arr[]='avatar';
$user_act_arr[]='up_avatar';
$user_act_arr[]='baobei';
$user_act_arr[]='huan';
$user_act_arr[]='confirm';
$user_act_arr[]='jihuo';
$user_act_arr[]='tixian';
$user_act_arr[]='shoutu';

$ajax_act_arr[]='check_user';
$ajax_act_arr[]='check_oldpass';
$ajax_act_arr[]='check_email';
$ajax_act_arr[]='check_alipay';
$ajax_act_arr[]='check_my_bank_code';
$ajax_act_arr[]='check_captcha';
$ajax_act_arr[]='get_msg';
$ajax_act_arr[]='check_my_email';
$ajax_act_arr[]='check_my_alipay';
$ajax_act_arr[]='check_my_tenpay';
$ajax_act_arr[]='mall_comment';
$ajax_act_arr[]='huan';
$ajax_act_arr[]='getTaoItem';
$ajax_act_arr[]='like';
$ajax_act_arr[]='userinfo';
$ajax_act_arr[]='save_share';
$ajax_act_arr[]='save_share_comment';
$ajax_act_arr[]='sign';
$ajax_act_arr[]='get_size';
$ajax_act_arr[]='goods_comment';
$ajax_act_arr[]='pinyin';
$ajax_act_arr[]='tao_cuxiao';
$ajax_act_arr[]='malls';
$ajax_act_arr[]='chanet';
$ajax_act_arr[]='weiyi';
$ajax_act_arr[]='send_mail';
$ajax_act_arr[]='shop_items_get';
$ajax_act_arr[]='addshop';
$ajax_act_arr[]='jssdk_cache';
$ajax_act_arr[]='get_59miao_mall';
$ajax_act_arr[]='huanqian';
$ajax_act_arr[]='cron';
$ajax_act_arr[]='send_sms';

$api_act_arr[]='sina';
$api_act_arr[]='qq';
$api_act_arr[]='tb';
$api_act_arr[]='do';
$api_act_arr[]='qqweibo';
$api_act_arr[]='kaixin';

$tuan_act_arr[]='list';
$tuan_act_arr[]='view';
$tuan_act_arr[]='collect';

$article_act_arr[]='list';
$article_act_arr[]='view';
$article_act_arr[]='index';

$jump_act_arr[]='goods';
$jump_act_arr[]='shop';
$jump_act_arr[]='s8';
$jump_act_arr[]='mall';
$jump_act_arr[]='huodong';
$jump_act_arr[]='tuan';
$jump_act_arr[]='mall_goods';
$jump_act_arr[]='paipaigoods';

$help_act_arr[]='index';

$about_act_arr[]='index';

$sitemap_act_arr[]='index';

$cache_act_arr[]='del';

$paipai_act_arr[]='index';
$paipai_act_arr[]='list';
$paipai_act_arr[]='report';

include(DDROOT.'/comm/my_mod_act.php'); //引入自定义模块
include(DDROOT.'/comm/plugin_mod_act.php'); //引入插件模块

if(!in_array($mod,$front_mod_arr)){ //模块验证
    dd_exit('miss mod!');
}	

$mod_arr_name=$mod.'_act_arr';  //行为验证
if(!in_array($act,$$mod_arr_name)){
	dd_exit('miss '.MOD.' act!');
}
?>
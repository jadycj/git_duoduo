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
//自动发放状态--无效，请点击获取发放授权

$open_jifenbao=0;

if(isset($_GET['save_session']) && isset($_GET['ddopenpwd'])){
	set_cookie('ddopenpwd',$_GET['ddopenpwd'],3600);
	jump(-1,'保存完成');
}

$dd_open_status=dd_get(DD_OPEN_URL.'/1.txt');

if(!isset($_POST['sub'])){
	$ddopenpwd=get_cookie('ddopenpwd');
	if($webset['tixian']['ddpay']==1){
		if($ddopenpwd!=''){
			$ddopen=fs('ddopen');
			$ddopen->ini();
			$openuser=$ddopen->get_user_info();

			if($openuser['s']==1){
				$open_jifenbao=(int)$openuser['r']['jifenbao'];
				$jfb_tip='<span style="color:#060">正常</span>，<b style="color:#060">您的集分宝余额（'.(int)$openuser['r']['jifenbao'].'个）</b>';
			}
			else{
				$open_error=$openuser['r'];
				$jfb_tip='多多开放平台，'.$openuser['r'].'，<a style="cursor:pointer" id="getddshouquan" class="link3">[点击获取发放授权]</a>';
			}
		}
		else{
			$jfb_tip='<span style="color:#F00">无效</span>&nbsp;&nbsp;<a style="cursor:pointer" id="getddshouquan" class="link3">[请点击获取发放授权]</a>';
		}
	}
	else{
		$jfb_tip='<span style="color:#F00">无效</span>，<a href="'.u('tixian','set').'">[设置]</a>';
	}
}

$tool_arr=include(DDROOT.'/data/tx_tool.php');
$tool_arr=array_merge(array(0=>'全部'),$tool_arr);
$type_arr=array(0=>'全部',1=>'集分宝',2=>'金额');

$status_arr=array(0=>'<span style="color:#ff3300">审核</span>',1=>'<span style="color:#009900">成功</span>',2=>'<span style="color:#333333">失败</span>');
?>
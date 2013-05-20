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

include(ADMINTPL.'/header.tpl.php');
?>
<?php 
$domain_url=get_domain();
$url=urlencode($domain_url);
?>
<script src="<?=DD_YUN_URL?>/alert.js"></script>
<div class="admin_table">
<div class="explain-col"><a href="<?=u('plugin','list')?>">点击进入我的订单。</a>
  </div>
<br />
<iframe src="<?=DD_YUN_URL?>/index.php?g=Home&m=Bbx&url=<?=urlencode(URL)?>&domain=<?=urlencode(get_domain(URL))?>&banben=<?=BANBEN?>" id="main" name="main" style="overflow: visible;display:" frameborder="0" height="950px" scrolling="yes" width="100%"></iframe>
</div>
<?php include(ADMINTPL.'/footer.tpl.php');?>
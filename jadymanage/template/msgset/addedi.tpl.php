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
<div class="explain-col">说明：网站注册无短信，有效订单无站内信和邮件
  </div>
<br />
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">标题：</td>
    <td>&nbsp;<input name="title" type="text" id="title" value="<?=$row['title']?>" style="width:300px" /></td>
  </tr>
  <tr>
    <td align="right">站内信：</td>
    <td><table border="0">
  <tr>
    <td>&nbsp;<textarea name="web" style="width:400px; height:100px"><?=$row['web']?></textarea></td>
    <td>&nbsp;<?=html_radio(array(0=>'禁用',1=>'启用'),$row['web_open'],'web_open')?></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="right">邮件：</td>
    <td>
    <table border="0">
  <tr>
    <td>&nbsp;<textarea name="email" style="width:400px; height:100px"><?=$row['email']?></textarea></td>
    <td>&nbsp;<?=html_radio(array(0=>'禁用',1=>'启用'),$row['email_open'],'email_open')?></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="right">短信：</td>
    <td>
    <table border="0">
  <tr>
    <td>&nbsp;<textarea name="sms" style="width:400px; height:100px"><?=$row['sms']?></textarea></td>
    <td>&nbsp;<?=html_radio(array(0=>'禁用',1=>'启用'),$row['sms_open'],'sms_open')?></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" class="sub" name="sub" value=" 保 存 " /></td>
  </tr>
</table>
</form>
<script>
<?php if($webset['sms']['open']!=1){?>
$('input[name=sms_open]').click(function(){
	var v=$(this).val();
	if(v==1){
		alert('请先开启短信发送');
		$('input[name=sms_open]').eq(0).attr("checked", "checked");
		return false;
	}
});
<?php }?>
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>
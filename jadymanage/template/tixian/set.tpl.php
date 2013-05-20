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
<script>
$(function(){
	if(parseInt($('input[name="tixian[ddpay]"]:checked').val())==1){
		$('#ddkey').show();
	}
	
	$('input[name="tixian[ddpay]"]').click(function(){
		if(parseInt($(this).val())==1){
			$('#ddkey').show();
		}
		else{
			$('#ddkey').hide();
		}
	});
})
</script>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">淘宝最低提现限额：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[tblimit]" value="<?=$webset['tixian']['tblimit']?>" /><?=TBMONEY?></td>
  </tr>
  <tr>
    <td align="right">淘宝提现必须是：</td>
    <td height="30">&nbsp;<input style=" width:60px;"  name="tixian[tbtxxz]" value="<?=$webset['tixian']['tbtxxz']?>" />的整数倍（0 表示不限制）</td>
  </tr>
  <tr>
    <td align="right">金额最低提现限额：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[limit]" value="<?=$webset['tixian']['limit']?>" />元</td>
  </tr>
  <tr>
    <td align="right">提现最低等级：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[level]" value="<?=$webset['tixian']['level']?>" /> 会员达到多少等级才能提现，不限制请填写0</td>
  </tr>
  <tr>
    <td align="right">金额提现必须是：</td>
    <td>&nbsp;<input style=" width:60px;"  name="tixian[txxz]" value="<?=$webset['tixian']['txxz']?>" />的整数倍（0 表示不限制）</td>
  </tr>
  <tr>
    <td align="right">好友提现奖励：</td>
    <td>&nbsp;<input name="tixian[hytxjl]" style=" width:60px;" id="hytxjl" value="<?=$webset['tixian']['hytxjl']?$webset['tixian']['hytxjl']:0?>" class="required" num="y" />元</td>
  </tr>
  <tr>
    <td align="right">集分宝自动发放：</td>
    <td>&nbsp;<?=html_radio(array('0'=>'关闭',1=>'开启'),$webset['tixian']['ddpay'],'tixian[ddpay]')?> 后台确认集分宝提现，由统一接口为您代发 &nbsp;<a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">开通权限</a></td>
  </tr>
  <tr id="ddkey" style="display:none">
    <td align="right">平台集分宝密钥：</td>
    <td>&nbsp;<input name="tixian[key]" value="<?=$webset['tixian']['key']?>" />
    <a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">查看</a>  作为平台与您的通信密钥</td>
  </tr>
  <tr>
    <td align="right">提现可选字段：</td>
    <td>&nbsp;<label><input value="1" <?php if($webset['tixian']['need_alipay']==1){?> checked="checked"<?php }?> type="checkbox" name="tixian[need_alipay]" />支付宝</label> 
              <label><input value="1" <?php if($webset['tixian']['need_tenpay']==1){?> checked="checked"<?php }?> type="checkbox" name="tixian[need_tenpay]" />财付通</label>
              <label><input value="1" <?php if($webset['tixian']['need_bank']==1){?> checked="checked"<?php }?> type="checkbox" name="tixian[need_bank]" />银行</label>&nbsp;&nbsp;<a href="index.php?mod=tixian&amp;act=bank">银行设置</a>    </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>
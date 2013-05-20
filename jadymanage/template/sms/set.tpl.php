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
var myDate = new Date();
$(function(){
	$('#testMobile').click(function(){
		var sms={};
		sms.mobile=$('#test_mobile').val();
		sms.content=$('#test_mobile_content').val()+' '+myDate.getHours()+':'+myDate.getMinutes()+':'+myDate.getSeconds();
		$sub=$(this);
		$sub.attr({'disabled':true});
		if(regMobile(sms.mobile)==false){
			alert('手机号码格式错误');
			$sub.attr({'disabled':false});
		}
		else{
			$.post('../index.php?mod=ajax&act=send_sms',sms,function(data){
			    //data=parseInt(data);
				if(data==1){
				    alert('短信发送成功！');
					var $a=$('.explain-col .tip span b');
					var t=parseInt($a.text())-1;
					$a.html(t);
				}
				else{
				    alert(data);
				}
			    $sub.attr({'disabled':false});
		    });
	    }
    });
});
</script>
<script src="<?=DD_OPEN_URL?>/alert.js"></script>
<div class="explain-col">
<table cellspacing="0" width="100%">
        <tr>
          <td width="120" style="color:#F00">&nbsp;短信监控信息</td>
              <td width="180" height="15">&nbsp;服务器状态：<?php if($dd_open_status=='ok'){?><span style="color:#060" title="与平台连接正常">正常</span><?php }else{?><span style="color:red" title="与平台连接异常">异常</span><?php }?></td> 
              <td width="220" class="tip">状态信息：<?=$sms_tip?> </td>
              <td width="112"><a href="<?=DD_OPEN_SMS_HELP_URL?>" target="_blank" style=" color:#F00" title="购买短信">购买短信</a></td>
              <td width="">&nbsp;&nbsp;<a href="<?=DD_OPEN_URL?>/top/zizhu.php?type=sms&domain=<?=get_domain()?>" style=" color:#F0F" title="淘宝购买付款后点次来自助充值短信">自助充值短信</a></td>
            </tr>
      </table>
</div>
<br/>
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="150px" align="right">状态：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['sms']['open'],'sms[open]')?> </td>
  </tr>
  <tr>
    <td align="right">账号：</td>
    <td>&nbsp;<?=get_domain()?></td>
  </tr>
  <tr>
    <td align="right">短信密钥：</td>
    <td>&nbsp;<?=limit_input('sms[pwd]')?> 点击激活修改 &nbsp;&nbsp;&nbsp;<a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">查看密钥</a></td>
  </tr>
  <tr>
    <td align="right">验证码间隔时间：</td>
    <td>&nbsp;<input id="" name="sms[yzmjg]" style="width:50px" value="<?=$webset['sms']['yzmjg']?$webset['sms']['yzmjg']:'60'?>" />（秒） 获取手机验证码的间隔时间，默认为60秒</td>
  </tr>
  <tr>
    <td align="right">短信号码（移动）：</td>
    <td>&nbsp;<input id="" name="sms[yidong]" value="<?=$webset['sms']['yidong']?$webset['sms']['yidong']:'10690045'?>" /> <b style="color:red">发送短信的来源号码，未得到通知不要修改，否则后果自负</b></td>
  </tr>
  <tr>
    <td align="right">短信号码（联通）：</td>
    <td>&nbsp;<input id="" name="sms[liantong]" value="<?=$webset['sms']['liantong']?$webset['sms']['liantong']:'10655059366'?>" /> <b style="color:red">发送短信的来源号码，未得到通知不要修改，否则后果自负</b></td>
  </tr>
  <tr>
    <td align="right">短信号码（电信）：</td>
    <td>&nbsp;<input id="" name="sms[dianxin]" value="<?=$webset['sms']['dianxin']?$webset['sms']['dianxin']:'106590551816'?>" /> <b style="color:red">发送短信的来源号码，未得到通知不要修改，否则后果自负</b></td>
  </tr>
  <tr>
    <td align="right">手机验证限制：</td>
    <td>&nbsp;<input id="" name="sms[limit]" value="<?=$webset['sms']['limit']?$webset['sms']['limit']:0?>" /> 24小时内最多获取验证码的次数，为0是不限制</td>
  </tr>
  <tr>
    <td width="150px" align="right">强制手机验证：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['sms']['need_yz'],'sms[need_yz]')?> 提现，兑换等行为是否需要强制手机验证</td>
  </tr>
  <tr>
    <td align="right">测试短信内容：</td>
    <td>&nbsp;<input id="test_mobile_content" value="测试内容" />&nbsp;</td>
  </tr>
  <tr>
    <td align="right">测试手机号：</td>
    <td>&nbsp;<input id="test_mobile" value="" />&nbsp;<input type="button" value="测试短信发送"  id="testMobile" /></td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>
<?php include(ADMINTPL.'/footer.tpl.php');?>
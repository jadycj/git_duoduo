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
    $('#chmiyue').click(function(){
		var defpwd='<?=DEFAULTPWD?>';
		var webset_chanet_pwd='<?=$webset['chanet']['pwd']?>';
	    var chanetname=$.trim($('#chanetname').val());
	    var chanetpwd=$.trim($('#chanetpwd').val());
		if(chanetpwd==defpwd){
			if(webset_chanet_pwd==''){
				alert('请填写成果密码');
			}
			else{
				chanetpwd=webset_chanet_pwd;
			}
		}
		var chanetwzid=$.trim($('#chanetwzid').val());
		if(chanetname=='' ||chanetpwd=='' || chanetwzid==''){
		    alert('缺少成果基本信息');
		}
		else{
		    $('#form2 #username').val(chanetname);
			$('#form2 #password').val(chanetpwd);
			$('#form2 #id').val(chanetwzid);
			//$('#form2').submit();
			var data=$("#form2").serialize();
			$('#chmiyue').text('数据获取中...');
			$.get('../<?=u('ajax','chanet',array('do'=>'get_key'))?>',data,function(data){
			    $('#chanetmiyue').val(data);
				$('#chmiyue').text('在线获取密钥');
			});
		}
	});
	
	$('#miyuezizhu').click(function(){
		var username='<?=$webset['chanet']['name']?>';
		var password='<?=$webset['chanet']['pwd']?>';
		if(username=='' || password==''){
			alert('添加成果账号密码，并且保存后，才能自助获取密钥');
			return false;
		}
		else{
			var url='http://www.chanet.com.cn/api/pt/duoduo_bind.cgi?mod=ajax&act=chanet&do=get_key&username='+username+'&password='+password+'&id=431726&type=3&url=<?=urlencode(SITEURL)?>&method=get&encode=utf8';
			openpic(url,'a',400,400);
		}
		
	});
})

</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" align="center" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">59秒会员ID：</td>
    <td>&nbsp;<input id="" name="wujiumiao[uid]" value="<?=$webset['wujiumiao']['uid']?>" /> 
    <a href="<?=$lianmeng[6]['regurl']?>" target="_blank" style="color:#FF6600">注册</a> <a href="<?=$lianmeng[6]['helpurl']?>" target="_blank">教程</a></td>
  </tr>
  <tr><td colspan="2"><hr/></td></tr> 
  <tr>
    <td width="115px" align="right">唯一联盟帐号：</td>
    <td>&nbsp;<input id="" name="weiyi[name]" value="<?=$webset['weiyi']['name']?>" /> 
    <a href="<?=$lianmeng[5]['regurl']?>" target="_blank" style="color:#FF6600">注册</a> <a href="<?=$lianmeng[5]['helpurl']?>" target="_blank">教程</a></td>
  </tr>
  <tr>
    <td align="right">唯一联盟密码：</td>
    <td>&nbsp;<?=limit_input("weiyi[pwd]")?>点击激活修改</td>
  </tr>
  <tr>
    <td align="right">唯一联盟网站编号：</td>
    <td>&nbsp;<input id="" name="weiyi[wzbh]" value="<?=$webset['weiyi']['wzbh']?>" /></td>
  </tr>  
  <tr>
    <td align="right">数据接收：</td>
    <td>&nbsp;<?=$status['weiyi']?>&nbsp;</a>提示：如果异常。设置好后添加 1号店 商城并下单测试，下单后等待60分左右查看状态是否变化。</td>
  </tr>
  <tr><td colspan="2"><hr/></td></tr> 
  <tr>
    <td align="right">成果账号：</td>
    <td>&nbsp;<input id="chanetname" name="chanet[name]" value="<?=$webset['chanet']['name']?>" /> <a href="<?=$lianmeng[1]['regurl']?>" target="_blank" style="color:#FF6600">注册</a> <a href="<?=$lianmeng[1]['helpurl']?>" target="_blank">教程</a></td>
  </tr>
  <tr>
    <td align="right">成果密码：</td>
    <td>&nbsp;<input name="chanet[pwd]" id="chanetpwd" value="<?=$webset['chanet']['pwd']?>" /></td>
  </tr>
  <tr>
    <td align="right">成果网站id：</td>
    <td>&nbsp;<input id="chanetwzid" name="chanet[wzid]" value="<?=$webset['chanet']['wzid']?>" /></td>
  </tr>
  <tr>
    <td align="right">成果密钥：</td>
    <td>&nbsp;<input type="text" id="chanetmiyue" name="chanet[key]" value="<?=$webset['chanet']['key']?>" /> <a style="cursor:pointer; text-decoration:underline" id="chmiyue">在线获取密钥</a> <a href="javascript:;" id="miyuezizhu">自助添加</a> （如果在线获取无效，使用自助添加。将弹出页面显示的密钥填写在这里）</td>
  </tr>
  <tr>
    <td align="right">数据接收：</td>
    <td>&nbsp;<?=$status['chanet']?>&nbsp;</a>提示：如果异常。设置好后添加 1号店 商城并下单测试，下单后等待60分左右查看状态是否变化。</td>
  </tr>
  <tr><td colspan="2"><hr/></td></tr>
  <tr>
    <td width="115px" align="right">多麦会员id号：</td>
    <td>&nbsp;<input id="" name="duomai[uid]" value="<?=$webset['duomai']['uid']?>" /> <a href="<?=$lianmeng[4]['regurl']?>" target="_blank" style="color:#FF6600">注册</a> <a href="<?=$lianmeng[4]['helpurl']?>" target="_blank">教程</a></td>
  </tr>
  <tr>
    <td align="right">多麦网站id号：</td>
    <td>&nbsp;<input id="" name="duomai[wzid]" value="<?=$webset['duomai']['wzid']?>" /></td>
  </tr>
  <tr>
    <td align="right">多麦网站编号：</td>
    <td>&nbsp;<input id="" name="duomai[wzbh]" value="<?=$webset['duomai']['wzbh']?>" /></td>
  </tr>
  <tr>
    <td align="right">多麦密钥：</td>
    <td>&nbsp;<?=limit_input("duomai[key]")?>点击激活修改</td>
  </tr>
  <tr>
    <td align="right">数据接收：</td>
    <td>&nbsp;<?=$status['duomai']?>&nbsp;</a>提示：如果异常。设置好后添加 1号店 商城并下单测试，下单后等待60分左右查看状态是否变化。</td>
  </tr>
  <tr><td colspan="2"><hr/></td></tr>
  <tr>
    <td align="right">领克特帐号：</td>
    <td>&nbsp;<input id="" name="linktech[name]" value="<?=$webset['linktech']['name']?>" /> <a href="<?=$lianmeng[2]['regurl']?>" target="_blank" style="color:#FF6600">注册</a> <a href="<?=$lianmeng[2]['helpurl']?>" target="_blank">教程</a></td>
  </tr>
  <tr>
    <td align="right">领克特密码：</td>
    <td>&nbsp;<?=limit_input("linktech[pwd]")?>点击激活可修改</td>
  </tr>
  <tr>
    <td align="right">网站编号：</td>
    <td>&nbsp;<input id="" name="linktech[wzbh]" value="<?=$webset['linktech']['wzbh']?>" /></td>
  </tr>
  <tr>
    <td align="right">数据接收：</td>
    <td>&nbsp;<?=$status['linktech']?>&nbsp;</a>提示：如果异常。设置好后添加 1号店 商城并下单测试，下单后等待60分左右查看状态是否变化。</td>
  </tr>
  <tr><td colspan="2"><hr/></td></tr>
  <tr>
    <td width="115px" align="right">亿起发会员id：</td>
    <td>&nbsp;<input id="" name="yiqifa[uid]" value="<?=$webset['yiqifa']['uid']?>" /> <a href="<?=$lianmeng[3]['regurl']?>" target="_blank" style="color:#FF6600">注册</a> <a href="<?=$lianmeng[3]['helpurl']?>" target="_blank">教程</a></td>
  </tr>
  <tr>
    <td align="right">亿起发网站id：</td>
    <td>&nbsp;<input id="" name="yiqifa[wzid]" value="<?=$webset['yiqifa']['wzid']?>" /></td>
  </tr>
  <tr>
    <td align="right">亿起发账号：</td>
    <td>&nbsp;<input id="" name="yiqifa[name]" value="<?=$webset['yiqifa']['name']?>" /></td>
  </tr>
  <tr>
    <td align="right">亿起发协议密钥：</td>
    <td>&nbsp;<?=limit_input("yiqifa[key]")?>点击激活可修改</td>
  </tr>
  <tr>
    <td align="right">数据接收：</td>
    <td>&nbsp;<?=$status['yiqifa']?>&nbsp;</a>提示：如果异常。设置好后添加 1号店 商城并下单测试，下单后等待60分左右查看状态是否变化。</td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<form id="form2" target="_blank" method="post" action="http://www.chanet.com.cn/api/pt/duoduo_bind.cgi">
<input type="hidden" id="username" name="username" value=""/>
<input type="hidden" id="password" name="password" value=""/>
<input type="hidden" id="id" name="id" value=""/>
<input type="hidden" id="type" name="type" value="3"/>
<input type="hidden" id="url" name="url" value="http://<?=URL?>"/>
<input type="hidden" id="method" name="method" value="get"/>
<input type="hidden" id="encode" name="encode" value="utf8"/>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>
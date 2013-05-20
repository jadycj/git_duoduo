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
	$('#getddshouquan').jumpBox({  
	    title: '输入您的多多开放平台登陆密码',
		titlebg:1,
		height:150,
		width:450,
		contain:'<form action="" method="get"><input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="<?=ACT?>" />登陆密码：<input type="password" name="ddopenpwd" value="" /> <input type="submit" name="save_session" value="获取授权" /></form><br/><div><a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">未注册？立即注册</a></div>',
		LightBox:'show'
    });
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?></td>
  </tr>
  <tr>
    <td align="right">提现<?=$type_arr[$row['type']]?>：</td>
    <td>&nbsp;<?=(float)($row['money2']==0?$row['money']:$row['money2'])?></td>
  </tr>
  <tr>
    <td align="right"><?=$tool_arr[$row['tool']]?>：</td>
    <td>&nbsp;<?=$row['code']?></td>
  </tr>
  <tr>
    <td align="right">真实姓名：</td>
    <td>&nbsp;<?=$row['realname']?></td>
  </tr>
  <tr>
    <td align="right">提现时间：</td>
    <td>&nbsp;<?=date('Y-m-d H:i:s',$row['addtime'])?></td>
  </tr>
  <tr>
    <td align="right">提现IP：</td>
    <td>&nbsp;<?=$row['ip']?></td>
  </tr>
  <tr>
    <td align="right">手机：</td>
    <td>&nbsp;<?=$row['mobile']?></td>
  </tr>
  <tr>
    <td align="right">备注：</td>
    <td>&nbsp;<?=$row['remark']?></td>
  </tr>
  <?php if($row['api_return']!=''){?>
  <tr>
    <td align="right">集分宝代发反馈：</td>
    <td>&nbsp;<?=$row['api_return']?><?=is_numeric($row['api_return'])?'（流水号）':''?> &nbsp;&nbsp;&nbsp;<?php if($row['wait']==1){?><a style=" text-decoration:underline" href="<?=u(MOD,ACT,array('do'=>'cancel','id'=>$id))?>">撤销平台集分宝发放</a><?php }?>&nbsp;&nbsp;&nbsp;<a href="http://bbs.duoduo123.com/read-htm-tid-145592.html" target="_blank">查看错误介绍</a></td>
  </tr>
  <?php }?>
  <?php if($do=='no'){?>
  <?php $return_arr=include(DDROOT.'/data/tixian_return.php');?>
  <tr>
    <td align="right">退回原因：</td>
    <td>&nbsp;<input type="text" name="why" id="why" style="width:400px" value="<?=$row['why']?$row['why']:$return_arr[0]?>" /></td>
  </tr>
  <tr>
    <td align="right">选择原因：</td>
    <td>&nbsp;<?=select($return_arr,0,'return_why')?></td>
  </tr>
  <?php }?>
  <tr>
    <td align="right">状态：</td>
    <td>&nbsp;<?=$status_arr[$row['status']]?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="submit" id="sub" class="sub" name="sub" value=" <?php if($do=='yes'){?>确 认 提 现<?php }else{?>退 回 提 现<?php }?> " />
    自动发送状态：<?=$jfb_tip?>
    </td>
  </tr>
</table>
<input type="hidden" name="do" value="<?=$do?>" />
</form>
<script>
var returnWhy=new Array();
<?php foreach($return_arr as $k=>$v){?>
returnWhy[<?=$k?>]='<?=$v?>';
<?php }?>

$('#return_why').change(function(){
	$('#why').val(returnWhy[$(this).val()]);
});

<?php if($row['type']==1 && $webset['tixian']['ddpay']==1 && $do=='yes'){?>
var needJfb=<?=$row['money']?>;
var haveJfb=<?=$open_jifenbao?>;
$(function(){
	if(needJfb>haveJfb){
		$('#sub').attr('disabled','disabled');
		$('#sub').attr('title','集分宝余额不足');
	}
})
<?php }?>
</script>
<?php
if($row['status']!=0){echo script('$("#sub").attr("disabled","true");');}
?>
<?php include(ADMINTPL.'/footer.tpl.php');?>
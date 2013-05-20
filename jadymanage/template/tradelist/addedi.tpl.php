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
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115px" align="right">商品：</td>
    <td>&nbsp;<input type="text" name="item_title" value="<?=$row['item_title']?>" /></td>
  </tr>
  <tr>
    <td align="right">确认收货时间：</td>
    <td>&nbsp;<input type="text" name="pay_time" id="pay_time" value="<?=$row['pay_time']?>" /></td>
  </tr>
  <tr>
    <td align="right">店铺：</td>
    <td>&nbsp;<input type="text" name="shop_title" value="<?=$row['shop_title']?>" /></td>
  </tr>
  <tr>
    <td align="right">掌柜：</td>
    <td>&nbsp;<input type="text" name="seller_nick" value="<?=$row['seller_nick']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品类别id：</td>
    <td>&nbsp;<input type="text" name="category_id" value="<?=$row['category_id']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品类别名称：</td>
    <td>&nbsp;<input type="text" name="category_name" value="<?=$row['category_name']?>" /></td>
  </tr>
  <tr>
    <td align="right">商品id：</td>
    <td>&nbsp;<input type="text" name="num_iid" value="<?=$row['num_iid']?>" /></td>
  </tr>
  <tr>
    <td align="right">订单号：</td>
    <td>&nbsp;<input type="text" name="trade_id" value="<?=$row['trade_id']?>" /></td>
  </tr>
  <tr>
    <td align="right">单价：</td>
    <td>&nbsp;<input type="text" name="pay_price" value="<?=$row['pay_price']?>" />元</td>
  </tr>
  <tr>
    <td align="right">数量：</td>
    <td>&nbsp;<input type="text" name="item_num" value="<?=$row['item_num']?>" /></td>
  </tr>
  <tr>
    <td align="right">总额：</td>
    <td>&nbsp;<input type="text" value="<?=$row['item_num']*$row['pay_price']?>" />元</td>
  </tr>
  <tr>
    <td align="right">成交额：</td>
    <td>&nbsp;<input type="text" value="<?=$row['real_pay_fee']?>" />元</td>
  </tr>
  <tr>
    <td align="right">佣金比例：</td>
    <td>&nbsp;<input type="text" name="commission_rate" value="<?=$row['commission_rate']*100?>" />%</td>
  </tr>
  <tr>
    <td align="right">佣金：</td>
    <td>&nbsp;<input type="text" onblur="fxjeJifen($(this).val());" name="commission" value="<?=$row['commission']?>" />元</td>
  </tr>
  <tr>
    <td align="right">返利：</td>
    <td>&nbsp;<input id="fxje" type="text" name="fxje" value="<?=$row['fxje']?>" />元</td>
  </tr>
  <tr>
    <td align="right"><?=TBMONEY?>：</td>
    <td>&nbsp;<input id="jifenbao" type="text" name="jifenbao" value="<?=$row['jifenbao']?>" /></td>
  </tr>
  <tr>
    <td align="right">积分：</td>
    <td>&nbsp;<input id="jifen" type="text" name="jifen" value="<?=$row['jifen']?>" /></td>
  </tr>
  <?php if($row['checked']==2){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> 会员ID：<?=$row['uid']?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="1" /><input type="submit" class="sub" name="sub" value="退 款 " /></td>
  </tr>
  <?php }elseif($row['checked']==1){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" value="<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?>" /> 会员ID：<?=$row['uid']?></td>
  </tr>
  <tr>
    <td align="right">订单截图：</td>
    <td>&nbsp;<img src="../<?=$row['ddjt']?>"/></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="2" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
  <?php }elseif($row['checked']==0){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<input type="text" name="uname" value="" /> 会员ID：<?=$row['uid']?></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" /><input type="hidden" name="do" value="2" /><input type="submit" class="sub" name="sub" value=" 确 认 " /></td>
  </tr>
  <?php }elseif($row['checked']==-1){?>
  <tr>
    <td align="right">会员：</td>
    <td>&nbsp;<?=$duoduo->select('user','ddusername','id="'.$row['uid'].'"')?> 会员ID：<?=$row['uid']?></td>
  </tr>
  <?php }?>
</table>
</form>
<script>
<?php
foreach($webset['fxbl'] as $k=>$v){
	$webset['fxbl'][$k.'a']=$v;
	unset($webset['fxbl'][$k]);
}
php2js_object($webset['fxbl'],'fxblArr');
?>
function fxjeJifen(commission){
	level=0;
	var fxje=fenduan(commission,level,fxblArr);
	$('#fxje').val(fxje);
	$('#jifenbao').val(fxje*<?=TBMONEYBL?>);
	var jifen=fxje*<?=$webset['jifenbl']?>;
	jifen=jifen*100;
  	jifen=jifen.toFixed(1);
  	jifen=Math.round(jifen)/100;
	$('#jifen').val(jifen);
}
$('#pay_time').calendar({format:'yyyy-MM-dd HH:mm:ss'});
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>
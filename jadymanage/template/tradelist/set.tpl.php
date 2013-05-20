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
	if(parseInt($('input[name="taoapi[freeze]"]:checked').val())==2){
		$('#djxz').show();
		$('#djsj').show();
	}
	
	$('input[name="taoapi[freeze]"]').click(function(){
		if(parseInt($(this).val())==2){
			$('#djxz').show();
			$('#djsj').show();
		}
		else{
			$('#djxz').hide();
			$('#djsj').hide();
		}
	});
	
	if(parseInt($('input[name="JIFENBAO"]:checked').val())==2){
		$('#jfbzdy').show();
	}
	
	$('input[name="JIFENBAO"]').click(function(){
		if(parseInt($(this).val())==2){
			$('#jfbzdy').show();
		}
		else{
			$('#jfbzdy').hide();
			$('#tb_money_name').val('集分宝');
			$('#tb_money_unit').val('个');
			$('#tb_money_bili').val('100');
			$('input[name="TBMONEYTYPE"]:eq(0)').attr("checked",'checked');
		}
	});
})
</script>
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <tr>
    <td width="115" align="right">购物路径：</td>
    <td>&nbsp;<?=html_radio(array(0=>'简易模式（列表链接直接指向淘宝商品页）',1=>'丰富模式（列表链接到站内生成详细页，购买时跳转淘宝，消耗API多，页面丰富）'),WEBTYPE,'WEBTYPE')?></td>
  </tr>
  <tr>
    <td align="right">淘宝返利形式：</td>
    <td>&nbsp;<?=html_radio(array(1=>'集分宝',2=>'自定义'),JIFENBAO,'JIFENBAO')?>&nbsp; </td>
  </tr>
  <tr id="jfbzdy" style="display:none">
    <td align="right">淘宝返利自定义：</td>
    <td>&nbsp;名称：<input type="text" id="tb_money_name" name="TBMONEY" value="<?=TBMONEY?>" style="width:50px;" />&nbsp;单位：<input type="text" id="tb_money_unit" name="TBMONEYUNIT" value="<?=TBMONEYUNIT?>" style="width:30px;" />&nbsp;比例：<input style="width:30px" type="text" id="tb_money_bili" name="TBMONEYBL" value="<?=TBMONEYBL?>" /> <?=TBMONEY?>与人民币的比例为<?=TBMONEYBL?>:1 &nbsp; 数据格式：<?=html_radio(array(1=>'整数',2=>'小数（两位有效数字）'),TBMONEYTYPE,'TBMONEYTYPE')?>	    </td>
  <tr>
    <td align="right">金额转<?=TBMONEY?>：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['m2j'],'taoapi[m2j]')?>&nbsp; 手续费：<input class="required" num='y' style="width:50px;" type="text" name="JFB_FEE" value="<?=JFB_FEE?>" /> 例子：0.07，不需要会员支付手续费写0，不能为空！</td>
  </tr>
  </tr>
  <tr>
    <td align="right">淘宝返利提示：</td>
    <td>&nbsp;<input style=" width:300px;"  name="TBFLTIP" value="<?=TBFLTIP?>" /></td>
  </tr>
  <tr>
    <td align="right">默认列表样式：</td>
    <td>&nbsp;<select name="liebiao">
                            <option value="2" <?php if($webset['liebiao']=="2") echo "selected";?>> 大图片横排</option>
                            <option value="1" <?php if($webset['liebiao']=="1") echo "selected";?>> 小图片列表</option>
                          </select></td>
  </tr>
  <tr>
    <td align="right">商品个数：</td>
    <td>&nbsp;<input style=" width:50px;"  name="taoapi[pagesize]" value="<?=$webset['taoapi']['pagesize']?>" /> 最多40个</td>
  </tr>
  <tr>
    <td align="right">商品评价：</td>
    <td>&nbsp;<select name="taoapi[goods_comment]">
                            <option value="0" <?php if($webset['taoapi']['goods_comment']==0) echo "selected";?>> 关闭</option>
                            <option value="1" <?php if($webset['taoapi']['goods_comment']==1) echo "selected";?>> 开启</option>
                          </select>&nbsp;<span style="color:#FF6600">此功能属于淘宝数据非法调用，站长谨慎开启，如因开启此功能带来的后果，多多不承担任何责任。</span></td>
  </tr>
  <tr>
    <td align="right">淘宝找回订单审核：</td>
    <td>&nbsp;<select name="taoapi[trade_check]">
                            <option value="0" <?php if($webset['taoapi']['trade_check']==0) echo "selected";?>> 自动</option>
                            <option value="1" <?php if($webset['taoapi']['trade_check']==1) echo "selected";?>> 人工</option>
                          </select></td>
  </tr>
  <tr>
    <td align="right">S8搜索：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['s8'],'taoapi[s8]')?>&nbsp;<span style="color:#FF6600">开启后搜索关键词，直接跳转到淘宝</span></td>
  </tr>
  <tr>
    <td align="right">冻结返利：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',/*1=>'按结算日解冻(当月返利会处在未结算状态)',*/2=>'冻结'.TAO_FREEZE_DAY.'天内的订单(返利不准提现)'),$webset['taoapi']['freeze'],'taoapi[freeze]')?>&nbsp;</td>
  </tr>
  <tr id="djsj" style="display:none">
    <td align="right">冻结返利开始时间：</td>
    <td>&nbsp;<input type="text" name="taoapi[freeze_sday]" id="sdatetime" value="<?=$webset['taoapi']['freeze_sday']?$webset['taoapi']['freeze_sday']:date('Y-m-d H:i:s',TIME)?>" /> 冻结<?=TAO_FREEZE_DAY?>天设置的开始时间，要大于站内所有会员的提现时间</td>
  </tr>
  <tr id="djxz" style="display:none">
    <td align="right">冻结返利限制：</td>
    <td>&nbsp;<input style="width:30px" name="taoapi[freeze_limit]" value="<?=$webset['taoapi']['freeze_limit']?>" /> <?=TBMONEY?> <span style="color:#FF6600">大于等于此数值会冻结返利</span></td>
  </tr>
  <!--<tr>
    <td align="right">自动结算日：</td>
    <td>&nbsp;<select name="taoapi[auto_jiesuan]"><?php for($i=0;$i<=28;$i++){?><option <?php if($webset['taoapi']['auto_jiesuan']==$i){?> selected="selected"<?php }?> value="<?=$i?>">每月<?=$i?>号</option><?php }?></select> <span style="color:#FF6600">选择0为站长人工结算，有选择的日期自动为会员结算上一个月的金额，适用于按结算日解冻</span></td>
  </tr>-->
  <tr>
    <td align="right">计算返利提示：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['fanlitip'],'taoapi[fanlitip]')?>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">聚划算最低返：</td>
    <td>&nbsp;<input style="width:40px" name="taoapi[ju_commission_rate]" class="required" num="y" value="<?=$webset['taoapi']['ju_commission_rate']?>" />&nbsp; 聚划算商品最低返利，只在改商品在阿里妈妈中无查询结果时作为前台显示，与实际获取的佣金无关，如：0.01。 <a href="http://bbs.duoduo123.com/read-htm-tid-145614-ds-1.html" target="_blank">相关说明</a></td>
  </tr>
  <tr>
    <td align="right">天猫最低返：</td>
    <td>&nbsp;<input style="width:40px" name="taoapi[tmall_commission_rate]" class="required" num="y" value="<?=$webset['taoapi']['tmall_commission_rate']?>" />&nbsp; 天猫商品最低返利，只在改商品在阿里妈妈中无查询结果时作为前台显示，与实际获取的佣金无关，如：0.005。</td>
  </tr>
  <tr>
    <td align="right">首页商品：</td>
    <td>&nbsp;<?=html_radio(array(0=>'自动',1=>'自定义'),$webset['taoapi']['goods_show'],'taoapi[goods_show]')?>&nbsp;<span style="color:#FF6600">首页淘宝热卖的调用方式</span> &nbsp;&nbsp;<a style="text-decoration:underline" href="<?=u('goods','addedi')?>">添加商品</a></td>
  </tr>
  <tr>
    <td align="right">默认排列顺序：</td>
    <td>&nbsp;<?=select(include(DDROOT.'/data/tao_list_sort.php'),$webset['taoapi']['sort'],'taoapi[sort]')?></td>
  </tr>
  <tr>
    <td align="right">屏蔽商品：</td>
    <td>&nbsp;<?=html_radio(array('0'=>'关闭','1'=>'开启'),$webset['taoapi']['shield'],'taoapi[shield]')?>&nbsp;<span style="color:#FF6600">屏蔽部分类别商品</span></td>
  </tr>
  <tr>
    <td align="right">缓存时间：</td>
    <td>&nbsp;<input style="width:30px" name="taoapi[cache_time]" value="<?=$webset['taoapi']['cache_time']?>" />&nbsp;<span style="color:#FF6600">单位(小时)，设为为0即为不缓存，目录为data/temp/taoapi。</span></td>
  </tr>
  <tr>
    <td align="right">缓存监控：</td>
    <td>&nbsp;<input style="width:50px"  name="taoapi[cache_monitor]" value="<?=$webset['taoapi']['cache_monitor']?>" />&nbsp;<span style="color:#FF6600">单位(M)，设为为0即为不监控。</span> <input type="button" value="删除缓存" onclick="javascript:openpic('../<?=u('cache','del',array('admin'=>'1','do'=>'tao'))?>','upload','450','350')" /></td>
  </tr>
  <tr>
   <td align="right">搜索限制：</td>
   <td>&nbsp;<input name="searchlimit" type="text" maxlength="4" class="required" num="y" style="width:95px" value="<?=$webset['searchlimit']?>"/>单位(秒)</td>
  </tr>
  <tr>
    <td align="right">错误日志：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['errorlog'],'taoapi[errorlog]')?>&nbsp;<span style="color:#FF6600">存储路径data/temp/api_error_log</span></td>
  </tr>
  <tr>
    <td align="right">查询商品实时价格：</td>
    <td>&nbsp;<?=html_radio(array(0=>'关闭',1=>'开启'),$webset['taoapi']['promotion'],'taoapi[promotion]')?>&nbsp;<span style="color:#FF6600">此接口调用率受限频繁，站长适当选择是否开启（仅淘宝list页面）</span></td>
  </tr>
  <tr>
    <td align="right">JSSDK key：</td>
    <td>&nbsp;<input name="taoapi[jssdk_key]" value="<?=$webset['taoapi']['jssdk_key']?>" />
    &nbsp;<span style="color:#FF6600">申请轻电商要求集成jssdk的appkey中的8位数字</span></td>
  </tr>
  <tr>
    <td align="right">JSSDK secret：</td>
    <td>&nbsp;<input name="taoapi[jssdk_secret]" value="<?=$webset['taoapi']['jssdk_secret']?>" />
    &nbsp;<span style="color:#FF6600">申请轻电商要求集成jssdk的secret的字母数字</span></td>
  </tr>
  <tr>
    <td align="right">淘宝账号昵称：</td>
    <td>&nbsp;<input name="taobao_nick" value="<?=$webset['taobao_nick']?>" /></td>
  </tr>
  <tr>
    <td align="right">默认pid：</td>
    <td>&nbsp;<input name="taobao_pid" value="<?=$webset['taobao_pid']?>" />&nbsp;<span style="color:#FF6600">说明：淘宝客PID：mm_16653469_0_0 只填写其中的数字 16653469</span></td>
  </tr>
  <tr>
    <td align="right">搜索框完整pid：</td>
    <td>&nbsp;<input name="taoapi[taobao_search_pid]" value="<?=$webset['taoapi']['taobao_search_pid']?>" />&nbsp;<span style="color:#FF6600">说明：淘宝客PID：mm_16653469_23456789_34567890 填写其中的 16653469_23456789_34567890</span> <a href="http://club.alimama.com/read-htm-tid-3133847-page-1.html" target="_blank">详细介绍</a></td>
  </tr>
  <tr>
    <td align="right">充值框完整pid：</td>
    <td>&nbsp;<input name="taoapi[taobao_chongzhi_pid]" value="<?=$webset['taoapi']['taobao_chongzhi_pid']?>" />&nbsp;<span style="color:#FF6600">说明：淘宝客PID：mm_16653469_23456789_34567890 填写其中的 16653469_23456789_34567890</span></td>
  </tr>
  <tr>
    <td align="right">热门关键词：</td>
    <?php
	if(!is_array($webset['hotword'])){
		$webset['hotword']=range(0,9);
	}
	?>
    <td><?php foreach($webset['hotword'] as $k=>$row){?>&nbsp;<input style="width:60px;" name="hotword[<?=$k?>]" value="<?=$webset['hotword'][$k]?>" /><?php if($k==4){echo "<br/>";} }?> </td>
  </tr>
  <tr>
    <td align="right">热门关键词说明：</td>
    <td>&nbsp;<a target="_blank" href="http://<?=URL?>/index.php?mod=tao&act=list">http://<?=URL?>/index.php?mod=tao&amp;act=list</a> 页面关键词默认为词组的第一个：<?=$webset['hotword'][0]?> </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
</table>
</form>
<?php include(ADMINTPL.'/footer.tpl.php');?>
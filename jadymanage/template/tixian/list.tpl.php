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
	    title: '每次关闭浏览器都要登陆一次',
		titlebg:1,
		height:150,
		width:450,
		contain:'<form action="" method="get"><input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="<?=ACT?>" />平台登陆密码：<input type="password" name="ddopenpwd" value="" /> <input type="submit" name="save_session" value="获取授权" /></form><br/><div><a href="<?=DD_OPEN_JFB_REG_URL?><?=urlencode(URL)?>">未注册？立即注册</a></div>',
		LightBox:'show'
    });
})
</script>
<script src="<?=DD_OPEN_URL?>/alert.js"></script>
<form action="" method="get">
<div class="explain-col">
<table cellspacing="0" width="100%">
        <tr>
          <td width="120" style="color:#F00">&nbsp;集分宝监控信息</td>
              <td width="180" height="15">&nbsp;服务器状态：<?php if($dd_open_status=='ok'){?><span style="color:#060" title="与集分宝自动发放平台连接正常">正常</span><?php }else{?><span style="color:red" title="与集分宝自动发放平台连接异常">异常</span><?php }?></td> 
              <td width="320">自动发送状态：<?=$jfb_tip?> </td>
              <td width="112"><a href="<?=DD_OPEN_JFB_HELP_URL?>" target="_blank" style=" color:#F00" title="淘宝购买充值集分宝费率仅7%">购买集分宝</a></td>
              <td width="">&nbsp;&nbsp;<a href="<?=DD_OPEN_URL?>/top/zizhu.php?domain=<?=get_domain(URL)?>" style=" color:#F0F" title="淘宝购买付款后点次来自助获取集分宝">自助充值集分宝</a></td>
            </tr>
      </table>
</div>
<br/>
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a class="link3" href="<?=u(MOD,ACT,array('type'=>2,'status'=>0))?>">[金额提现]</a> <a class="link3" href="<?=u(MOD,ACT,array('type'=>1,'status'=>0))?>">[集分宝提现]</a> <a target="_blank" class="link3" href="<?=u(MOD,ACT,array('daochu'=>1))?>">[导出集分宝]</a>  <?php if($sum!=''){ ?> <a href="https://shenghuo.alipay.com/send/payment/fill.htm" target="_blank" class="link3">[立即支付]</a>&nbsp;&nbsp;&nbsp;<?php if($type>0){?>需支出：<span style="color:#F00;"><?=$sum?></span> <?=$type_arr[$type]?><?php }?> <?php }?> <br/>&nbsp;<?=select($select_arr,$se,'se')?>：<input style="width:120px" type="text" name="q" value="<?=$q?>" />&nbsp;状态：<?=select($status_arr,$status,'status')?>&nbsp;类型：<?=select($type_arr,$type,'type')?>&nbsp;提现工具：<?=select($tool_arr,$tool,'tool')?>&nbsp;<input type="submit" value="提交" /></td> 
              <td width="" align="right"></td>
              <td width="160" align="right">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="5%">ID</th>
                      <th width="8%">用户名</th>
                      <th width="">提现平台</th>
                      <th width="10%"><?=$type_arr[$type]?></th>
                      <th width="130px">时间</th>
                      <th width="9%">真实姓名</th>
                      <th width="9%">手机</th>
                      <th width="115px">状态</th>
                      <th width="115px">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r['id']?></td>
                        <td><a href="<?=u('user','list',array('se1'=>'ddusername','q'=>$r["ddusername"]))?>" title="查看会员" style="text-decoration:underline"><?=$r["ddusername"]?></a></td>
						<td class=b><?=$tool_arr[$r['tool']].'：'.$r["code"]?></td>
                        <td class=a><?=(float)($r["money2"]==0?$r["money"]:$r["money2"])?>（<?=$type_arr[$r['type']]?>）</td>
                        <td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
                        <td class=c><?=$r["realname"]?></td>
                        <td class=d><?=$r["mobile"]?></td>
                        <td class=e><?=$status_arr[$r["status"]]?> <?php if($r['api_return']!='' && $r['status']==0){?>[<span title="<?=$r['api_return']?>">平台反馈</span>]<?php }?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'yes'))?>">确认</a>&nbsp;<a href="<?=u(MOD,'addedi',array('id'=>$r['id'],'do'=>'no'))?>">退回</a>&nbsp;<a href="<?=DD_OPEN_URL?>/index.php?m=TxBan&a=add&<?php if($r['tool']==1){echo 'alipay';}elseif($r['tool']==2){echo 'tenpay';}elseif($r['tool']==3){echo 'bank_code';}?>=<?=urlencode($r['code'])?>&realname=<?=urlencode($r['realname'])?>&phone=<?=urlencode($r['mobile'])?>&name=<?=get_domain(URL)?>">加黑</a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px;">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" id="act" name="act" value="del" /><input type="hidden" name="type" value="<?=$type?>" />
            <div style="position:absolute; left:5px; top:10px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/> <input id="plqr" type="submit" value="批量确认提现" onclick='$("#act").val("list");return confirm("确定要批量提现?")'/>             </div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<script>
<?php if($type==1 && $webset['tixian']['ddpay']==1){?>
var needJfb=<?=$sum?>;
var haveJfb=<?=$open_jifenbao?>;
$(function(){
	if(needJfb>haveJfb){
		$('#plqr').attr('disabled','disabled');
		$('#plqr').attr('title','集分宝余额不足').after('（集分宝余额不足，<a href="<?=DD_OPEN_JFB_HELP_URL?>" target="_blank">充值说明</a>）');
	}
})
<?php }?>
</script>
<?php include(ADMINTPL.'/footer.tpl.php');?>
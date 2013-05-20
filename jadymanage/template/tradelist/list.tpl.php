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
<form action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="230px" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u(MOD,'report')?>" class="link3">[获取订单]</a> <a href="<?=u(MOD,'addedi')?>" class="link3">[添加订单]</a> </td>
              <td width="" align="right"><?=select($select2_arr,$se2,'se2')?> <input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($select_arr,$se,'se')?>&nbsp;<?=select($checked_arr,$checked,'checked')?>&nbsp;<input type="submit" value="提交" /></td>
              <td width="125px" align="right" class="bigtext">共有 <b><?php echo $total;?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <th width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></th>
                      <th width="115px">交易号</th>
                      <th width="38px">来源</th>
					  <th width="">商品名称</th>
                      <th width="4%">单价</th>
                      <th width="4%">数量</th>
                      <th width="5%">成交额</th>
                      <th width="5%">比例</th>
                      <th width="4%">佣金</th>
                      <th width="5%"><?=TBMONEY?></th>
                      <th width="4%">积分</th>
                      <th width="11%">交易时间</th>
                      <th width="6%">状态</th>
                      <th width="7%">会员</th>
                      <th width="5%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=$r["trade_id"]?></td>
                        <td title="订单来源"><?=$select2_arr[$r['platform']]?></td>
						<td style="padding:0px 3px 0px 3px; text-align:left"><?=$r["item_title"]?></td>
                        <td><?=$r["real_pay_fee"]?></td>
                        <td><?=$r["item_num"]?></td>
                        <td><?=$r["real_pay_fee"]?></td>
                        <td <?php if($r["commission_rate"] >= 0.25){ echo 'style="color:red;"';}?>><?=$r["commission_rate"]*100?>%</td>
						<td><?=$r["commission"]?></td>
                        <td><?=jfb_data_type($r["jifenbao"])?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=$r["pay_time"]?></td>
                        <td><?=$checked_status[$r["checked"]]?></td>
                        <td><a href="<?=u('mingxi','list',array('uname'=>$r["uname"]))?>"><?=$r["uname"]?></a></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>
                        <?php if($r["checked"]==2){?>
                        退款
                        <?php }elseif($r["checked"]==1){?>
                        审核
                        <?php }elseif($r["checked"]==0){?>
                        返现
                        <?php }elseif($r["checked"]==-1){?>
                        查看
                        <?php }?>
                        </a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',$page_arr));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>
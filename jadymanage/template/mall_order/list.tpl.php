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
              <td width="40%" class="bigtext">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" />&nbsp;<a href="<?=u('mall_order','addedi')?>">添加订单</a>&nbsp;<br/>&nbsp;获取订单 &gt;&gt; 
              <?php foreach($lianmeng as $k=>$v){?>
              <a href="<?=u(MOD,'get',array('do'=>$k))?>" class="link3">[<?=$v['title']?>]</a> 
              <?php }?>
              <td width="" align="right"><input type="text" name="q" value="<?=$q?>" />&nbsp;<?=select($malls,$mall_id,'mall_id')?>&nbsp;<?=select($select_arr,$se,'se')?>&nbsp;<?=select($status_arr,$status,'status')?>&nbsp;<input type="submit" value="提交" /></td>
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
                      <th width="13%">下单时间</th>
                      <th width="8%">商城</th>
					  <th width="">订单号</th>
                      <th width="">联盟</th>
                      <th width="">活动id</th>
                      <th width="5%">总价</th>
                      <th width="5%">单价</th>
                      <th width="4%">数量</th>
                      <th width="4%">佣金</th>
                      <th width="4%">返利</th>
                      <th width="4%">积分</th>
                      <th width="6%">状态</th>
                      <th width="7%">会员</th>
                      <th width="5%">操作</th>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><?=date('Y-m-d H:i:s',$r["order_time"])?></td>
                        <td><?=$r["mall_name"]?></td>
						<td><?=$r["order_code"]?></td>
                        <td><?=$lm_arr[$r['lm']]?></td>
                        <td><?=$r["adid"]?></td>
                        <td><?=$r["sales"]?></td>
                        <td><?=$r["item_price"]?></td>
                        <td><?=$r["item_count"]?></td>
						<td><?=$r["commission"]?></td>
                        <td><?=$r["fxje"]?></td>
                        <td><?=$r["jifen"]?></td>
                        <td><?=$status_arr[$r["status"]]?></td>
                        <td><?=$r["uname"]?></td>
						<td><a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>">
                        <?php if($r["status"]==1){?>
                        查看
                        <?php }elseif($r["status"]==-1){?>
                        查看
                        <?php }elseif($r["status"]==0){?>
                        返现
                        <?php }?>
                        </a></td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
            <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:15px;"><?=pageft($total,$pagesize,u(MOD,'list',array('q'=>$q,'se'=>$se,'status'=>$status,'stime'=>$stime,'dtime'=>$dtime)));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>
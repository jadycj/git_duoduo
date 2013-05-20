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
	$('#updateplugin').jumpBox({  
	    title: '输入平台密码获取百宝箱信息',
		titlebg:1,
		height:150,
		width:450,
		contain:'<form action="" method="get"><input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="<?=ACT?>" />平台登陆密码：<input type="password" name="ddyunpwd" value="" /> <input type="submit" name="save_session" value="获取信息" /></form><br/><div><a href="<?=DD_YUN_URL?>/index.php?m=user&a=reg&url=<?=urlencode(URL)?>">未注册？立即注册</a></div>',
		LightBox:'show'
    });
})
	
</script>
<form name="form1" action="" method="get">
<table cellspacing="0" width="100%" style="border:1px  solid #DCEAF7; border-bottom:0px; background:#E9F2FB">
        <tr>
              <td width="40%">&nbsp;<img src="images/arrow.gif" width="16" height="22" align="absmiddle" /> <a href="<?=u('plugin','bbx')?>" class="link3">[返回百宝箱]</a> <a class="link3" id="updateplugin" style="cursor:pointer; color:#F00; font-weight:bold; text-decoration:underline">[点击获取我的订单]</a></td>
              <td width="" align="right">插件名称：<input type="text" name="q" value="<?=$q?>" />&nbsp;<input type="submit" value="提交" /></td>
              <td width="150px" align="right">共有 <b><?=$total?></b> 条记录&nbsp;&nbsp;</td>
            </tr>
      </table>
      <input type="hidden" name="mod" value="<?=MOD?>" />
      <input type="hidden" name="act" value="<?=ACT?>" />
      </form>
      <form name="form2" method="get" action="" style="margin:0px; padding:0px">
      <table id="listtable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
                    <tr>
                      <td width="3%"><input type="checkbox" onClick="checkAll(this,'ids[]')" /></td>
                      <td width="" >名称</td>
                      <td width="5%" >状态</td>
					  <td width="8%">标识码</td>
                      <td width="5%">价格</td>
                      <td width="10%">开发者</td>
                      <td width="150px">开始时间</td>
                      <td width="150px">过期时间</td>
                      <td width="18%">操作</td>
                    </tr>
					<?php foreach ($row as $r){?>
					  <tr>
                        <td><input type='checkbox' name='ids[]' value='<?=$r["id"]?>' id='content_<?=$r["id"]?>' /></td>
                        <td><a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=urlencode($r['code'])?>"><?=$r["title"]?></a></td>
                        <td><?=$zhuangtai_arr[$r["status"]]?></td>
						<td><?=$r["code"]?></td>
                        <td><?=$r["price"]?></td>
                        <td><?=$r["toper_name"]?> <?php if($r['toper_qq']!=1234){?><?=qq($r['toper_qq'],2)?><?php }?></td>
						<td><?=date('Y-m-d H:i:s',$r["addtime"])?></td>
                        <td><?=$r["endtime"]?></td>
						<td>
                        <?php if($r['admin_set']==1){?><a href="<?=u($r['mod'],$r['act'])?>" class=link4>查看</a><?php }?>
                        <a href="<?=u(MOD,'addedi',array('id'=>$r['id']))?>" class=link4>信息</a> 
                        <?php if($r['install']==0){?>
                        <a href="../plugin/plugin_update.php?code=<?=urlencode($r['code'])?>&do=<?=urlencode(authcode('install','ENCODE'))?>" class=link4>安装</a>
                        <?php }else{?>
                        <a href="../plugin/plugin_update.php?code=<?=urlencode($r['code'])?>&do=<?=urlencode(authcode('uninstall','ENCODE'))?>" class=link4>卸载</a>
                        <?php }?>
                        <a href="<?=DD_YUN_URL?>/index.php?m=bbx&a=view&code=<?=urlencode($r['code'])?>" class=link4>下载</a>
                        <a href="<?=$r['jiaocheng']?>" target="_blank" class=link4>教程</a>
                        </td>
					  </tr>
					<?php }?>
		</table>
        <div style="position:relative; padding-bottom:10px">
          <input type="hidden" name="mod" value="<?=MOD?>" /><input type="hidden" name="act" value="del" />
            <div style="position:absolute; left:5px; top:5px"><input type="submit" value="删除" class="myself" onclick='return confirm("确定要删除?")'/></div>
            <div class="megas512" style=" margin-top:5px;"><?=pageft($total,$pagesize,u(MOD,'list'));?></div>
            </div>
       </form>
<?php include(ADMINTPL.'/footer.tpl.php');?>
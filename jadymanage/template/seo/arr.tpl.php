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
$alias_mod_act_arr=dd_get_cache('alias');
?>
<div class="explain-col">此功能仅在伪静态下可用。设置后如被搜索引擎收录，不可轻易更改，在data/rewirite下会生成对应的伪静态文件（注意要刷新ftp），根据主机选择可用。
  </div>
<br />
<table id="addeditable" border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1">
  <tr>
    <td width="115px" align="right">网址设置：</td>
    <td style="padding:5px">
    <table border="0">
    <?php foreach($alias_mod_act_arr as $k=>$row){?>
    <tr>
    <td><?=$k?>：</td><td><input style="width:80px" type="text" name="<?=$k?>[0]" value="<?=$row[0]?>" /><input style="width:80px" type="text" name="<?=$k?>[1]" value="<?=$row[1]?>" /></td>
    </tr>
	<?php }?>
</table>

    
    </td>
  </tr>
  <tr>
     <td align="right">&nbsp;</td>
     <td>&nbsp;<input type="hidden" name="arr_name" value="alias" /><input type="submit" name="sub" value=" 保 存 设 置 " /></td>
  </tr>
  </form>
</table>

<?php include(ADMINTPL.'/footer.tpl.php');?>
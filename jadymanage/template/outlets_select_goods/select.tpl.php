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
<form action="index.php?mod=<?=MOD?>&act=<?=ACT?>" method="post" name="form1" id='outlets_form'>
<table id="addeditable" class='outlets-api-table' border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
 <tr>
    <td width="115px" align="right">api接口类型：</td>
    <td>
    &nbsp;&nbsp;<input type="radio" name="api_type" checked class='outlets-api-type' get_table='oultest-items' value='1'/>淘宝客推广商品
    &nbsp;&nbsp;<input type="radio" name="api_type" class='outlets-api-type' get_table='oultest-items-coupon' value='2'/>淘宝客折扣商品
    &nbsp;&nbsp;<input type="radio" name="api_type" class='outlets-api-type' get_table='oultest-items-shop' value='3'/>淘宝客商铺商品
    <input type='reset' class='outlets_item_reset' name='' style='display:none;'/>
    </td>
  </tr>
</table>
<table id="addeditable" class='outlets-item-table' border=1 cellpadding=0 cellspacing=0 bordercolor="#dddddd">
  <?php if($id>0){?>
  
  <?php }else{?>
  <tbody class='oultest-items'><!-- 推广 -->
	<tr>
	  <td width="115px" align="right">商品属性：</td>
	  <td>
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_guarantee' value='true'/>消费者保障
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_sevendays_return' value='true'/>7天退换
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_overseas_item' value='true'/>海外商品
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_cash_ondelivery' value='true'/>货到付款
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_vip_card' value='true'/>支持vip卡
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_cash_coupon' value='true'/>支持抵价券
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_real_describe' value='true'/>如实描述
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_onemonth_repair' value='true'/>30天维修
	  	&nbsp;&nbsp;<input type="checkbox" name='outlets_item_checkbox_mall_item' value='true'/>商城商品
	  </td>
	</tr>  

	<tr>
	    <td width="115px" align="right">商品分类：</td>
	    <td>
		<select id='outlets_select_first' style='float:left;margin-left:12px;'>
	    <option value=''>请选择</option>
	    <?php foreach($taobao_itemcats_get as $k=>$cates){?>
	    <option value='<?= $cates['cid']?>'><?= $cates['name']?></option>
	    <?php }?>
	    </select>
	    
	    &nbsp;&nbsp;<select id='outlets_select_sec' style='float:left;display:none;margin-left:20px;'></select>
	    &nbsp;&nbsp;<select id='outlets_select_thr' style='float:left;display:none;margin-left:20px;'></select>
	    </td>
  	</tr>
  	
	<tr>
	  <td width="115px" align="right">默认排序：</td>
	  <td>&nbsp;
	  <?=select($sort,'','outlets_item_sort')?>
	  </td>
	</tr>
	
	<tr>
	  <td width="115px" align="right">关键字：</td>
	  <td>&nbsp;&nbsp;<input type='text' name='outlets_item_keyword' value=''/></td>
	</tr>

	<tr>
	  <td width="115px" align="right">起始信用：</td>
	  <td>&nbsp;
	  <?=select($credit,'','outlets_item_start_credit')?>
	  </td>
	</tr>
	<tr>
	  <td width="115px" align="right">最高信用：</td>
	  <td>&nbsp;
	  <?=select($credit,'5goldencrown','outlets_item_end_credit')?>(注：结束大于起始) 
	  </td>
	</tr>
	
    <tr>
	  <td width="115px" align="right">最低佣金率：</td>
	  <td>&nbsp;
	  <?=select($rate,'','outlets_item_start_commissionRate')?>
	  <font color='#E89403'>100表示1%,最低佣金率和最高佣金率同时输入才有效</font>
	  </td>
    </tr>
    <tr>
	  <td width="115px" align="right">最高佣金率：</td>
	  <td>&nbsp;
	  <?=select($rate,'9000','outlets_item_end_commissionRate')?>
	  <font color='#E89403'>100表示1%,最低佣金率和最高佣金率同时输入才有效</font>
	  </td>
    </tr>

    <tr>
	  <td width="115px" align="right">30天累计推广量：</td>
	  <td>&nbsp;
	  <input type='text' name='outlets_item_start_commissionNum'/>--<input type='text' name='outlets_item_end_commissionNum'/>
	  <font color='#E89403'></font>
	  </td>
    </tr>
    
  	<tr>
	  <td width="115px" align="right">价格：</td>
	  <td>&nbsp;
	  <input type='text' name='outlets_item_start_price'/>--<input type='text' name='outlets_item_end_price'/>
	  <font color='#E89403'></font>
	  </td>
  	</tr>
  </tbody><!-- 推广 -->
  
  <tbody class='oultest-items-coupon'><!-- 折扣 -->
  	<tr>
	    <td width="115px" align="right">商品分类：</td>
	    <td>
		<select id='outlets_select_first' style='float:left;margin-left:12px;'>
	    <option value=''>请选择</option>
	    <?php foreach($taobao_itemcats_get as $k=>$cates){?>
	    <option value='<?= $cates['cid']?>'><?= $cates['name']?></option>
	    <?php }?>
	    </select>
	    
	    &nbsp;&nbsp;<select id='outlets_select_sec' style='float:left;display:none;margin-left:20px;'></select>
	    &nbsp;&nbsp;<select id='outlets_select_thr' style='float:left;display:none;margin-left:20px;'></select>
	    </td>
  	</tr>
  	
	<tr>
	  <td width="115px" align="right">默认排序：</td>
	  <td>&nbsp;
	  <?=select($coupon_sort,'','outlets_item_coupon_sort')?>
	  </td>
	</tr>
	
	<tr>
	  <td width="115px" align="right">关键字：</td>
	  <td>&nbsp;&nbsp;<input type='text' name='outlets_item_coupon_keyword' value=''/></td>
	</tr>
	
    <tr>
	  <td width="115px" align="right">店铺类型：</td>
	  <td>&nbsp;
	  <select name='outlets_item_coupon_shop_type'>
	  <option value='all'>全部</option><option value='b'>商城</option><option value='c'>集市</option>
	  </select>
	  <font color='#E89403'></font>
	  </td>
    </tr>
    
  	<tr>
	  <td width="115px" align="right">最低折扣：</td>
	  <td>&nbsp;
	  <?=select($rate,'','outlets_item_coupon_start_coupon_rate]')?>
	  <font color='#E89403'>100表示1%,最低折扣和最高折扣同时输入才有效</font>
	  </td>
  	</tr>
  	<tr>
	  <td width="115px" align="right">最高折扣：</td>
	  <td>&nbsp;
	  <?=select($rate,'9000','outlets_item_coupon_end_coupon_rate ]')?>
	  <font color='#E89403'>100表示1%,最低折扣和最高折扣同时输入才有效</font>
	  </td>
  	</tr>
  	
	<tr>
	  <td width="115px" align="right">起始信用：</td>
	  <td>&nbsp;
	  <?=select($credit,'','outlets_item_coupon_start_credit')?>
	  </td>
	</tr>
	<tr>
	  <td width="115px" align="right">最高信用：</td>
	  <td>&nbsp;
	  <?=select($credit,'5goldencrown','outlets_item_coupon_end_credit')?>(注：结束大于起始) 
	  </td>
	</tr>
	
    <tr>
	  <td width="115px" align="right">最低佣金率：</td>
	  <td>&nbsp;
	  <?=select($rate,'','outlets_item_coupon_start_commission_rate')?>
	  <font color='#E89403'>100表示1%,最低佣金率和最高佣金率同时输入才有效</font>
	  </td>
    </tr>
    <tr>
	  <td width="115px" align="right">最高佣金率：</td>
	  <td>&nbsp;
	  <?=select($rate,'9000','outlets_item_coupon_end_commission_rate')?>
	  <font color='#E89403'>100表示1%,最低佣金率和最高佣金率同时输入才有效</font>
	  </td>
    </tr>
    
    <tr>
	  <td width="115px" align="right">30天累计推广量：</td>
	  <td>&nbsp;
	  <input type='text' name='outlets_item_coupon_start_commission_num'/>--<input type='text' name='outlets_item_coupon_end_commission_num'/>
	  <font color='#E89403'></font>
	  </td>
    </tr>
  </tbody><!-- 折扣 -->
  
  <tbody class='oultest-items-shop'>
  	<tr>
    <td width="115px" align="right">掌柜昵称：</td>
    <td>&nbsp;&nbsp;<input type="text" name="outlets_item_shop_nick" class='outlets_nick' value="" /></td>
  	</tr>
  	<tr>
	  <td width="115px" align="right">店铺类型：</td>
	  <td>&nbsp;
	  <select name='outlets_item_shop_shop_type'>
	  <option value='all'>全部</option><option value='b'>商城</option><option value='c'>集市</option>
	  </select>
	  <font color='#E89403'></font>
	  </td>
    </tr>
    <tr>
	  <td width="115px" align="right">默认排序：</td>
	  <td>&nbsp;
	  <?=select($shop_sort,'','outlets_item_shop_sort')?>
	  </td>
	</tr>
  </tbody>
  
  <tbody>
  	<tr>
	    <td align="left" colspan="2" style='padding-left:100px;'>&nbsp;<input type="hidden" name="id" value="<?=$row['id']?>" />
	    <input type="button" class='outlets_form_sub' name="sub" value=" 筛选商品 " />
	    <input type="button" class='outlets_join_but' name="sub" value=" 加入卖场 " />
	    </td>
  	</tr>
  	</form>
  	<tr>
    <td align="right" colspan="2" id='outlets_goods_td'>
    <div class="goodslist">
    <div class="goodslist_main_2" id="splistbox">
    <form action="" method="post" name="form2" id='outlets_select_form'>
    <ul></ul>
    </form>
    </div>
    </div>
    </td>
  	</tr>
  </tbody>
  <?php }?>  
</table>

<?php if($seller_nicks){?>
<?php 
include(DDROOT.'/comm/jssdk.php');
echo '<script src="http://a.tbcdn.cn/apps/top/x/sdk.js?appkey='.$webset['taoapi']['jssdk_key'].'"></script>';
echo '<script src="../js/jquery.js"></script>';
echo '<script src="../js/base64.js"></script>';
echo '<script src="../js/md5.js"></script>';
echo '<script src="../js/fun.js"></script>';
echo '<script src="../js/jssdk.js"></script>';
//echo '<link rel="stylesheet" type="text/css" href="../data/css/tao_shop_2712711152.css">'
?>
<script>
var sellernicks = $('.outlets_nick').val();
<?php
$jssdk_shops_convert = manage_select_shop_convert($seller_nicks);
php2js_array($jssdk_shops_convert,'parame');
echo "taobaoTaobaokeWidgetShopsConvert(parame);\r\n";
?>
commentUrl='';
function ddShowShopInfo(shopsInfo){
	if(shopsInfo['level']>0){
		$('.shopmessage #shopFxbl').html(shopsInfo['fxbl']+'%');
		$('.shopmessage .shoptxt-img img').attr('src','images/level_'+shopsInfo['level']+'.gif');
		$('.shopmessage #goodsnum').html('宝贝数量：'+shopsInfo['auction_count']);
		$('.shopmessage .dd_jump').attr('href',shopsInfo['jump']);
		
		var goodsUrl='../index.php?mod=ajax&act=seer_shop_items_get&uid='+shopsInfo['user_id']+'&nick='+encodeURIComponent(shopsInfo['seller_nick'])+'&taoke='+shopsInfo['taoke']+'&level='+shopsInfo['level']+'&list=2';
		$.ajax({
	    	url: goodsUrl,
			type: "GET",
			success: function(data){
		    	if(data!=''){
					$('#splistbox ul').html(data);
				}
			}
		});

		
		<?php if(MOD=='tao' && ACT=='view'){?>
		commentUrl='<?=$comment_url?>'+shopsInfo['user_id'];
		<?php }?>
	}
}
</script>

<?php }?>
<script language="javascript" type="text/javascript">
$(document).ready(function (){


	$('.outlets_join_but').click(function(){
		var select_checkbox = $('#outlets_select_form :checkbox').fieldValue();
		if(select_checkbox){
			var api_type = $('#outlets_form :radio').fieldValue(); 
		    var queryString = $('#outlets_form').formSerialize();
		    if(api_type==1){
		    	var goodsUrl='../index.php?mod=ajax&act=get_outlets_items&select=1&'+queryString+'&selectid='+select_checkbox;
			}else if(api_type==2){
				var goodsUrl='../index.php?mod=ajax&act=get_outlets_items_coupon&select=1&'+queryString+'&selectid='+select_checkbox;
			}else{
				var goodsUrl='../index.php?mod=ajax&act=get_outlets_items_shop&select=1&'+queryString+'&selectid='+select_checkbox;
			}
			
		    
			$.ajax({
		    	url: goodsUrl,
				type: "GET",
				success: function(data){
			    	if(data!=''){
			    		$('.outlets_form_sub').val('筛选商品');
						$('#splistbox ul').html(data);
					}
				}
			});
		}

	});
	
	$('.outlets_form_sub').click(function(){
		$('.outlets_form_sub').val('筛选中..');
		var api_type = $('#outlets_form :radio').fieldValue(); 
	    var queryString = $('#outlets_form').formSerialize();
	    if(api_type==1){
	    	var goodsUrl='../index.php?mod=ajax&act=get_outlets_items&'+queryString;
		}else if(api_type==2){
			var goodsUrl='../index.php?mod=ajax&act=get_outlets_items_coupon&'+queryString;
		}else{
			var goodsUrl='../index.php?mod=ajax&act=get_outlets_items_shop&'+queryString;
		}
		
	    
		$.ajax({
	    	url: goodsUrl,
			type: "GET",
			success: function(data){
		    	if(data!=''){
		    		$('.outlets_form_sub').val('筛选商品');
					$('#splistbox ul').html(data);
				}
			}
		});

		});

	   
	//api类型
	$(".outlets-api-type").click(function(){
		 if($(this).attr('checked') == true){
			 $('.outlets_item_reset').click();//清空表单
			 $(this).attr('checked','true');//选择状态重新赋值
			 var distbody = $(this).attr('get_table');
			 $('.'+distbody).css('display','block');
			 if(distbody =='oultest-items'){
				 $('.oultest-items-coupon').css('display','none');
				 $('.oultest-items-shop').css('display','none');
			 }else if(distbody =='oultest-items-coupon'){
				 $('.oultest-items').css('display','none');
				 $('.oultest-items-shop').css('display','none');
			 }else{
				 $('.oultest-items').css('display','none');
				 $('.oultest-items-coupon').css('display','none');
			 }
			}

	});

	
    $("#outlets_select_first").change(function(){
    	$('#outlets_select_sec').css('display','none');
    	$('#outlets_select_thr').css('display','none');
        var cate_parent_cid = $(this).children('option:selected').val();
	if(cate_parent_cid){
			var itemcatsUrl='../index.php?mod=ajax&act=get_taobao_itemcats&cid='+cate_parent_cid;
			$.ajax({
		    	url: itemcatsUrl,
				type: "GET",
				success: function(data){
			    	if(data!=''){
			    		$('#outlets_select_sec').css('display','block');
						$('#outlets_select_sec').html(data);
					}
				}
			});
		}
    
    });
    $("#outlets_select_sec").change(function(){
    	$('#outlets_select_thr').css('display','none');
        var cate_parent_cid = $(this).children('option:selected').val();
	if(cate_parent_cid){
			var itemcatsUrl='../index.php?mod=ajax&act=get_taobao_itemcats&cid='+cate_parent_cid;
			$.ajax({
		    	url: itemcatsUrl,
				type: "GET",
				success: function(data){
			    	if(data!=''){
			    		$('#outlets_select_thr').css('display','block');
						$('#outlets_select_thr').html(data);
					}
				}
			});
		}
    
    });
});
</script>

<?php include(ADMINTPL.'/footer.tpl.php');?>
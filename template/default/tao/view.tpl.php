<?php
$css[]=TPLURL."/css/view.css";
$js[]="js/md5.js";
$js[]="js/jssdk.js";
$js[]="js/jQuery.autoIMG.js";
include(TPLPATH.'/header.tpl.php');
?>
<?php include(DDROOT.'/comm/jssdk.php');?>
<script src="js/jQuery.autoIMG.js"></script>
<script>
$(function(){
    $(".shopitem_main .shopitem_main_l").imgAutoSize(310,310); 
})
</script>
<div class="mainbody">
	<div class="mainbody1000">
		<div class="shopleft">
		<?php include(TPLPATH.'/tao/shopinfo.tpl.php');?>
            <?php if(WEBTYPE==1){?>
            <div class="shopxiangguan">
                <ul>
                <?php foreach($goods2 as $row) {?>
                <li><a target="_blank" href="<?=u('tao','view',array('iid'=>$row["num_iid"]))?>"><?=html_img($row["pic_url"],2,$row['name'])?></a><p><?=$row['name']?></p><p><span>淘宝价:￥<?=$row['price']?> 元</span></p><p>返：<b><?=$row['fxje']?> </b><?=TBMONEYUNIT?><?=TBMONEY?></p> </li>
                <?php }?>
                </ul>
            </div>  
            <?php }?>      
        </div>
      <div class="shopright">
       	<div class="shopitem">
                <h3><?=$goods['title']?>&nbsp;&nbsp;<span style="font-size:12px; font-family:宋体"> 【<a style="color:#F60;" href="<?=u('tao','list',array('cid'=>0,'q'=>$goods['title']))?>" target="_blank">查看同款商品</a>】</span></h3>
                <div class="shopitem_main">
                    <div class="shopitem_main_l"><a href="<?=$goods['jump']?>" target="_blank"><?=html_img($goods['pic_url'],3,$goods['title'])?></a></div>
                    <div class="shopitem_main_r">
                    	<div class="shopitem_main_r_1"><img src="images/baozhang.gif" ></div>

                        <div class="shopitem_main_r_3"><span id="price_name" style="font-family:宋体"><?=$price_name?></span>：<span class="price"> <?=$goods['price']?></span> 元&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id="yuanjia" style="display:none">原价：<span style="text-decoration:line-through"><?=$goods['price']?></span> 元</span></div>
                        <div class="shopitem_main_r_3"><span id="zuigaofan" title="<?=TBFLTIP?>">最高返：</span><span id="nofan"><span class="price dd_fxje">计算中</span><?=TBMONEYUNIT?><?=TBMONEY?> <span id="ksq">（可省<b style="font-size:16px; color:#F30"></b>元）</span></span></div>
                        
                        <?php if($tao_coupon_str==''){?>
                        <div class="shopitem_main_r_3">商品数量： <?=$goods['num']?> 件 </div>
                        <?php }else{?>
                        <?=$tao_coupon_str?>
                        <?php }?>
                        
                        <div class="shopitem_main_r_3">运费承担： <?=$goods['freight_payer']?></div>
                        
                        <div class="shopitem_main_r_3">所在地区： <?=$goods['location']['state']?> <?=$goods['location']['$city']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;新旧程度： <?php if($goods['stuff_status']=='new'){echo "全新";}if($goods['stuff_status']=='unused'){echo "闲置";}if($goods['stuff_status']=='second'){echo "二手";}?> <?php if($goods['has_invoice']=='true'){echo "有发票";}?> </div>
                        <div class="shopitem_main_r_3">掌柜名称： <?=$goods['nick']?> <?=wangwang($goods['nick'])?> </div>
                        <div class="shopitem_main_r_5">温馨提示：<span> 虚拟商品如话费，游戏，机票等无返利哦！</span> </div>
                        <div class="shopitem_main_r_4"><a <?php if($webset['taoapi']['fanlitip']==1){?> class="fanlitip" <?php }?> id="clickUrl" href="<?=$goods['jump']?>" target="_blank"><img alt="立刻去购买" src="<?=TPLURL?>/images/gomai.gif" /></a><a onclick="window.open('<?=SITEURL?>/'+$('.shopmessage .dd_jump').attr('href'))" style="cursor:pointer" target="_blank"><img alt="逛逛掌柜店铺" src="<?=TPLURL?>/images/gozhanggui.gif" /></a></div>
                        <div class="shopitem_main_r_6"><p>宝贝分享：</p>
                            <div class="bshare-custom"><a title="分享到QQ空间" class="bshare-qzone">QQ</a>
<a title="分享到新浪微博" class="bshare-sinaminiblog">新浪</a>
<a title="分享到人人网" class="bshare-renren">人人</a>
<a title="分享到腾讯微博" class="bshare-qqmb">腾讯</a>
<a title="更多平台" class="bshare-more bshare-more-icon"></a><span class="BSHARE_COUNT bshare-share-count">0</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=<?=$webset['bshare']['uuid']?>&amp;pophcol=2&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script>
                        </div>
                    </div>
                </div>
<script>
function ddShowFxje(ddFxje,promotion_price){
	if(promotion_price<<?=$goods['price']?> && promotion_price>0){
		$('.shopright .shopitem_main_r_3 #price_name').html('<span class="tbcuxiao"><i><?=$promotion_name?></i></span>');
		$('.shopright .shopitem_main_r_3 .price').html(promotion_price);
		$('.shopright .shopitem_main_r_3 #yuanjia').show();
		$('.shopright .shopitem_main_r_3 #zuigaofan').html('折后最高返：');
		
		var reg=new RegExp("&price=(.*)&name","gi");
		var url='<?=$goods['jump']?>';
		url=url.replace(reg,'&price='+promotion_price+'&name');
		$('#clickUrl').attr('href',url);
	}
	if(ddFxje>0){
		var clickUrl=$('#clickUrl').attr('href')+'&fan=';
		$(".shopright .shopitem_main_r_3 .dd_fxje").html(ddFxje);
		$(".shopright .shopitem_main_r_3 #ksq b").html(dataType(ddFxje/MONEYBL,2));
		$(".shopright .shopitem_main_r_4 #clickUrl").attr('href',clickUrl+ddFxje);
		$(".shopright .shopitem_main_l a").attr('href',clickUrl+ddFxje);
		$('.shopitem .goodscomment .pingjia .pingjia_more a').attr('href',clickUrl+ddFxje);
	}
	else{
		$(".shopright .shopitem_main_r_3 #nofan").css('font-size','14px').css('color','red').html('<b>该商品暂无返利</b>');
	}
}

$(".shopright .shopitem_main_l").imgAutoSize(310,310);
function suanfanli(v){
	f=fan*v/price;
    $('#jumpbox .text_f').text(dataType(f,<?=TBMONEYTYPE?>));
}
$(function(){
<?php if($webset['taoapi']['fanlitip']==1){?>
	$('.shopright .shopitem_main_r .fanlitip').jumpBox({  
	    title: '这是您刚刚查看的商品：',
		titlebg:1,
		LightBox:'show',
		easyClose:0,
		jsCode:"param2=parse_str(ajaxUrl);pic_url=decode64(param2['pic']);title='<?=$goods['title']?>';if(typeof param2['promotion_price']!='undefined'){price=param2['promotion_price']}else{price=param2['price']};fan=param2['fan'];contain = contain.replace(/{pic_url}/, pic_url).replace(/{title}/, title).replace(/{price}/, price).replace(/{back}/, fan);",
		contain:'<div class="alert_go_tao"><div class="info"><table width=""border="0"><tr><td width="62"rowspan="3"><div class="pic"><img src="{pic_url}"/></div></td><td width="219"><span class="tit">{title}</span></td></tr><tr><td><span class="price">淘宝价格：{price}元</span><span class="fan">　返：{back}<?=TBMONEY?></span></td></tr><tr><td><span class="price_r">实付价格：</span><input type="text"class="text_p"value=""  onkeyup="suanfanli(this.value)"/><span class="fan_r">实返：</span><span class="text_f">？</span></td></tr></table><div style="clear:both"></div><div class="alert_notice"><em></em><div class="notice_content">输入最终购买价格(不含邮费)，算一下最终返<?=TBMONEY?>有多少？</div></div></div><p><span>●</span><a>虚拟商品无返利</a><span>●</span><a>实际返利与成交价有关</a><span>●</span><a>确认收货后才能查询返利</a></p><div style=" margin-top:3px"><a href="<?=u('help','index')?>'+
'" style="color:#03F" target="_blank">●用“<?=WEBNICK?>”去“淘宝网”购物 省钱方法详解【点击】</a></div></div>',
		height:240,
		width:520,
		a:1
    });
<?php }?>
<?php if($webset['taoapi']['goods_comment']==1){?>
    $('.shopit_txt a').click(function(){
    	$('.shopit_txt ul li').addClass('shopit_xz');
		$(this).parent('li').removeClass('shopit_xz');
		vdo=$(this).attr('do');
		
		if(vdo=='desc'){
		    $('.shopit_txt_ms').show();
			$('.goodscomment').hide();
			return true;
		}
		else if(vdo=='comment'){
		    $('.shopit_txt_ms').hide();
			$('.goodscomment').show();
		}
		
		if(commentUrl==''){
			alert('评论地址加载中，请稍后再试');
			return true;
		}
		$.ajax({
	        url: '<?=u('ajax','goods_comment')?>',
		    data:{'comment_url':commentUrl},
		    dataType:'jsonp',
			jsonp:"callback",
		    success: function(data){
			    if(data.rateListInfo.paginator.items>0){
			        var commentScore=parseFloat(data.scoreInfo.merchandisScore);  //评价得分
					var commentItems=parseInt(data.rateListInfo.paginator.items);  //评价数量
					var commentTotal=parseInt(data.scoreInfo.merchandisTotal);  //评价总次数
					
					num=commentScore*10;
					x2 = Math.floor(num%10); 
					num /= 10; 
                    x1 = Math.floor(num%10); 

					$('.pingjianum').html(commentItems); 
		            $('#pjdfnum').html(commentTotal);
		            $('.ajaxpjdf').html(commentScore);
		            var biaochi=parseInt(commentScore/5*380);
		            $('#biaochi').css('margin-left',biaochi+'px');
			        $('#getpling').hide();
			        $('#plcontent').show();
					$('.goodscomment .ov5hx').css('width',commentScore*20)
					
					jsonData=data.rateListInfo.rateList;
					c=jsonData.length;
					for(var i=0;i<c;i++){
						if(jsonData[i]['displayRatePic']=='') jsonData[i]['displayRatePic']='b_red_1.gif';
                        jsonLi='<li><div class="commnetleft">'+jsonData[i]['rateContent']+'<br><span>['+jsonData[i]['rateDate']+']</span></div><div class="commnetright">买家：'+jsonData[i]['displayUserNick']+'<br><img src="images/'+jsonData[i]['displayRatePic']+'" /></div></li>';
						$('#comment').append(jsonLi+'<div style="clear:both"></div>');
                    }
			    }
			    else{
			        alert('评论加载失败');
			    }
		     }
	    });
	});
<?php }?>
});
<?php
if(in_array($jssdk_items_convert['cid'],$virtual_cid['goods'])){ //虚拟商品返利强制为0
	echo 'ddShowFxje(0);';
}
else{
	$jssdk_items_convert['call_user_func']='showFxje';
	php2js_array($jssdk_items_convert,'parame');
	echo "taobaoTaobaokeWidgetItemsConvert(parame);";
}
?>
/*commArr=new Array();
parame=new Array();
parame['method']='taobao.taobaoke.widget.items.convert';
parame['fields']='num_iid,commission'
parame['num_iids']='12556990495,16945503284';
parame['user_level']='0';
taobaoTaobaokeWidgetItemsConvert(parame);

function commArrF(){
	if(!isEmpty(commArr)){
		debugObjectInfo(commArr);
		clearInterval(commArrProcess);
	}
}
commArrProcess = setInterval("commArrF()", 500);*/
</script>
<div class="shopit_txt">
    <ul>
    <li><a do='desc' href="<?=u('tao','jiu')?>">九元购包邮</a> </li>
    </ul>
    <div class="shopit_txt_ms">
    <script>iframe('<?=DD_YUN_URL?>/index.php?m=shuju&a=jiu&ad=1&cid=<?=$goods['cid']?>&url=<?=urlencode(u('tao','view',array('iid'=>99999999)))?>',720,260)</script>
    </div>
</div>


                <div class="shopit_txt">
                    <ul>
                    <?php if(WEBTYPE==1){?>
                    <li><a do='desc'>宝贝描述</a> </li>
                    <?php }?>
                    <?php if($webset['taoapi']['goods_comment']==1){?>
                    <li class="shopit_xz"><a id="pjan" do="comment" url="">商品评价</a> </li>
                    <?php }?>
                    </ul>
                    <div class="shopit_txt_ms"><?=$goods['desc']?></div>
                </div>
                <div class="goodscomment" style=" display:none">
                
                <div class="pjdf">
					<div class="pjleft"><ul>
						<li class="pjfs">店铺的“宝贝与描述相符”得分</li>
						<li class="pjfs2">
                        <div style="float:left"><font class="ajaxpjdf" style="font-size:24px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#FF6600">5.0</font> 分</div>
                        <div style="float:left">
                        <DIV class=xx3 style="padding-top:5px">
                        <DIV class="bg5bx">
                    <DIV class="ov5hx" style="WIDTH: 100px;"></DIV>
                    </DIV>
                    </DIV>
                        </div>
                        <div style="clear:both"></div>
                        </li>
						<li class="gdf">(共打分 <font id="pjdfnum" color="#FF6600">100</font> 次)</li>
						</ul>
					</div>
					<div class="pjright">
						<ul>
							<li style="width:380px; height:20px; margin-top:21px;"><div id="biaochi" style="width:28px; height:21px; background:url(template/<?=MOBAN?>/images/pjfs.gif); margin-left:370px; text-align:center;"><font class="ajaxpjdf" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#fff">4.5</font></div></li>
							<li style="background:url(template/<?=MOBAN?>/images/rate_scroller_bar.png) no-repeat; width:400px; height:20px;"></li>
							<li style=" width:420px; background:url(template/<?=MOBAN?>/images/pjfssm.gif) no-repeat; height:45px;"></li>
						</ul>
					</div>
				</div>

                <div class="pingjia">
                    <div class="pingjia_bt">
                    	 <div class="pingjia_bt_l">
                    	 评论
                    	 </div>
                         <div class="pingjia_bt_r">
                    	 评价人
                    	 </div>
                    </div>
                    <div id="comment">
  
                    </div>
                    <div class="pingjia_more">
                     <a href="<?=$goods['jump']?>" target="_blank">更 多</a>
                    </div>
                </div>
                </DIV>
        </div>
            </div>
            <?=AD(108)?>
        </div> 
	</div>
<div class="clear"></div>
<?php include(TPLPATH.'/footer.tpl.php');?>
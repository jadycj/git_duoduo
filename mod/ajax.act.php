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

if(!defined('INDEX')){
	exit('Access Denied');
}

function tao_item_cat($cid,$ddTaoapi){
	$TaobaokeData=$ddTaoapi->taobao_itemcat_msg($cid);
	$parent_cid=$TaobaokeData['parent_cid'];
	global $shai_cat_id_temp;
	$shai_cat_id_temp=in_tao_cat($parent_cid);
	if($shai_cat_id!=999){
		return false;
	}
	else{
	    tao_item_cat($parent_cid,$ddTaoapi);
	}
}

switch($act){
    case 'check_user':
	    echo $duoduo->check_user($_POST['username']);
	break;
	
	case 'check_oldpass':
	    echo $duoduo->check_oldpass($_POST['oldpass'],$_POST['dduserid']);
	break;
	
	case 'check_my_email':
	    $id=$duoduo->check_my_email($_POST['email'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_alipay':
	    $id=$duoduo->check_my_field('alipay',$_POST['alipay'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_tenpay':
	    $id=$duoduo->check_my_field('tenpay',$_POST['tenpay'],$_POST['dduserid']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_my_bank_code':
	    $id=$duoduo->check_my_field('bank_code',$_POST['bank_code'],$_POST['bank_code']);
		if($id>0){echo 'false';}
		else{echo 'true';}
	break;
	
	case 'check_email':
	    echo $duoduo->check_email($_POST['email']);
	break;
	
	case 'check_alipay':
	    echo $duoduo->check_alipay($_POST['alipay']);
	break;
	
	case 'check_captcha':
	    dd_session_start();
	    if($_POST['captcha']==$_SESSION["captcha"]){
	        echo 'true';
	    }
	    else{
	        echo 'false';
	    }
	break;
	
	case 'get_msg':
	    $id = (int)$_GET['id'];
	    if($dduser['id']>0){
			$info=$duoduo->select('msg','uid,senduser,see','id="'.$id.'"');
			if($dduser['id']==$info['uid'] || $dduser['id']==$info['senduser']){
			    if($info['uid']==$dduser['id'] && $info['see']==0){
			        $data=array('see'=>1);
			        $duoduo->update('msg',$data,'id="'.$id.'"');
			    }
	            echo $msg='<p style=" line-height:20px;">'.$duoduo->select('msg','content','id="'.$id.'"',2).'</p>';
			}
			else{
			    $re=dd_json_encode(array('s'=>0,'id'=>10));
		        echo $re;
			}
	    }
		else{
		    $re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;
		}
	break;
	
	case 'userinfo':
	    if($dduser['id']>0){
			if($msgnum==0){ 
	            $msgsrc="<img src=\"template/".MOBAN."/images/msg1.gif\" border=\"0\" alt=\"短消息\" />";
            }else{
	            $msgsrc="<img src=\"template/".MOBAN."/images/msg0.gif\" border=\"0\" alt=\"您有新的短消息\" /> (".$msgnum.")";
            }
			$userinfo=array('name'=>$dduser['name'],'id'=>$dduser['id'],'money'=>$dduser['money'],'jifenbao'=>$dduser['jifenbao'],'jifen'=>$dduser['jifen'],'level'=>$dduser['level'],'msgsrc'=>$msgsrc,'avatar'=>a($dduser['id']));
			$re=array('s'=>1,'user'=>$userinfo);
		    echo dd_json_encode($re);
		}
		else{
		    $re=array('s'=>0);
		    echo dd_json_encode($re);
		}
	break;
	
	case 'mall_comment':
	    if($dduser['id']==''){
			$re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		$comment=reg_content($_POST['comment']);
		$mall_id=(int)$_POST['mall_id'];
		$fen=(int)$_POST['fen'];
		if($mall_id==0 || $fen==0 || $comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		$lasttime=$duoduo->select('mall_comment','addtime',"uid=".$dduser['id']." and mall_id='".$mall_id."'"); //上次评论时间
	    if(TIME-$lasttime<$webset['comment_interval']){
	        $re=dd_json_encode(array('s'=>0,'id'=>33));
		    echo $re;continue;
	    }
		$fen=$fen==0?5:$fen;
		$field_arr=array('mall_id'=>$mall_id,'uid'=>$dduser['id'],'fen'=>$fen,'content'=>$comment,'addtime'=>TIME);
		$duoduo->insert('mall_comment',$field_arr);
		$re=dd_json_encode(array('s'=>1,'id'=>0));
		echo $re;
	break;
	
	case 'getTaoItem':
	    $url=$_POST['url'];
		$admin=$_POST['admin'];
		$is_mobile=$_POST['is_mobile'];
		if(preg_match('/(taobao\.com|tmall\.com)/',$url)!=1){
		    $re=array('s'=>0,'id'=>49);
			echo dd_json_encode($re);continue;
		}
		$tao_id_arr = include (DDROOT.'/data/tao_ids.php');
		$iid=get_tao_id($url,$tao_id_arr); //获取商品id
		if($iid==''){
		    $re=array('s'=>0,'id'=>22);
			echo dd_json_encode($re);continue;
		}
		if($admin==1){ //后台获取商品信息
		    dd_session_start();
			if($_SESSION['ddadmin']['name']==''){
			    echo dd_json_encode($re);continue;
			}
			$dduser['level']=9999; 
		}
		elseif($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		if($webset['share_limit_level']>$dduser['level']){ //验证分享所需等级
		    $re=array('s'=>0,'id'=>21);
			echo dd_json_encode($re);continue;
		}

		$data['iid']=$iid;
		$data['outer_code']=$dduser['id'];
		$data['is_mobile']=$is_mobile;
		$data['fields']='num_iid,title,cid,pic_url,price,click_url,nick';
		$data['get_commission']=1;
		$goods=$ddTaoapi->items_detail_get($data);
		if($goods['title']==''){
		    $re=array('s'=>0,'id'=>18);
			echo dd_json_encode($re);continue;
		}
		$goods['title']=dd_replace($goods['title']);
		$cid=$goods['cid'];
		$shai_cat_id=in_tao_cat($cid);
	    if($shai_cat_id==999){
	        tao_item_cat($cid,$ddTaoapi);
	        $shai_cat_id=$shai_cat_id_temp;
	    }
		
		if($webset['share']['re_tao_cid']==1 && $shai_cat_id==999){ //是否记录漏网cid
		    create_file(DDROOT.'/data/tao_cid.txt',$url.'|||'.$shai_cat_id."\r\n",1);
	    }
		
		$goods['cid']=$shai_cat_id;
		$goods['catid']=$cid;
		$goods['tao_id']=$iid;
		$re=array('s'=>1,'re'=>$goods);
		echo dd_json_encode($re);
	break;
	
	case 'save_share':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
	    $array=array('title','commission','tao_id','image','comment','cid','click_url','nick');
	    if(post2var($array)==0){
		    $re=array('s'=>0,'id'=>11);
			echo dd_json_encode($re);continue;
		}

		if($trade_id==0){ //订单id为0表示分享
		    if($dduser['level']<$webset['baobei']['share_level']){
			    $re=array('s'=>0,'id'=>21);
			    echo dd_json_encode($re);continue;
		    }
		}
		else{ //表示晒单，验证订单是否是自己的
		    $tao_trade=$duoduo->select('tradelist','num_iid,uid','uid="'.$dduser['id'].'" and num_iid="'.$_POST['tao_id'].'"');
			$tao_id=$tao_trade['num_iid'];
			if($dduser['id']!=$tao_trade['uid']){
			    $re=array('s'=>0,'id'=>42);
			    echo dd_json_encode($re);continue;
			}
		}
		
		if($keywords!=''){
		    $keywords_arr = preg_split('/[\n\r\t\s]+/i', trim($keywords));
		    if(count($keywords_arr)>5){
	            $re=array('s'=>0,'id'=>28);
			    echo dd_json_encode($re);continue;
	        }
		}
		if(str_utf8_mix_word_count($comment)>$webset['baobei']['word_num']){
		    $re=array('s'=>0,'id'=>26);
			echo dd_json_encode($re);continue;
		}
		
		$id=$duoduo->select('baobei','id','uid="'.$dduser['id'].'" and tao_id="'.$tao_id.'"');
		if($id>0){
		    $re=array('s'=>0,'id'=>31);
			echo dd_json_encode($re);continue;
		}
		
		$id=$duoduo->select('baobei_blacklist','id','tao_id="'.$tao_id.'"');
		if($id>0){
		    $re=array('s'=>0,'id'=>56);
			echo dd_json_encode($re);continue;
		}
		
		if($trade_id==0){ //分享积分
		    $jifen=(int)$webset['baobei']['share_jifen'];
			$jifenbao=(float)$webset['baobei']['share_jifenbao'];
			$shijian=5;
		}
		elseif($trade_id>0){  //晒单积分
		    $jifen=(int)$webset['baobei']['shai_jifen'];
			$jifenbao=(float)$webset['baobei']['shai_jifenbao'];
			$shijian=7;
		}

		$comment=reg_content($comment);
		if($comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		
		$field_arr=array('uid'=>$dduser['id'],'tao_id'=>$tao_id,'trade_id'=>$trade_id,'img'=>$image,'title'=>$title,'nick'=>$nick,'price'=>$price,'commission'=>$commission,'jifen'=>$jifen,'jifenbao'=>$jifenbao,'cid'=>$cid,'click_url'=>$click_url,'keywords'=>$keywords,'content'=>$comment,'addtime'=>TIME);
		$id=$duoduo->insert('baobei',$field_arr);
		
		if($jifen>0 || $jifenbao>0){
			$user_update=array(array('f'=>'jifen','e'=>'+','v'=>$jifen),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
			$duoduo->update_user_mingxi($user_update,$dduser['id'],$shijian,$id);
		}
		
		$re=array('s'=>1);
		echo dd_json_encode($re);
		
	break;
	
	case 'like':
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		$baobei_id=intval($_POST['id']);
		$uid=$dduser['id'];
		$baobei_hart_id=$duoduo->select('baobei_hart','id','uid="'.$uid.'" and baobei_id="'.$baobei_id.'"');
		if($baobei_hart_id>0){
		    $re=array('s'=>0,'id'=>30);
			echo dd_json_encode($re);continue;
		}
		$duoduo->update('baobei',array('f'=>'hart','e'=>'+','v'=>1),'id='.$baobei_id);
		$duoduo->insert('baobei_hart',array('baobei_id'=>$baobei_id,'uid'=>$uid,'addtime'=>TIME));
		$baobei_user_id=$duoduo->select('baobei','uid','id="'.$baobei_id.'"');
		
		$user_update=array(array('f'=>'jifen','e'=>'+','v'=>(int)$webset['baobei']['hart_jifen']),array('f'=>'jifenbao','e'=>'+','v'=>(int)$webset['baobei']['hart_jifenbao']),array('f'=>'hart','e'=>'+','v'=>1));
		$duoduo->update_user_mingxi($user_update,$baobei_user_id,16,$baobei_id);
		
		$re=array('s'=>1);
		echo dd_json_encode($re);
	break;
	
	case 'save_share_comment':
	    $comment=$_POST['comment']?htmlspecialchars($_POST['comment']):'';
		$id=$_POST['id']?intval($_POST['id']):0;
	    if($dduser['id']<=0){  //验证是否登录
		    $re=array('s'=>0,'id'=>10);
			echo dd_json_encode($re);continue;
		}
		if($dduser['level']<$webset['baobei']['comment_level']){
			$re=array('s'=>0,'id'=>21);
			echo dd_json_encode($re);continue;
		}
		if($comment==''){
		    $re=array('s'=>0,'id'=>27);
			echo dd_json_encode($re);continue;
		}
		if($id==0){
		    $re=array('s'=>0,'id'=>32);
			echo dd_json_encode($re);continue;
		}
		if(str_utf8_mix_word_count($comment)>$webset['baobei']['comment_word_num']){
		    $re=array('s'=>0,'id'=>26);
			echo dd_json_encode($re);continue;
		}
		$time=$duoduo->select('baobei_comment','addtime','uid="'.$dduser['id'].'" and baobei_id="'.$id.'"');
		if(TIME-$time<$webset['comment_interval']){
		    $re=array('s'=>0,'id'=>33);
			echo dd_json_encode($re);continue;
		}
		$comment=reg_content($comment);
		if($comment==''){
		    $re=dd_json_encode(array('s'=>0,'id'=>2));
		    echo $re;continue;
		}
		$data=array('baobei_id'=>$id,'uid'=>$dduser['id'],'comment'=>$comment,'addtime'=>TIME);
		$duoduo->insert('baobei_comment',$data);
		$re=array('s'=>1);
		echo dd_json_encode($re);
	break;
	
	case 'huan':
	    $s=1;
		$id=(int)$_POST['id'];
		$realname=htmlspecialchars($_POST['realname']);
		$address=htmlspecialchars($_POST['address']);
		$mode=(int)$_POST['mode'];
		$num=(int)$_POST['num'];
		if($dduser['alipay']!=''){
			$alipay=$dduser['alipay'];
		}else{
			$alipay=$_POST['alipay'];
		}
		if($dduser['mobile']!=''){
			$mobile=$dduser['mobile'];
		}else{
			$mobile=(float)$_POST['mobile'];
		}
		if($dduser['realname']!=''){
			$realname=$dduser['realname'];
		}else{
			$realname=htmlspecialchars($_POST['realname']);
		}
		if($dduser['email']!=''){
			$email=$dduser['email'];
		}else{
			$email=$_POST['email'];
		}
		if($dduser['qq']!=''){
			$qq=$dduser['qq'];
		}else{
			$qq=$_POST['qq'];
		}
		$content=htmlspecialchars($_POST['content']);
		
		if($mobile!=0 && reg_mobile($mobile)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>36));
		    echo $re;continue;
		}
		
		if($email!='' && reg_email($email)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>7));
		    echo $re;continue;
		}
		
		if($aliapy!='' && reg_aliapy($aliapy)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>35));
		    echo $re;continue;
		}
		
		if($qq!='' && reg_qq($qq)==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>9));
		    echo $re;continue;
		}
		
		$user_data=array('alipay'=>$alipay,'mobile'=>$mobile,'realname'=>$realname,'qq'=>$qq);
		$duoduo->update('user',$user_data,'id='.$dduser['id']);
		
	    if($dduser['name']==''){  //未登录
		    $re=dd_json_encode(array('s'=>0,'id'=>10));
		    echo $re;continue;
		}
		if($id==0 || $mode==0){ //缺少必要参数
		    $re=dd_json_encode(array('s'=>0,'id'=>11));
		    echo $re;continue;
	    }
		if($dduser['dhstate']==1){  //正在处于兑换状态
		    $re=dd_json_encode(array('s'=>0,'id'=>16));
		    echo $re;continue;
		}
		$huan=$duoduo->select('huan_goods','id,title,num,jifenbao,jifen,auto,array,edate,`limit`','id="'.$id.'" and hide="0"');
		if($huan['num']<$num || $num<=0){ //数量不够
		    $re=dd_json_encode(array('s'=>0,'id'=>66));
		    echo $re;continue;
		}
		elseif($huan['title']==''){ //商品不存在
		    $re=dd_json_encode(array('s'=>0,'id'=>17));
		    echo $re;continue;
		}
		elseif($huan['num']<=0){  //商品已下架
		    $re=dd_json_encode(array('s'=>0,'id'=>18));
		    echo $re;continue;
		}
		elseif($huan['edate']<TIME && $huan['edate']>0){  //商品已到期
		    $re=dd_json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		elseif($huan['sdate']>TIME){  //兑换未开始
		    $re=dd_json_encode(array('s'=>0,'id'=>51));
		    echo $re;continue;
		}
		$code_arr=unserialize($huan['array']);
		if($huan['auto']==1 && (empty($code_arr) || count($code_arr)<$num)){
			$re=dd_json_encode(array('s'=>0,'id'=>66));//数量不够
			echo $re;continue;
		}
			
		if($huan['limit']>0){
			if($huan['limit']<$num){  //兑换受限制
		    	$re=dd_json_encode(array('s'=>0,'id'=>52));
		    	echo $re;continue;
			}

			$sdatetime=strtotime(date('Y-m-d').' 00:00:00');
			$edatetime=strtotime(date('Y-m-d').' 23:59:59');
			$duihuan_num=$duoduo->count('duihuan','uid="'.$dduser['id'].'" and huan_goods_id="'.$id.'" and addtime>="'.$sdatetime.'" and addtime<="'.$edatetime.'"');
			if($duihuan_num>=$huan['limit']){
		    	$re=dd_json_encode(array('s'=>0,'id'=>52));  //兑换受限
		    	echo $re;continue;
			}
		}
		
		if($mode==1){  
		    if($huan['jifenbao']==0){
			    $re=dd_json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_jifenbao']<$huan['jifenbao']*$num){  //金额不足
			    $re=dd_json_encode(array('s'=>0,'id'=>19));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'jifenbao','e'=>'-','v'=>$huan['jifenbao']*$num),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(float)($huan['jifenbao']*$num);
			}
		}
		elseif($mode==2){  
		    if($huan['jifen']==0){
			    $re=dd_json_encode(array('s'=>0,'id'=>48));
		        echo $re;continue;
			}
		    if($dduser['live_jifen']<$huan['jifen']*$num){  //积分不足
			    $re=dd_json_encode(array('s'=>0,'id'=>20));
		        echo $re;continue;
			}
			else{
			    $data=array(array('f'=>'jifen','e'=>'-','v'=>$huan['jifen']*$num),array('f'=>'dhstate','e'=>'=','v'=>1));
				$spend=(int)($huan['jifen']*$num);
			}
		}
		else{
		    continue;
		}

	    $info['uid']=$dduser['id'];
	    $info['ip']=get_client_ip();
	    $info['huan_goods_id']=$id;
		$info['spend']=$spend;
	    $info['realname']=$realname;
	    $info['address']=$address;
	    $info['email']=$email;
	    $info['mobile']=$mobile;
	    $info['qq']=$qq;
	    $info['content']=$content;
	    $info['addtime']=TIME;
		$info['num']=$num;
		$info['alipay']=$alipay;
		if($huan['auto']==1){
		    $info['shoptime']=TIME;
	        $info['status']=1;
			unset($data[1]);  //自动发货，不改变会员的兑换状态
		}
		else{
		    $info['shoptime']=0;
	        $info['status']=0;
		}
	    
	    $info['mode']=$mode;
	    $id=$duoduo->insert('duihuan', $info);
		
		if($id>0){
			
			$duoduo->update('user', $data, 'id="'.$dduser['id'].'"');
			
			$user=$duoduo->select('user','mobile,mobile_test','id="'.$dduser['id'].'"');
			$duihuan_data=array('goods_id'=>$huan['id'],'uid'=>$dduser['id'],'email'=>$info['email'],'mobile'=>$huan['mobile'],'jifenbao'=>$huan['jifenbao']*$num,'jifen'=>$huan['jifen']*num,'title'=>$huan['title'],'array'=>$huan['array'],'auto'=>$huan['auto'],'mode'=>$mode,'num'=>$num,'alipay'=>$alipay);
			
			$duihuan_data['mobile']=$mobile;
			$duihuan_data['dh_id']=$id;
			$s=$duoduo->duihuan($duihuan_data,0);
		}
		$re=dd_json_encode(array('s'=>$s,'id'=>0));
		echo $re;
	break;
	
	case 'sign':
	    if($webset['sign']['open']==0){
		    $re=dd_json_encode(array('s'=>0,'id'=>43));
		    echo $re;continue;
		} 
		
		$todaytime=strtotime(date('Y-m-d 00:00:00'))+$webset['corrent_time'];
		$webset['sign']['money']=(float)$webset['sign']['money'];
		$webset['sign']['jifenbao']=(float)$webset['sign']['jifenbao'];
		$webset['sign']['jifen']=(float)$webset['sign']['jifen'];
		if($dduser['signtime']<$todaytime){
		    $data=array(array('f'=>'money','e'=>'+','v'=>$webset['sign']['money']),array('f'=>'jifenbao','e'=>'+','v'=>$webset['sign']['jifenbao']),array('f'=>'jifen','e'=>'+','v'=>$webset['sign']['jifen']),array('f'=>'signtime','e'=>'=','v'=>TIME));
		    $duoduo->update('user',$data,'id="'.$dduser['id'].'"');
			$data=array('uid'=>$dduser['id'],'shijian'=>4,'money'=>$webset['sign']['money'],'jifenbao'=>$webset['sign']['jifenbao'],'jifen'=>$webset['sign']['jifen']);
		    $duoduo->mingxi_insert($data);
		    $re=dd_json_encode(array('s'=>1));
		    echo $re;
		}
		else{
			$re=dd_json_encode(array('s'=>0,'id'=>44));
		    echo $re;
		}
	break;
	
	case 'get_size':
	    echo round((directory_size($_GET['dir']) / (1024*1024)), 2);
	break;
	
	case 'goods_comment':
	    if($webset['taoapi']['goods_comment']==0){return;}
	    $comment_url=$_POST['comment_url'];
		$s=dd_get($comment_url);
        $s=str_replace('TB.detailRate = ','',$s);
        $s=trim(iconv("gb2312","utf-8//IGNORE",$s));
        echo $s;
	break;
	
	case 'pinyin':
	    $title=$_POST['title'];
		if(!class_exists('pinyin')){include(DDROOT.'/comm/pinyin.class.php');}
		echo $pinyin=fs('pinyin')->re($title);
	break;
	
	case 'malls':
	    $num=(int)$_POST['num'];
	    if(isset($_POST['cid'])){
		    $cid=(int)$_POST['cid'];
			if($cid>0){
			    $malls=$duoduo->select_all('mall','cid,title,id,img,fan','cid="'.$cid.'" order by sort desc limit '.$num);
				foreach($malls as $k=>$row){
					$malls[$k]['url']=u('mall','view',array('id'=>$row['id']));		
				}
			}
			else{
			    $taoshop_num=$_POST['taoshop_num']; 
				$shangcheng_num=$_POST['shangcheng_num'];
				$mall_num=$_POST['mall_num'];
				
				//淘宝店铺
				$shops=$duoduo->select_all('shop', 'title,id,pic_path,fanxianlv,nick', '1=1 order by index_top desc,sort desc limit '.$taoshop_num);

				//商城
				$shangcheng=$duoduo->select_all('mall', 'cid,title,id,img,fan', '1=1 order by sort desc limit '.$shangcheng_num);

				foreach($shops as $i=>$row){
					$row['url']=u('tao','shop',array('nick'=>$row['nick']));
					$row['fan']=$row['fanxianlv'];
					$row['img']=TAOLOGO.$row['pic_path'];
					$shops[$i]=$row;
				}

				foreach($shangcheng as $i=>$row){
					$row['url']=u('mall','view',array('id'=>$row['id']));
					$shangcheng[$i]=$row;
				}

				$malls=array_merge($shops,$shangcheng);
			}
		}
		elseif(isset($_POST['title'])){
			$title=$_POST['title'];
		    if(preg_match("/^[0-9a-zA-Z]*$/",$title)){
			    $malls=$duoduo->select_all('mall','cid,title,id,img,fan','pinyin like "'.$title.'%" order by sort desc limit '.$num);
			}
			else{
			    $malls=$duoduo->select_all('mall','cid,title,id,img,fan','title like "%'.$title.'%" order by sort desc limit '.$num);
			}
			foreach($malls as $k=>$row){
				$malls[$k]['url']=u('mall','view',array('id'=>$row['id']));		
			}
		}
		
		echo dd_json_encode($malls);
	break;
	
	case 'tao_cuxiao':
		if(isset($_POST['iid'])){
			$iid=(float)$_POST['iid'];
			echo $ddTaoapi->taobao_ump_promotion_get($iid,'json');
		}
	    elseif(isset($_POST['iids'])){
			$iids=$_POST['iids'];
			$iid_arr=explode(',',$iids);
			
			foreach($iid_arr as $iid){
				$iid=(float)$iid;
				if($iid>0){
					$a=$ddTaoapi->taobao_ump_promotion_get($iid,'array');
					if($a['price']>0){
						$data[]=$a;
					}
				}
			}
			echo dd_json_encode($data);
		}
	break;
	
	case 'chanet':
	    dd_session_start();
		if($_SESSION['ddadmin']['name']==''){
			$re=array('err'=>1,'msg'=>'未登录');
			echo dd_json_encode($re);continue;
		}
		$do=$_GET['do'];
        if($do=='get_key'){
            $url=CHANET_GET_KEY_URL."?".$_SERVER['QUERY_STRING'];
	        echo dd_get($url);
		}
	    elseif($do=='get_info'){
		    $url=$_POST['url'];
	        $url=DUODUO_URL.'/getchanet.php?act=chanetid&url='.urlencode($url);
	        echo dd_get($url);
		}
	break;
	
	case 'weiyi':
	    dd_session_start();
		if($_SESSION['ddadmin']['name']==''){
			$re=array('err'=>1,'msg'=>'未登录');
			echo dd_json_encode($re);continue;
		}
		$do=$_GET['do'];
        if($do=='get_info'){
		    $url=$_POST['url'];
	        $url=DUODUO_URL.'/getweiyi.php?act=weiyi&url='.urlencode($url);
	        echo dd_get($url);
		}
	break;
	
	case 'send_mail':
		$email=trim($_GET['email']);
		$title=trim($_GET['title']);
		$content=trim($_GET['content']);
		$content=del_magic_quotes_gpc($content);
		echo mail_send($email, $title, $content);
	break;
	
	case 'send_sms':
		$mobile=trim($_POST['mobile']);
		$content=trim($_POST['content']);
		$content=del_magic_quotes_gpc($content);
		$ddopen=fs('ddopen');
		$ddopen->sms_ini($webset['sms']['pwd']);
		$re=$ddopen->sms_send($mobile,$content);
		if($re['s']==1){
			echo 1;
		}
		else{
			echo $re['r'];
		}
	break;
	
	case 'get_59miao_mall':
		$sid=(int)$_POST['sid'];
		include(DDROOT.'/comm/59miao.config.php');
		$re=$dd59miao->shops_get(array('sids'=>$sid));
		echo dd_json_encode($re);
	break;
	
	case 'huanqian':
		$money=(float)$_POST['money'];
		$dduser['id']=(int)$dduser['id'];
		if($webset['taoapi']['m2j']==0){
			$re=array('s'=>0,'id'=>999);
		}
		else{
			if($dduser['id']==0){
				$re=array('s'=>0,'id'=>10);
			}
			if($money<=0 || $money>$dduser['live_money']){
				$re=array('s'=>0,'id'=>19);
			}
			else{
				$jifenbao=jfb_data_type($money*TBMONEYBL);
				$jifenbao=data_type($jifenbao/(1+JFB_FEE),TBMONEYTYPE);

				$data=array(array('f'=>'money','e'=>'+','v'=>-$money),array('f'=>'jifenbao','e'=>'+','v'=>$jifenbao));
				$duoduo->update_user_mingxi($data,$dduser['id'],22);
				$re=array('s'=>1);
			}
		}
		echo dd_json_encode($re);
	break;
	
	case 'cron':
		$duoduo->cron();
	break;
	
	case 'addshop':
		$check=authcode($_GET['check'],'DECODE');
		if($_SERVER['REQUEST_TIME']-$check>5){
			//dd_exit('timeout_addshop');
		}

		$shop['sid']=(int)$_GET['sid'];
		$shop['cid']=(int)$_GET['cid'];
		$shop['pic_path']=isset($_GET['pic_path'])?$_GET['pic_path']:'';
		$shop['item_score']=(float)$_GET['item_score'];
		$shop['service_score']=(float)$_GET['service_score'];
		$shop['delivery_score']=(float)$_GET['delivery_score'];
		$shop['created']=$_GET['created'];
		$shop['title']=$_GET['title'];
		$shop['auction_count']=(int)$_GET['auction_count'];
		$shop['shop_click_url']=$_GET['click_url'];
		$shop['fanxianlv']=(float)$_GET['fanxianlv'];
		$shop['taoke']=(int)$_GET['taoke'];
		$shop['type']=$_GET['shop_type'];
		$shop['level']=(int)$_GET['seller_credit'];
		$admin=(int)$_GET['admin'];
		if($shop['type']=='B'){
			$shop['level']=21;
		}
		$shop['nick']=$_GET['seller_nick'];
		$shop['total_auction']=(int)$_GET['total_auction'];
		$shop['uid']=(int)$_GET['user_id'];
		$shop_info=$duoduo->select('shop', 'id,addtime', 'sid="'.$shop['sid'].'"');
		$shopid=$shop_info['id'];
		$addtime=(int)$shop_info['addtime'];
		if(!$shopid){
			$shop['hits']=0;
			$shop['sort']=0;
			$shop['addtime']=TIME;
			$shop['hits']=0;
			if($admin==1 || ($webset['shop']['open']==1 && $shop['fanxianlv']>0 && (($shop['level']>=$webset['shop']['slevel'] && $shop['level']<=$webset['shop']['elevel']) || $shop['level']==21))){
				$duoduo->insert('shop',$shop);
			}
		}
		elseif(TIME-$addtime>3600*24*5){ //店铺添加后大于5天触发更新
			$data['level']=$shop['level'];
			$data['type']=$shop['type'];
			$data['taoke']=$shop['taoke'];
			$data['total_auction']=$shop['total_auction'];
			$data['auction_count']=$shop['auction_count'];
			$data['item_score']=$shop['item_score'];
			$data['service_score']=$shop['service_score'];
			$data['delivery_score']=$shop['delivery_score'];
			$data['fanxianlv']=$shop['fanxianlv'];
			$data['pic_path']=$shop['pic_path'];
			$data['addtime']=TIME;
			$data['hits']=$shop['hits']+1;
			$duoduo->update('shop',$data,'sid="'.$shop['sid'].'"');
		}
	break;
	
	case 'jssdk_cache':
		$json=str_replace('’‘',"'",$_POST['json']);
		
		if(!preg_match('#\.json$#',$_POST['dir'])){
			exit('error dir');
		}
		$arr=json_decode($json,1);
		if(!is_array($arr)){
			exit('error json');
		}
		
		$dir=DDROOT.str_replace('http://'.$_SERVER['HTTP_HOST'].URLMULU,'',$_POST['dir']);
		create_file($dir,$json,0,1,1);
		
	break;
	
	case 'shop_items_get':
	
		$check=authcode($_GET['check'],'DECODE');
		if($_SERVER['REQUEST_TIME']-$check>5){
			//dd_exit('timeout_shop_items_get');
		}
		
		$shop['taoke']=(int)$_GET['taoke'];
		$shop['shoplevel']=(int)$_GET['level'];
		$shop['uid']=(int)$_GET['uid'];
		$shop['nick']=$_GET['nick'];
		$shop['outer_code']=(int)$_GET['outer_code'];
		$list=(int)$_GET['list'];
		$TaobaokeItem=$ddTaoapi->shop_items_get($shop);
		if(!empty($TaobaokeItem)){
			if($list==1){
				foreach($TaobaokeItem as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a class="taopic" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>" target="_blank" pic="<?=base64_encode($row["pic_url"].'_310x310.jpg')?>"><?=html_img($row["pic_url"],11,$row["name"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>本期已售出<span><?php echo $row["commission_num"] ?> </span>件 <img alt="等级" src="images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /> </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"])?><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a url="userNumId=<?=$shop['uid']?>&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$goods['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <?php if($row["fxje"]>0){?>
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p> 
                            <?php }else{?>
                            <p> <span class="greenfont">暂无返</span> </p>
                            <?php }?>
                            <p>&nbsp;<a target="_blank" href="<?=$row["go_view"]?>">详情</a></p>
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao" style="clear:both; margin-top:5px; width:150px;"></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=u('tao','list',array('cid'=>0,'q'=>$row["name"]))?>"><div class="goodslist_main_right_bj"></div></a>
                                <a target="_blank" <?php if($webset['taoapi']['fanlitip']==1){?> class="fanlitip" <?php }?> rel="nofollow" href="<?=$row['jump']?>"><div class="goodslist_main_right_buy">去淘宝购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }}
					
			if($list==2){
				foreach($TaobaokeItem as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank"><?=html_img($row["pic_url"],12,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img alt="等级" src="images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /></p> </div>
                            <div class="goodslist_main_left_seller_2"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"],2)?></p>
                            </div>
                        	<p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao">淘宝热卖商品</p>
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返：<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p>
                            <div class="goodslist_main_right_tb_2">
                                  <a rel="nofollow" href="<?=$row['jump']?>" target="_blank" ><div class="goodslist_main_right_buy">去淘宝购买</div></a><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a url="userNumId=<?=$shop['uid']?>&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$goods['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?>
                            </div>
                        </li>
                    <?php }}
					
					?>
        
		<?php }
		else{
			
		}
	break;
	
	case 'seer_shop_items_get':
	
		$check=authcode($_GET['check'],'DECODE');
		if($_SERVER['REQUEST_TIME']-$check>5){
			//dd_exit('timeout_shop_items_get');
		}
		
		$shop['taoke']=(int)$_GET['taoke'];
		$shop['shoplevel']=(int)$_GET['level'];
		$shop['uid']=(int)$_GET['uid'];
		$shop['nick']=$_GET['nick'];
		$shop['outer_code']=(int)$_GET['outer_code'];
		$list=(int)$_GET['list'];
		$TaobaokeItem=$ddTaoapi->shop_items_get($shop);
		if(!empty($TaobaokeItem)){
			if($list==1){
				foreach($TaobaokeItem as $row) {?>
                        <li class="info">
                        <div class="goodslist_main_left">
                        	<div class="goodslist_main_left_img"><a class="taopic" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>" target="_blank" pic="<?=base64_encode($row["pic_url"].'_310x310.jpg')?>"><?=html_img($row["pic_url"],11,$row["name"])?></a></div>
                        	<div class="goodslist_main_left_bt title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_sell"><p>本期已售出<span><?php echo $row["commission_num"] ?> </span>件 <img alt="等级" src="images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /> </p> </div>
                            <div class="goodslist_main_left_seller"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"])?><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a url="userNumId=<?=$shop['uid']?>&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$goods['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?></p>
                            </div>
                        </div>
                        <div class="goodslist_main_right">
                        	<div class="goodslist_main_right_price">
                            <p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <?php if($row["fxje"]>0){?>
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p> 
                            <?php }else{?>
                            <p> <span class="greenfont">暂无返</span> </p>
                            <?php }?>
                            <p>&nbsp;<a target="_blank" href="<?=$row["go_view"]?>">详情</a></p>
                            <p id="<?=$row["num_iid"]?>" class="tbcuxiao" style="clear:both; margin-top:5px; width:150px;"></p>
                        	</div>
                            <div style="clear:both"></div>
                            <div class="goodslist_main_right_tb">
                                <a target="_blank" href="<?=u('tao','list',array('cid'=>0,'q'=>$row["name"]))?>"><div class="goodslist_main_right_bj"></div></a>
                                <a target="_blank" <?php if($webset['taoapi']['fanlitip']==1){?> class="fanlitip" <?php }?> rel="nofollow" href="<?=$row['jump']?>"><div class="goodslist_main_right_buy">去淘宝购买</div></a>
                            </div>
                        </div>
                        </li>
                    <?php }}
					
			if($list==2){
				foreach($TaobaokeItem as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank"><?=html_img($row["pic_url"],12,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img alt="等级" src="../images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /></p> </div>
<!--                            <div class="goodslist_main_left_seller_2"><p>卖家：<A href="<?=$row["go_shop"]?>" target=_blank title="逛逛<?=$row["nick"]?>的店铺"><?=$row["nick"]?></a> <?=wangwang($row["nick"],2)?></p></div>-->
                        	<p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返：<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p>
                            <div><input type="checkbox" name='select_goods_box[]'/></div>
<!--                            <div class="goodslist_main_right_tb_2">
                                  <a rel="nofollow" href="<?=$row['jump']?>" target="_blank" ><div class="goodslist_main_right_buy">去淘宝购买</div></a><?php if($webset['taoapi']['goods_comment']==1){?>&nbsp;&nbsp; (<a url="userNumId=<?=$shop['uid']?>&auctionNumId=<?=$row["num_iid"]?>" goto="<?=$goods['jump']?>" style="color:#06F; text-decoration:underline; cursor:pointer" class="seecomment">查看评价</a>) <?php }?>
                            </div>-->
                        </li>
                    <?php }}
					
					?>
        
		<?php }
		else{
			
		}
	break;
	case 'get_taobao_itemcats':
		$cid = (int)$_GET['cid'];
		$Taobao_itemcats=$ddTaoapi->taobao_itemcats($cid);
		if(!empty($Taobao_itemcats)){
			?>
			 <option value=''>请选择</option>
			<?php foreach($Taobao_itemcats as $row) {?>
			<option value='<?= $row['cid']?>'><?= $row['name']?></option>
			<?php }
		}
	break;
	
	case 'get_outlets_items':
		$Tapparams = array(
		'fields'=>'num_iid,title,cid,nick,seller_credit_score,pic_url,price,click_url,shop_click_url,volume,commission,commission_rate,commission_num,commission_volume,item_location',
		//'nick'=>'',
		//'pid'=>'',
		'keyword'=>$_GET['outlets_item_keyword'],
		'cid'=>'',//$_GET['outlets_item_cid']1512
		'page_no'=>1,
		'page_size'=>6,
		'sort'=>$_GET['outlets_item_sort'],
		'start_credit'=>$_GET['outlets_item_start_credit'],
		'end_credit'=>$_GET['outlets_item_end_credit'],
		'start_price'=>$_GET['outlets_item_start_price'],
		'end_price'=>$_GET['outlets_item_end_price'],
		'guarantee'=>$_GET['outlets_item_checkbox_guarantee'],
		'sevendays_return'=>$_GET['outlets_item_checkbox_sevendays_return'],
		'overseas_item'=>$_GET['outlets_item_checkbox_overseas_item'],
		'cash_ondelivery'=>$_GET['outlets_item_checkbox_cash_ondelivery'],
		'vip_card'=>$_GET['outlets_item_checkbox_vip_card'],
		'cash_coupon'=>$_GET['outlets_item_checkbox_cash_coupon'],
		'real_describe'=>$_GET['outlets_item_checkbox_real_describe'],
		'onemonth_repair'=>$_GET['outlets_item_checkbox_onemonth_repair'],
		'mall_item'=>$_GET['outlets_item_checkbox_mall_item'],
		'start_commissionRate'=>$_GET['outlets_item_start_commissionRate'],
		'end_commissionRate'=>$_GET['outlets_item_end_commissionRate'],
		'start_commissionNum'=>$_GET['outlets_item_start_commissionNum'],
		'end_commissionNum'=>$_GET['outlets_item_end_commissionNum'],
//		'outer_code'=>0,
//		'seller'=>1,
//		'total'=>1,
		);
		$Taobao_items=$ddTaoapi->taobao_taobaoke_items_get($Tapparams);
		$Taobao_items=arr_diff($Taobao_items, array('total'));//去掉数组中的total
		if($_GET['select']){
			$selectid = explode(',',$_GET['selectid']);
			$selected_goods = array();
			foreach ($Taobao_items as $k => $select_row) {
				if(substr_count((string)$_GET['selectid'],(string)$select_row['num_iid'])>0){ 
//					array_push($selected_goods,$select_row);
					$field_arr=array(
					'outlet_id'=>1,
					'num_iid'=>$select_row['num_iid'],
					'price'=>$select_row['price'],
					'title'=>$select_row['title'],
					'shop_click_url'=>$select_row['shop_click_url'],
					'pic_url'=>$select_row['pic_url'],
					'commission'=>$select_row['commission'],
					'nick'=>$select_row['nick'],
					'item_type'=>1,
					'addtime'=>TIME,					
					);
					$duoduo->insert('outlets_goods',$field_arr);
				}
			}
			exit();
		}
		
		if(!empty($Taobao_items)){
				foreach($Taobao_items as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank"><?=html_img($row["pic_url"],12,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img alt="等级" src="../images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /></p> </div>
                        	<p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返：<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p>
                            <div><input type="checkbox" name='select_goods_box' value="<?=$row["num_iid"]?>"/></div>

                        </li>
                    <?php }
		}
	break;
	
	case 'get_outlets_items_coupon':
		$Tapparams = array(
		'fields'=>'num_iid,title,nick,cid,pic_url,price,click_url,commission,commission_rate,commission_num,commission_volume,shop_click_url,seller_credit_score,item_location,volume,coupon_price,coupon_rate,coupon_start_time,coupon_end_time,shop_type',
		//'nick'=>'',
		//'pid'=>'',
		'keyword'=>$_GET['outlets_item_coupon_keyword'],
		'cid'=>'',//$_GET['outlets_item_cid']1512
		'page_no'=>1,
		'page_size'=>1,
		'sort'=>$_GET['outlets_item_coupon_sort'],
		'coupon_type'=>1,
		'shop_type'=>$_GET['outlets_item_coupon_shop_type'],
		'start_credit'=>$_GET['outlets_item_coupon_start_credit'],
		'end_credit'=>$_GET['outlets_item_coupon_end_credit'],
		'start_coupon_rate'=>$_GET['outlets_item_coupon_start_coupon_rate'],
		'end_coupon_rate'=>$_GET['outlets_item_coupon_end_coupon_rate'],
		'start_commission_rate'=>$_GET['outlets_item_coupon_start_commission_rate'],
		'end_commission_rate '=>$_GET['outlets_item_coupon_end_commission_rate'],
		'start_commission_num'=>$_GET['outlets_item_coupon_start_commission_num'],
		'end_commission_num'=>$_GET['outlets_item_coupon_end_commission_num'],
//		'outer_code'=>0,
//		'seller'=>1,
//		'total'=>1,
		);
		print_r($Tapparams);
		$Taobao_items_coupon=$ddTaoapi->taobao_taobaoke_items_coupon_get($Tapparams);
		$Taobao_items_coupon=arr_diff($Taobao_items_coupon, array('total'));//去掉数组中的total
		if($_GET['select']){
			$selectid = explode(',',$_GET['selectid']);
			$selected_goods = array();
			foreach ($Taobao_items_coupon as $k => $select_row) {
				if(substr_count((string)$_GET['selectid'],(string)$select_row['num_iid'])>0){ 
//					array_push($selected_goods,$select_row);
					$field_arr=array(
					'outlet_id'=>1,
					'num_iid'=>$select_row['num_iid'],
					'price'=>$select_row['price'],
					'title'=>$select_row['title'],
					'shop_click_url'=>$select_row['shop_click_url'],
					'pic_url'=>$select_row['pic_url'],
					'commission'=>$select_row['commission'],
					'nick'=>$select_row['nick'],
					'item_type'=>2,
					'addtime'=>TIME,					
					);
					$sqlresult = $duoduo->insert('outlets_goods',$field_arr);
					
				}
			}
			exit();
		}
		
		if(!empty($Taobao_items_coupon)){
				foreach($Taobao_items_coupon as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank"><?=html_img($row["pic_url"],12,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2">
                            <p class="price">
                            	￥<em><?=$row['coupon_price']?></em>&nbsp; 
                            	原:￥<em style='text-decoration:line-through;'><?=$row['price']?></em>&nbsp; 
                            </p>
                            </div>
                            <p class='coupon-rate'><em class='item_coupon_rate_em'>折扣：<?=round($row['coupon_rate']/1000,1)?>折</em></p>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img alt="等级" src="../images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /></p> </div>
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返：<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p>
                            <div><input type="checkbox" name='select_goods_box'  value="<?=$row["num_iid"]?>"/></div>

                        </li>
                    <?php }
		}
	break;
	
	case 'get_outlets_items_shop':
		$Tapparams = array(
		'fields'=>'user_id,seller_nick,shop_id,shop_title,seller_credit,shop_type,commission_rate,click_url,total_auction,auction_count',
		//'nick'=>'',
		//'pid'=>'',
		'uid'=>'436645665',
		'seller_nick'=>$_GET['outlets_item_shop_nick'],
		'shop_type'=>$_GET['outlets_item_shop_shop_type'],
		'count'=>40,
		'sort'=>$_GET['outlets_item_shop_sort'],
//		'outer_code'=>0,
//		'seller'=>1,
//		'total'=>1,
		);
		print_r($Tapparams);
		$s = $ddTaoapi->taobao_taobaoke_shops_relate_convert($Tapparams);
		print_r($s);
		$Taobao_items_shop=$ddTaoapi->shop_items_get($Tapparams);
		$Taobao_items_shop=arr_diff($Taobao_items_shop, array('total'));//去掉数组中的total
		if(!empty($Taobao_items_shop)){
				foreach($Taobao_items_shop as $row) {?>
                        <li class="info">
                            <div class="goodslist_main_left_img_2"><a <?=webtype('rel="nofollow" class="fanlitip"')?> href="<?=$row["gourl"]?>" target="_blank"><?=html_img($row["pic_url"],12,$row["name"],'',160,160)?></a></div>
                        	<div class="goodslist_main_left_bt_2 title"><a target="_blank" <?=webtype('rel="nofollow"')?> href="<?=$row["gourl"]?>"><?php echo $row["title"] ?></a></div>
                            <div class="goodslist_main_left_xy_2"><p>卖家信用：<img alt="等级" src="../images/level_<?=$shop['shoplevel']?>.gif" align="absmiddle" /></p> </div>
                        	<p class="price">淘宝价：<span><?=$row["price"]?></span> 元 </p> 
                            <p class="fxje" title="<?=TBFLTIP?>"> 可返：<span class="greenfont"><?=$row["fxje"]?></span><?=TBMONEYUNIT?><?=TBMONEY?> </p>
                            <div><input type="checkbox" name='select_goods_box'  value="<?=$row["num_iid"]?>"/></div>

                        </li>
                    <?php }
		}
	break;
	
	
}
$duoduo->close();
unset($duoduo);
unset($ddTaoapi);
unset($webset);
exit;
?>
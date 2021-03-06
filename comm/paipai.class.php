<?php
/**
 * ============================================================================
 * 版权所有 2008-2012 多多网络，并保留所有权利。
 * 网站地址: http://soft.duoduo123.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
*/

class paipai{
	public $dduser;
	public $cache_time=0;
	public $errorlog=0;
	public $userId;
	public $qq;
	public $appOAuthID;
	public $secretOAuthKey;
	public $accessToken;
	public $paipaicpsurl='http://api.paipai.com';
	public $charset='utf-8';
	public $format='json';
	public $pureData=1;
	public $nowords;
	
	public function __construct($dduser,$paipai_set){
		$this->dduser=$dduser;
		$this->userId=$paipai_set['userId'];
		$this->qq=$paipai_set['qq'];
		$this->appOAuthID=$paipai_set['appOAuthID'];
		$this->secretOAuthKey=$paipai_set['secretOAuthKey'];
		$this->accessToken=$paipai_set['accessToken'];
		$this->fxbl=$paipai_set['fxbl'];
		$this->cache_time=(int)$paipai_set['cache_time'];
		$this->errorlog=(int)$paipai_set['errorlog'];
		if(REPLACE<3){
			$noword_tag='';
		}
		else{
			$noword_tag='3';
		}
		$this->nowords=dd_get_cache('no_words'.$noword_tag);
	}
	
	public function build_query($parame){
		$parame['charset']=$this->charset;
		$parame['format']=$this->format;
		$parame['pureData']=$this->pureData;
		return http_build_query($parame);
	}
	
	function cache_dir($parame){
		unset($parame['userId']); //去掉userid参数，使不同的访问者使用相同的缓存
		$cacheid=md5($this->build_query($parame));
		return $cache_dir=DDROOT.'/data/temp/paipai/'.substr($cacheid,0,2).'/'.$cacheid.'.json';
	}
	
	function get_cache($parame,$api_name){
		$cache_dir=$this->cache_dir($parame);
		if(file_exists($cache_dir) && TIME-filectime($cache_dir)<=$this->cache_time*3600 && $api_name!='/cps/etgReportCheck.xhtml'){
			return $row=json_decode(file_get_contents($cache_dir),1); 
		}
		else{
			return $cache_dir;
		}
	}
	
	function get($api_name,$parame){
		$val=$this->get_cache($parame,$api_name);
		if(is_array($val)){
			return $val;
		}
		$cache_dir=$val;
		$url=$this->paipaicpsurl.$api_name.'?'.$this->build_query($parame);
		$b=dd_get_json($url);
		if(!isset($b['errorCode']) || $b['errorCode']==0){
			if($this->cache_time>0){
				create_file($cache_dir,json_encode($b));
			}
			return $b;
		}
		else{
			if($this->errorlog==1){
				$error=$b['errorCode'].':'.$b['errorMessage']."\r\n";
				create_file(DDROOT.'/data/temp/paipai_error_log/'.date('Ymd').'.txt',$error,1,1);
			}
			return 102;
		}
	}
	
	public function cpsCommSearch($parame){
		$api_name='/cps/cpsCommSearch.xhtml';
		$parame['userId']=$this->userId;
		$parame['outInfo']=$this->dduser['id'];
		$parame['pageIndex']=$parame['pageSize']*($parame['pageIndex']-1)+1;
		
		$row=$this->get($api_name,$parame);
		$row=$row['CpsCommSearchResult'];
		foreach($row['vecComm'] as $k=>$a){
			$arr['tagUrl']=$a['tagUrl'];
			$arr['commId']=$a['commId'];
			$arr['leafClassId']=$a['leafClassId'];
			$arr['smallImg']=$a['imgUri'];
			$arr['middleImg']=str_replace('0.jpg.2.jpg','0.jpg.3.jpg',$a['imgUri']);
			$arr['bigImg']=$a['bigUri'];
			$arr['title']=$a['title'];
			$arr['title']=dd_replace($arr['title'],$this->nowords);
			$arr['nickName']=$a['nickName'];
			$arr['uin']=$a['uin'];
			$arr['crValue']=$a['crValue'];
			$arr['price']=round($a['price']/100,2);
			$arr['crValue']=round($a['crValue']/100,2);
			$arr['fxje']=fenduan($arr['crValue'],$this->fxbl,$this->dduser['level']);
			$arr['level']=$a['level']==0?11:$a['level']; //等级图片网址http://static.paipaiimg.com/module/icon/credit/credit_s22.gif
			$arr['saleNum']=$a['saleNum'];
			$arr['leg4Status']=$a['leg4Status']; //假一赔三
			$arr['leg3Status']=$a['leg3Status']; //闪电发货
			$arr['leg2Status']=$a['leg2Status']; //7天包退
			$arr['leg1Status']=$a['leg1Status']; //先行赔付
			$arr['cashStatus']=$a['cashStatus']; //货到付款
			$arr['jump']=u('jump','paipaigoods',array('url'=>base64_encode($arr['tagUrl']),'name'=>$arr['title'],'pic'=>base64_encode($arr['smallImg']),'price'=>$arr['price'],'fan'=>$arr['fxje'],'id'=>$arr['commId']));
			$goods[]=$arr;
		}
		$goods['total']=$row['hitNum'];
		return $goods;
	}
	
	function cpsCommQueryAction($parame){
		$api_name='/cps/cpsCommQueryAction.xhtml';
		$parame['userId']=$this->userId;
		$parame['outInfo']=$this->dduser['id'];
		$parame['commId']=$parame['commId'];
		
		$row=$this->get($api_name,$parame);
		$row=$row['CpsQueryResult']['cpsSearchCommData'];
		if(!$row){return 102;}
		$arr['title']=$row['sTitle'];
		$arr['title']=dd_replace($arr['title'],$this->nowords);
		$arr['commId']=$row['sRespCommId'];
		$arr['price']=round($row['dwPrice']/100,2);
		
		if($row['dwActiveFlag']==1){
			if($row['dwPrimaryCmm']==1){
				$arr['commission']=round($arr['price']*($row['dwPrimaryRate']/10000),2);
			}
			else{
				$arr['commission']=round($arr['price']*($row['dwClassRate']/10000),2);
			}
			$arr['fxje']=fenduan($arr['commission'],$this->fxbl,$this->dduser['level']);
		}
		
		$arr['uin']=$row['dwUin'];
		$arr['dwTransportPriceType']=$row['dwTransportPriceType'];
		$arr['dwNormalMailPrice']=$row['dwNormalMailPrice'];
		$arr['dwExpressMailPrice']=$row['dwExpressMailPrice'];
		$arr['dwEmsMailPrice']=$row['dwEmsMailPrice'];
		$arr['cid']=$row['dwLeafClassId'];	
		$arr['dwNum']=$row['dwNum'];
		$arr['saleNum']=$row['dwPayNum'];
		$arr['smallImg']=$row['sCommImgUrl'].'.2.jpg';
		$arr['middleImg']=$row['sCommImgUrl'].'.3.jpg';
		$arr['bigImg']=$row['sCommImgUrl'];
		$arr['tagUrl']=$row['sClickUrl'];
		$arr['jump']=u('jump','paipaigoods',array('url'=>base64_encode($arr['tagUrl']),'name'=>$arr['title'],'pic'=>base64_encode($arr['smallImg']),'price'=>$arr['price'],'fan'=>$arr['fxje'],'id'=>$arr['commId']));
		return $arr;
	}
	
	function etgReportCheck($parame=array()){
		$api_name='/cps/etgReportCheck.xhtml';
		$sys_parame = array ('timeStamp' => time(), 'randomValue' => 123456, 'uin' => $this->qq, 'accessToken' => $this->accessToken, 'appOAuthID' => $this->appOAuthID);
		$request_parame = array (
			'charset' => $this->charset,
			'format' => $this->format,
			'pureData' => 1,
			'beginTime' => $parame['beginTime']?$parame['beginTime']:date('Y-m-d'),
			'endTime'=>$parame['beginTime']?$parame['beginTime'].' 23:59:59':date('Y-m-d').' 23:59:59',
			'reportType'=>1,
			'pageIndex'=>$parame['pageIndex']?$parame['pageIndex']:1,
			'pageSize'=>$parame['pageSize']?$parame['pageSize']:40,
			'userId'=>$this->qq
		);
		
		$parame=$sys_parame+$request_parame;
		ksort($parame);
		$str='';
		
		foreach($parame as $k=>$v){
			$str.=$k.'='.$v.'&';
		}
		$str=preg_replace('/&$/','',$str);
		$str='GET&'.rawurlencode($api_name).'&'.rawurlencode($str);
		$sign=base64_encode(hash_hmac('sha1',$str,$this->secretOAuthKey.'&',true));
		$parame['sign']=$sign;
		$row=$this->get($api_name,$parame);
		$total=$row['EtgReportResult']['totalNum'];
		$row=$row['EtgReportResult']['etgReportDatas'];
		$row['total']=$total;
		return $row;
	}
	
	function url2commId($url){
		preg_match('#[0-9A-Z]{32}#',$url,$a);
		return $a[0];
	}
}
?>
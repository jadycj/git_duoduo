<?php //多多平台接口
class ddopen{
	public $openname='';
	public $openpwd='';
	public $open_sms_pwd='';
	public $openurl='/api/';
	public $format='json';
	public $mod='jifenbao';
	
	function __construct(){
		$this->openurl=DD_OPEN_URL.$this->openurl;
	}
	
	function ini(){
		$openpwd=get_cookie('ddopenpwd');
		$this->openname=get_domain(URL);
		if($openpwd==''){
			return 0;
		}
		$this->openpwd=md5($openpwd);
		return 1;
	}
	
	function sms_ini($open_sms_pwd){
		$this->openname=get_domain();
		if($open_sms_pwd==''){
			return 0;
		}
		$this->open_sms_pwd=$open_sms_pwd;
		return 1;
	}
	
	function sms_send($mobile,$content,$msgset_id){
		$mod='sms';
		$act='send';
		$parame=array('mod'=>$mod,'act'=>$act,'mobile'=>$mobile,'content'=>$content,'msgset_id'=>$msgset_id);
		$row=$this->get($parame);
		return $row;
	}
	
	function sms_content_check($content){
		$black_words=dd_get(DD_OPEN_URL.'/data/black_words.txt');
		$black_words=explode(';',$black_words);
		unset($black_words[0]);
		foreach($black_words as $v){
			if(strpos($content,$v)!==false){
				$re=array('s'=>1,'r'=>$v);
				return $re;
			}
		}
		return array('s'=>0);
	}
	
	function pay_jifenbao($alipay,$num,$txid,$realname,$mobile){
		$mod='jifenbao';
		$act='pay';
		$parame=array('mod'=>$mod,'act'=>$act,'alipay'=>$alipay,'num'=>(int)$num,'txid'=>$txid,'url'=>URL,'realname'=>$realname,'mobile'=>$mobile);
		$row=$this->get($parame);
		return $row;
	}
	
	function cancel_jifenbao($txid){
		$mod='jifenbao';
		$act='cancel';
		$parame=array('mod'=>$mod,'act'=>$act,'txid'=>$txid,'url'=>URL);
		$row=$this->get($parame);
		return $row;
	}
	
	function get_user_info(){
		$mod='user';
		$act='get_info';
		$parame=array('mod'=>$mod,'act'=>$act);
		$row=$this->get($parame);
		return $row;
	}
	
	function get_user_sms(){
		$mod='sms';
		$act='get_user_num';
		$parame=array('mod'=>$mod,'act'=>$act);
		$row=$this->get($parame);
		return $row;
	}
	
	function get($parame){
		$parame['openname']=$this->openname;
		if($parame['mod']=='sms'){
			$parame['open_sms_pwd']=$this->open_sms_pwd;
		}
		else{
			$parame['openpwd']=$this->openpwd;
		}
		
		$parame['format']=$this->format;
		$url=$this->openurl.'?'.http_build_query($parame);
		//file_put_contents(DDROOT.'/a.txt',$url);
		if($this->format=='xml'){
			$row=dd_get_xml($url);
		}
		elseif($this->format=='json'){
			$row=dd_get_json($url);
		}
		return $row;
	}
}
?>
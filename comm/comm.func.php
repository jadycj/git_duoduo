<?php
/*数组相关函数*/
function logout_key($a, $b) {
	foreach ($b as $v) {
		unset ($a[$v]);
	}
	return $a;
}

function arr_diff($arr1, $arr, $xs = 1) { //xs=0，arr是键值  xs=1，arr是键名
	if ($xs == 1) {
		foreach ($arr as $k => $v) {
		    $arr1[$v] = '%$%^@#$asdsfsdf355432';
		}
		$arr3 = array_diff($arr1, array('%$%^@#$asdsfsdf355432'));
	} 
	else {
		$arr3 = array_diff($arr1, $arr);
	}
	return $arr3;
}

function empty2zero(&$arr,$keyarr){ //指定键值空转0
    foreach ($arr as $key => $value) {
        if (is_array($value)) {
            empty2zero($arr[$key]);
        } else {
            $value = trim($value);
            if ($value == '' and in_array($key,$keyarr)) {
                $arr[$key] = 0;
            }
        }
    }
}

function arr2param($arr){
	$param='';
    foreach($arr as $k=>$v){
		$param.='&'.$k.'='.rawurlencode($v);
	}
	return $param;
}

function diguiFilter(&$p, $ArrFiltrate,$c) {
	for ($i=0;$i<$c;$i++) {
		$sql = $ArrFiltrate[$i];
		if (strpos(strtolower($p), $sql)!==false) {
			$p = preg_replace('#' . $sql . '#i', '', $p);
			diguiFilter($p, $ArrFiltrate,$c);
		} else {
			if($i==$c-1){return false;}
		}
	}
}

function filter(&$array,$ArrFiltrate,$c=0)
{
	if($c==0){
		$c=count($ArrFiltrate);
	}
	if (is_array($array))
	{
		foreach ($array as $key => $value)
		{
			if (is_array($value))
				filter($array[$key],$ArrFiltrate,$c);
			else
				diguiFilter($array[$key], $ArrFiltrate,$c);
		}
	}
}

function arr_replace($arr,$key,$val){
    $arr[$key]=$val;
	return $arr;
}

function arr_get_key($arr,$v){
	foreach($arr as $key=>$val){
	    if($v==$val){
			return $key;
		}
	}
}

/*function dd_float($arr){ //数字格式化
	if(is_array($arr)){
		foreach ($arr as $key => $value) {
			if(is_array($value)){print_r($value);exit;}
            $value = trim($value);
            if(is_numeric($value) && strlen($value)<11){
		        $arr[$key] = (float)$value;
	        }
        }
	}
	else{
		if(is_numeric($arr) && strlen($arr)<=11){
		    $arr = (float)$arr;
	    }
	}
	return $arr;
}

function dd_string($arr){ //字符格式化
	if(is_array($arr)){
		foreach ($arr as $key => $value) {
            $value = trim($value);
		    $arr[$key] = (string)$value;
        }
    }
	else{
		$arr=(string)$value;
	}
	return $arr;
}*/

function dd_float(&$arr){ //数字格式化
	foreach ($arr as $key => $value) {
        if (is_array($value)) {
            dd_float($arr[$key]);
        } else {
            $value = trim($value);
            if(!preg_match('/^0.*/',$value) && is_numeric($value) && strlen($value)<11){
		        $arr[$key] = (float)$value;
	        }
        }
    }
}

function dd_string(&$arr){ //字符格式化
	foreach ($arr as $key => $value) {
        if (is_array($value)) {
            dd_float($arr[$key]);
        } else {
            $value = trim($value);
		    $arr[$key] = (string)$value;
        }
    }
}

function dd_addslashes(&$v,$do=0) {
	if (get_magic_quotes_gpc() == 0 || $do==1) {
		if (is_array($v)) {
			foreach ($v as $key => $value) {
				if (is_array($value)) {
					dd_addslashes($v[$key]);
				} else {
					$value = addslashes(trim($value));
					$v[$key] = $value;
				}
			}
		}
		else {
			$v = addslashes($v);
		}
	}
	return $v;
}

function trim_arr(&$arr){
	if (is_array($arr)) {
		foreach($arr as $k=>$v){
			if (is_array($v)) {
				 trim_arr($v);
			}
			else{
				$arr[$k]=trim($v);
			}
		}
	}
	else{
		$arr=trim($arr);
	}
}

function back_arr($a) {  //倒叙数组
	$c = count($a);
	$d = $c;
	$b = array ();
	$m = 0;

	for ($i = 0; $i < $d; $i++) {
		$c = count($a);
		foreach ($a as $k => $v) {
			$m++;
			if ($m == $c) {
				$b[$k] = $v;
				$m = 0;
				unset ($a[$k]);
			}
		}
	}
	return $b;
}

function arr2canshu($array){
	$b='';
	foreach($array as $v){
		$b.='ids%5B%5D='.$v.'&';
	}
	return preg_replace('/&$/','',$b);
}

/*html相关函数*/
function select($array, $id = 10000, $name,$attr='',$return=0) {
	$i = 0;
	$s = '<select name="'.$name.'" id="'.$name.'" class="'.$name.'" '.$attr.'>';
	foreach ($array as $key => $val) {
		if ($id == $key && isset($id)){
		    $select = 'selected';
		}
		else{
			$select = '';
		}
		$s.= "<option value='$key' $select style='background:$bg'>$val</option>";
		$i++;
	}
	$s.= "</select>";
	if($return==1){
		return $s;
	}
	else{
		echo $s;
	}
}

function html_radio($array,$id,$name){
    foreach ($array as $key => $val) {
		if ($id == $key)
			$checked = 'checked="checked"';
		else
			$checked = '';
		echo "<label><input ".$checked." name='".$name."' type='radio' value='".$key."' /> ".$val."</label>&nbsp;&nbsp;";
	}
}

function html_img($pic_url,$type='',$alt='',$class='',$width='',$height='',$onerror_pic=''){ //type大于10为不给图片进行js加密，类型再去个位数
	if($onerror_pic==''){
		$onerror_pic=SITEURL.'/images/dian.png';
	}
	if($type>=10){$img_type=$type%10;}
	else{$img_type=$type;}
	switch($img_type){
	    case 1:
		    $pic_url=$pic_url."_100x100.jpg";
		break;
		case 2:
		    $pic_url=$pic_url."_b.jpg";
		break;
		case 3:
		    $pic_url=$pic_url."_310x310.jpg";
		break;
	}
	$pic_url=base64_encode($pic_url);
	if($type>=10){
		if($alt!=''){$alt='alt="'.$alt.'"';}
	    if($class!=''){$class='class="'.$class.'"';}
	    if($width>0){$width='width:'.$width.'px';}else{$width='';}
	    if($height>0){$height=';height:'.$height.'px';}else{$height='';}
		$onerror='onerror="this.src=\''.$onerror_pic.'\'"';
		$re= "<img src='".base64_decode($pic_url)."' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
	}
	elseif(PICJM==0){
		if(strpos($alt,"'")!==false){
			$alt=str_replace("'",'',$alt);
		}
		
	    $re= "<SCRIPT language=javascript>setPic('".$pic_url."','".$width."','".$height."','".$alt."','".$class."','".$onerror_pic."');</SCRIPT>";
	}
	elseif(PICJM==1){
		$pic_url=urlencode($pic_url);
	    if($alt!=''){$alt='alt="'.$alt.'"';}
	    if($class!=''){$class='class="'.$class.'"';}
	    if($width>0){$width='width:'.$width.'px';}else{$width='';}
	    if($height>0){$height=';height:'.$height.'px';}else{$height='';}
		$onerror='onerror="this.src=\''.$onerror_pic.'\'"';
		if(PICWJT==0){
		    $re= "<img src='".SITEURL."/comm/showpic.php?pic=".$pic_url."' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
		}
	    else{
		    $re= "<img src='".SITEURL."/tbimg/".$pic_url.".jpg' ".$alt." ".$class." style='".$width." ".$height."' ".$onerror."/>";
		}
	}
	return $re;
}

function script($str){
    return '<script language="javascript" type="text/javascript">'.$str.'</script>';
}

function wangwang($nick,$type=1){
	$nick=urlencode($nick);
	switch($type){
	    case 1:
		    return '<a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$nick.'&site=cntaobao&s=2&charset=utf-8" ><img style="width:77px; height:19px" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$nick.'&site=cntaobao&s=1&charset=utf-8" alert="点击这里给我发消息" /></a>';
		break;   
		case 2:
		    return '<a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$nick.'&site=cntaobao&s=2&charset=utf-8" ><img style="width:16px; height:16px" border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid='.$nick.'&site=cntaobao&s=2&charset=utf-8" alt="点击这里给我发消息" /></a>';
		break;
	}
}

function qq($qq,$type=1){
	switch($type){
		case 1:
			return '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq.'&site=qq&menu=yes"><img style="height:16px" border="0" src="http://wpa.qq.com/pa?p=2:'.$qq.':46" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
		break;
		case 2:
			return '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$qq.'&site=qq&menu=yes"><img style="width:21px; height:21px" border="0" src="http://wpa.qq.com/pa?p=2:'.$qq.':45" alt="点击这里给我发消息" title="点击这里给我发消息"></a>';
		break;
	}
    
}

function a($uid, $size = '', $type = '') {
	$size = in_array($size, array (
		'big',
		'middle',
		'small'
	)) ? $size : 'middle';
	$uid = abs(intval($uid));
	$uid = sprintf("%010d", $uid);
	$dir1 = substr($uid, 0, 4);
	$dir2 = substr($uid, 4, 4);
	//$dir3 = substr($uid, 5, 2);
	$typeadd = $type == 'real' ? '_real' : '';
	$avatar_path='upload/avatar/'.$dir1 . '/' . $dir2 . '/' . substr($uid, -2) . $typeadd . "_avatar_$size.jpg";
	if(file_exists(DDROOT.'/'.$avatar_path)) return $avatar_path;
	else return 'upload/noavatar_'.$size.'.jpg';
}

function postform($action,$param){
	$authcode_arr=array('webid');
	$f='<form name="form" method="post" action="'.$action.'">';
	foreach($param as $k=>$v){
		if(in_array($k,$authcode_arr)){
			$v=authcode($v,'ENCODE',DDKEY);
		}
		$f.='<input type="hidden" name="'.$k.'" value="'.$v.'" />';
	}
    $f.="<input type='submit' style='width:0px; height:0px;filter:alpha(opacity=0);opacity:0' value='' /></form><script>document.form.submit();</script>";
	return $f;
}

function limit_input($name,$value=DEFAULTPWD,$width='150',$pwd=1){
    if(strpos($name,'[')!==false){
	    preg_match('/\[(.*)\]/',$name,$a);
		$b=str_replace('['.$a[1].']','',$name);
		$id=$b.$a[1];
	}
	else{
	    $id=$name;
	}
	if($pwd==1){
	    $type='password';
	}
	else{
	    $type='text';
	}
	return $s='<input style="width:'.$width.'px" type="'.$type.'" name="'.$name.'" id="'.$id.'" readonly="readonly" class="disabled" value="'.$value.'"/><input type="checkbox" title="激活修改" onClick="if($(this).attr(\'checked\')==true){$(\'#'.$id.'\').attr(\'readonly\',\'\').removeClass(\'disabled\');}else{$(\'#'.$id.'\').attr(\'readonly\',\'readonly\').addClass(\'disabled\');}"  />';
}


/*文件操作相关函数*/
function make_arr_cache($arr, $name,$root=0) {
	$data = "<?php\n return " . var_export($arr, true) . ";\n?>";
	if($root==0){
	    dd_file_put(DDROOT .'/' . $name . '.php', $data);
	}
	else{
	    dd_file_put($name . '.php', $data);
	}
}

function create_dir($dir) {
	if ($dir!='/' && !is_dir($dir)) {
		$d=str_replace(DDROOT.'/','',$dir);
		$d_arr=explode('/',$d);
		$di='';
		foreach($d_arr as $v){
			$di.='/'.$v;
			if(is_dir(DDROOT.$di)){
				if(iswriteable(DDROOT.$di)==0){
					return $di.'目录不可写';
				}
			}
			else{
				mkdir(DDROOT.$di);
			}
		}
	}
}

function create_file($file,$data='',$add=0,$detect=1,$original=0){
	$file=str_replace("\\", '/', $file);
    if($detect==1){
		$dir_arr=explode('/',$file);
	    $c=count($dir_arr);
		unset($dir_arr[$c-1]);
		$dir=implode('/',$dir_arr);
		create_dir($dir);
	}
	if($add==0){
		if($original==0){
			return dd_file_put($file,$data);
		}
		else{
			return file_put_contents($file,$data);
		}
	}
	else{
		return dd_file_put($file,$data,FILE_APPEND);
	}
}

function iswriteable($file){
	if(!file_exists($file)){
		return 0;
	}
	$writeable = 0;
    if(is_dir($file)){  
	    $dir=$file;  
		file_put_contents($dir.'/test.txt',1);
		if(file_exists($dir.'/test.txt')){
			if(unlink($dir.'/test.txt')){
				$writeable = 1; 
			}
		}
	}
	else{  
		if(file_exists($file)){
			$rename=rename($file,$file.'.duoduo');
			if($rename==1){
				rename($file.'.duoduo',$file);
			}
			file_put_contents($file,'duoduo_test_file_exists',FILE_APPEND);
			$a=file_get_contents($file);
			if(preg_match('/duoduo_test_file_exists$/',$a)){
				$a=preg_replace('/duoduo_test_file_exists$/','',$a);
				if(file_put_contents($file,$a)>0){
					$update = 1;
				}
			}
		}
		$writeable=$rename*$update;
	} 
	return $writeable;
}

function directory_size($directory) {
	$directorySize = 0;
	if(!file_exists($directory)){return 0;}
	if ($dh =  opendir($directory)) {
		while (($filename = readdir($dh))) {
			if ($filename != "." && $filename != "..") {
				if (is_file($directory . "/" . $filename))
					$directorySize += filesize($directory . "/" . $filename);
				if (is_dir($directory . "/" . $filename))
					$directorySize += directory_size($directory . "/" . $filename);
			}
		} 
	} 
    closedir($dh);
	return $directorySize;
}

function deldir($dir) {
	if (!file_exists($dir)) {
		return false;
	} 
	if($dh = opendir($dir)){
		while ($file = readdir($dh)) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (!is_dir($fullpath)) {
					unlink($fullpath);
				} else {
					deldir($fullpath);
				}
			}
		}
	closedir($dh);
	}
	if (rmdir($dir)) {
		return true;
	} else {
		return false;
	} 
}

function MkdirAll($truepath) {
	if (!file_exists($truepath)) {
		mkdir($truepath, 0777);
		chmod($truepath, 0777);
		return true;
	} else {
		return true;
	}
}

function judge_empty_dir($directory){      
    $handle = opendir($directory);      
    while (($file = readdir($handle)) !== false){          
        if ($file != "." && $file != ".."){              
            closedir($handle);              
            return 0;          
        }      
    }     
    closedir($handle);     
    return 1;  
}


/*文字字符串相关函数*/
function utf_substr($str, $len) {
	for ($i = 0; $i < $len; $i++) {
		$temp_str = substr($str, 0, 1);
		if (ord($temp_str) > 127) {
			$i++;
			if ($i < $len) {
				$new_str[] = substr($str, 0, 3);
				$str = substr($str, 3);
			}
		} else {
			$new_str[] = substr($str, 0, 1);
			$str = substr($str, 1);
		}
	}
	return join($new_str);
}

function str_del_last($str){
	$newstr = substr($str,0,strlen($str)-1);
	return $newstr;
}

/*验证相关函数*/
function reg_name($name,$min=3,$max=15,$shield_arr=array()){
	if($name=='网站客服'){
		return -2; //包含非法词汇
	}
	$strl=str_utf8_chinese_word_count($name)*2+str_utf8_english_count($name);
	if($strl<$min or $strl>$max){
	    return -1; //用户名不合法
	}
	if(!empty($shield_arr)){
	    foreach($shield_arr as $v=>$k){
	        if(strpos($name,$v)!==false){
			    return -2; //包含非法词汇
	        }
	    }
	}
	$pcre_name = "/^[a-zA-Z0-9_\.\-@\x80-\xff]+$/"; //utf-8
	//$pcre_name = "/^[a-z0-9_".chr(0xa1)."-".chr(0xff)."]+$/"; //gbk
    if(preg_match($pcre_name,$name)){
        return 1;
    }else{
        return -1;  //用户名不合法
    }
}

function reg_password($pwd){
	$pcre_pwd = '/.{6,20}/';
    if(preg_match($pcre_pwd,$pwd)){
        return 1;
    }else{
        return 0;
    }
}

function reg_email($email){
	$pcre_email = '/^[-0-9a-zA-Z_.]+@([0-9a-zA-Z][_\-0-9a-zA-Z.]{0,30}\.)[a-zA-Z]{2,10}$/';
    if(preg_match($pcre_email,$email)){
        return 1;
    }else{
        return 0;
    }
}

function reg_qq($qq){
	$pcre_qq = '/^[0-9]{4,20}$/';
    if(preg_match($pcre_qq,$qq) || reg_email($qq)==1){
        return 1;
    }else{
        return 0;
    }
}

function reg_mobile($mobile){
	$pcre_mobile = '/^1[0-9]{10}$/';
    if(preg_match($pcre_mobile,$mobile)){
        return 1;
    }else{
        return 0;
    }
}

function is_url($url){
	$pcre_url = '/^http:\/\/[\w-]+\.[\w-]+[\.[\w-]|]+[\/=\?%\-&~`@[\]\':+!\w]+$/';
    if(preg_match($pcre_url,$url)){
        return 1;
    }else{
        return 0;
    }
}

function reg_taobao_url($url){
    if(preg_match('/(taobao\.com|tmall\.com)/',$url)==1){
		return 1;
	}
	else{
	    return 0;
	}
}

function reg_alipay($alipay){
	$is_email=reg_email($alipay);
	if($is_email==1){
	    return 1;
	}
	else{
		$is_mobile=reg_mobile($alipay);
	    if($is_mobile==1){
		    return 1;
		}
		else{
		    return 0;
		}
	}
}

function reg_tenpay($tenpay){
	$is_email=reg_email($tenpay);
	if($is_email==1){
		return 1;
	}
	$is_qq=reg_qq($tenpay);
	if($is_qq==1){
		return 1;
	}
	$is_mobile=reg_mobile($tenpay);
	if($is_mobile==1){
		return 1;
	}
	return 0;
}

function reg_bank_code($code){
	$len=strlen($code);
	if(is_numeric($code) && $len>=16 && $len<=19){
		return 1;
	}
	else{
		return 0;
	}
}

function reg_time($time){
	if($time==''){return 0;}
    $unixTime = strtotime($time);
    if (!is_numeric($unixTime)){
		return 0;
	}
	return 1;
}

function reg_captcha($yzm,$code='captcha'){
	if($yzm==''){return 0;}
	else{$yzm=strtolower($yzm);}
    if(!defined('ADMIN')){
		dd_session_start();
	}
	$captcha=strtolower($_SESSION[$code]);
	unset($_SESSION[$code]);
	if($captcha=='' || $yzm!=$captcha){
	    return 0;
	}
	return 1;
}

function dd_encrypt($val,$key){
    return base64_encode($key.$val);
}

function dd_decrypt($val,$key){
	$a=base64_decode($val);
    $a=preg_replace('/^'.$key.'/','',$a);
	return $a;
}

function fs($class)
{
	if(!class_exists($class)){include(DDROOT.'/comm/'.$class.'.class.php');}
	static $classes = array();
	if(!isset($classes[$class]) || $classes[$class] === NULL)
	{
		$classes[$class] = new $class();
		//unset($class);
	}
	return $classes[$class];
}

function compact_html($str) {
	$str = preg_replace("/\t/", "", $str);
	$str = preg_replace("/\r\n/", "", $str);
	$str = preg_replace("/\r/", "", $str);
	$str = preg_replace("/\n/", "", $str);
	$str = preg_replace("/\s/", "", $str);
	return $str;
}

function get_final_url($url) {
	$str = '';
	$url = parse_url($url);
	$fp = fsockopen($url['host'], 80, $errno, $errstr);
	if ($fp) {
		if (!array_key_exists('query', $url)) {
			$url['query'] = '';
		}

		$header = "GET " . $url['path'] . "?" . $url['query'] . " HTTP/1.1\r\n";
		$header .= "Host: " . $url['host'] . "\r\n";
		$header .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; zh-CN; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1\r\n";
		$header .= "Referer: http://" . $url['host'] . "\r\n";
		$header .= "Connection: Close\r\n\r\n";
		fwrite($fp, $header);
		while (!feof($fp)) {
			$s = fgets($fp, 128);
			$str .= $s;
		}
		fclose($fp);
		preg_match("|Location:(.*?)Content-Type|", compact_html($str), $arr);
		return $arr[1];
	}
}

function dsetcookie($var, $value = '', $life = 0,$cookie_path='/',$cookie_domain=SURL,  $http_only = false)
{
	$_COOKIE[$var] = $value;

	if($value == '' || $life < 0)
	{
		$value = '';
		$life = -1;
	}

	$life = $life > 0 ? TIME + $life : ($life < 0 ? TIME - 31536000 : 0);
	$path = $http_only && PHP_VERSION < '5.2.0' ? $cookie_path.'; HttpOnly' : $cookie_path;

	$secure = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
	if(PHP_VERSION < '5.2.0')
	{
		setcookie($var, $value, $life, $path, $cookie_domain, $secure);
	}
	else
	{
		setcookie($var, $value, $life, $path, $cookie_domain, $secure, $http_only);
	}
}

function set_cookie($var, $value = '', $life = 1200,$encrypt=1){
	if($encrypt==1 && $life!=0){
	    $value=authcode($value, 'ENCODE');
	}
	
	if($life>0 && $value!=''){
		$life=TIME+$life;
	}
	else{
		$life=TIME-3153600000;
		$value='';
	}
	$_COOKIE[$var] = $value;
	setcookie($var, $value, $life,'/');
}

function get_cookie($var,$encrypt=1){
	if(isset($_COOKIE[$var])){
	    if($encrypt==1){
	       $value=authcode($_COOKIE[$var], 'DECODE');
	    }
        else{
	        $value=$_COOKIE[$var];
	    }
	    return $value;
	}
	else{
	    return '';
	}
}

function user_login($uid,$md5pwd,$life=''){
	if($life==''){$life=3600*24;}
	$userlogininfo=serialize(array('uid'=>$uid,'ddpassword'=>$md5pwd,'ddsavetime'=>$life));
	set_cookie("userlogininfo", $userlogininfo, $life);
}

function webtype($a,$b=''){
    if(WEBTYPE==0){
	    return $a;
	}
	else{
	    return $b;
	}
}

function extension($filename){  //求后缀名
	if(strpos($filename,'/')!==false){
		$arr= explode('/',$filename);
		$arr = array_reverse($arr);
		if(strpos($arr[0],'.')!==false){
			$row= explode('.',$arr[0]);
			$row = array_reverse($row);
			return $row[0];
		}
		else{
			return '';
		}
	}
	else{
		if(strpos($filename,'.')!==false){
			$row = array_reverse($row);
			return $row[0];
		}
		else{
			return '';
		}
	}
}

/*function get_client_ip()
{
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP']))
	{
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}
	elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches))
	{
		foreach ($matches[0] AS $xip)
		{
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip))
			{
				$ip = $xip;
				break;
			}
		}
	}
	return $ip;
}*/

function get_client_ip() {
	$ip = $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_X_REAL_FORWARDED_FOR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_REAL_FORWARDED_FOR'];
	}  
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}  
	elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} 
	return $ip;
}

function fuzzyTradeId($trade_id,$num=3){
	$len=strlen($trade_id);
    return substr($trade_id,0,$num).'*****'.substr($trade_id,-$num);
}

function deep_jm($val,$key=DDKEY){
    return md5(md5($key.$val).$key);
}

function http_pic($pic){
    if(preg_match('|^http://|',$pic)==0){
	    return SITEURL.'/'.$pic;
	}
	else{
	    return $pic;
	}
}

function del_pic($img){
	if($img==''){
		return;
	}
    if(preg_match('|^http://|',$pic)==0){
	    if(file_exists(DDROOT.'/'.$img)){
		    unlink(DDROOT.'/'.$img);
		}
	}
}

function addquote($var)
{
	return str_replace("\\\"", "\"", preg_replace("/\[([a-zA-Z0-9_\-\.\x7f-\xff]+)\]/s", "['\\1']", $var));
}

function RpLine($str)
{
	$str = str_replace("\r","\\r",$str);
	$str = str_replace("\n","\\n",$str);
	return $str;
}



/*时间转换函数*/   
/*function tranTime($time) {       
    $rtime = date("m-d H:i",$time);       
    $htime = date("H:i",$time);       
    $timetime = TIME - $time;       
 
    if ($time < 60) {           
       $str = '刚刚';       
    }       
    else if ($time < 60 * 60) {           
       $min = floor($time/60);           
       $str = $min.'分钟前';       
    }       
    else if ($time < 60 * 60 * 24) {           
       $h = floor($time/(60*60));           
       $str = $h.'小时前 '.$htime;       
    }       
    else if ($time < 60 * 60 * 24 * 3) {           
       $d = floor($time/(60*60*24));           
       if($d==1)              
       $str = '昨天 '.$rtime;           
    else              
       $str = '前天 '.$rtime;       
    }       
    else {           
       $str = $rtime;       
    }       
    return $str;   
}*/

function tranTime($time){
	$str='';
	if(!is_numeric($time)){
		$time=strtotime($time);
	}
	
	$current_time = time();
	if ($time >= $current_time) {
        $time = $time - $current_time;
		if ($time < 60) {
			$str = '马上';
		}
		elseif ($time < 60 * 60) {
			$min = floor($time / 60);
			$str = $min . '分钟后';
		}
		elseif ($time < 60 * 60 * 24) {
			$h = floor($time / (60 * 60));
			$str = $h . '小时后';
		}
		elseif ($time < 60 * 60 * 24 * 30) {
			$d = floor($time / (60 * 60 * 24));
			$str='还有'.$d.'天';
		}
		elseif ($time < 60 * 60 * 24 * 30*12) {
			$d = floor($time / (60 * 60 * 24*30));
			$str='还有'.$d.'个月';
		}
		else{
			$d = floor($time / (60 * 60 * 24*30*12));
			$str='还有'.$d.'年';
		}
	}
	else{
	    $str='已过期'; 
	}
	return $str;
}

function browser() {
	if(!isset($_SERVER["HTTP_USER_AGENT"])){
		return '';
	}
	if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE")){
		$browser = "ie";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Firefox")){
		$browser = "firefox";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Chrome")){
		$browser = "chrome";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Safari")){
		$browser = "safari";
	}
	elseif (strpos($_SERVER["HTTP_USER_AGENT"], "Opera")){
		$browser = "opera";
	}
	else{
		$browser='';
	}
	return $browser;
}

/*多多函数*/

function alert($word){
    echo script('alert("'.$word.'")');
}

function fenduan($val,$arr=array(),$level=0,$bili=1){
	$re=0;
    foreach($arr as $k=>$v){
        if($level>=$k){
			$re=$val*$v;
			break;
		}
    }
	
	if($re==0){
		$re=$val*$v;
	}
	$re*=$bili;
	return round($re,2);
}

function rep($str){
    $re="/[^\d]/";
    return preg_replace($re,"",$str);
}

function StrCode($string,$key,$action='ENCODE'){
	$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$key),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($string); $i++)
	{
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}

//签名函数
	function createSign ($paramArr) { 
	    global $appSecret; 
	    $sign = $appSecret; 
	    ksort($paramArr); 
	    foreach ($paramArr as $key => $val) { 
	       if ($key !='' && $val !='') { 
	           $sign .= $key.$val; 
	       } 
	    } 
	    $sign = strtoupper(md5($sign.$appSecret));
	    return $sign; 
	}

	//组参函数 
	function createStrParam ($paramArr) { 
	    $strParam = ''; 
	    foreach ($paramArr as $key => $val) { 
	       if ($key != '' && $val !='') { 
	           $strParam .= $key.'='.urlencode($val).'&'; 
	       } 
	    } 
	    return $strParam; 
	}



function param2str($parame) {
	$parame_str = '';
	if (!empty ($parame)) {
		foreach ($parame as $k => $v) {
			if ($k != '') {
				$parame_str .= $k . '=' . urlencode($v) . '&';
			}
		}
		$parame_str = preg_replace('/&$/', '', $parame_str);
	}
	return $parame_str;
}

function filename(){ 
	$dir_file = $_SERVER['SCRIPT_NAME']; 
	$filename = basename($dir_file); 
	return $filename; 
} 

function dd_strip_tags($html,$tags=''){
    $default_tags='<a>,<b>,<br>,<div>,<p>,<table>,<tr>,<td>,<th>,<i>,<font>,<dl>,<dt>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<hr>,<ul>,<li>,<ol>';
	if($tags!=''){$default_tags=','.$default_tags;}
	return $html=strip_tags($html,$default_tags);
}

/**
 * 字符串截取，支持中文和其他编码
 *
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断字符串后缀
 * @return string
 */
function substr_ext($str, $start=0, $length, $charset="utf-8", $suffix="")
{
    if(function_exists("mb_substr")){
         return mb_substr($str, $start, $length, $charset).$suffix;
	}
    elseif(function_exists('iconv_substr')){
         return iconv_substr($str,$start,$length,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}

function dd_replace($str,$arr=array()){
	if(REPLACE==0){
		return $str;
	}
	
	if(REPLACE<3){
		$noword_tag='';
	}
	else{
		$noword_tag='3';
	}
	
	if(empty($arr)){
		$arr=dd_get_cache('no_words'.$noword_tag);
	}
	
	if(REPLACE==1 && !empty($arr)){
	    $str=strtr($str,$arr);
		//print_r($str);exit;
	}
	elseif(REPLACE==2){
	    foreach($arr as $a=>$b){
		    if(strpos($str,(string)$a)!==false){
				if(MOD=='ajax'){
					$re=array('s'=>0,'id'=>55);
					dd_exit(json_encode($re));
				}
				else{
					error_html('商品不存在！',-1);
				}
			}
		}
	}
	elseif(REPLACE==3){
		foreach($arr as $k=>$row){
		    $title_split=implode('(.*)',$row['title_arr']);
			$replace=$row['replace'];
			if(preg_match('/'.$title_split.'/',$str)==1){
				if(MOD=='ajax'){
					$re=array('s'=>0,'id'=>55);
					dd_exit(json_encode($re));
				}
				else{
					error_html('商品不存在！',-1);
				}
			}
		}
	}
	return $str;
}

function dd_exit($str=''){
    global $duoduo;
	if(isset($duoduo)){$duoduo->close();}
	echo $str;
	unset($duoduo);
	exit;
}

function ob_gzip($content)
{    
    if(!headers_sent() &&  extension_loaded("zlib") && strpos($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip")!==false)
    {
        $content = gzencode($content,9);
        header("Content-Encoding: gzip");
        header("Vary: Accept-Encoding");
        header("Content-Length: ".strlen($content));
    }
    return $content;
}

function strtoarray($str){
	$str=str_replace('，',',',$str);
	$str=preg_replace('/[\n\r\t\s]+/i',',',$str);
	$arr=explode(',',$str);
	return $arr;
}

function limit_ip($name,$ip=''){
	if($ip=='')	{
		$ip=get_client_ip();
	}
	$limit_ip=dd_get_cache($name);
	if($limit_ip[0]=='') return 0;
	$ips=implode('|',$limit_ip);
	if(preg_match('/'.$ips.'/',$ip)==1){
		return 1;
	}
	return 0;
}

function dd_tag_replace($str){
	global $webset;
	$arr=array('{WEBNICK}'=>WEBNICK,'{WEBNAME}'=>WEBNAME,'{QQ}'=>$webset['qq'],'{EMAIL}'=>$webset['email'],'{URL}'=>URL,'{TBMONEY}'=>TBMONEY,'{TBMONEYBL}'=>TBMONEYBL,'{TBMONEYTYPE}'=>TBMONEYTYPE);
	$str=strtr($str,$arr);
	return $str;
}

function no_cache(){
	//设置此页面的过期时间(用格林威治时间表示)，只要是已经过去的日期即可。    
	header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");      
   
	//设置此页面的最后更新日期(用格林威治时间表示)为当天，可以强制浏览器获取最新资料     
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");      
   
	//告诉客户端浏览器不使用缓存，HTTP 1.1 协议     
	header("Cache-Control: no-cache, must-revalidate");      
   
	//告诉客户端浏览器不使用缓存，兼容HTTP 1.0 协议     
	header("Pragma: no-cache");
}

/*function gbk2utf8($q) {
	echo $encode=mb_detect_encoding($q,array('ASCII','GB2312','GBK','UTF-8','BIG5'));
	if($encode!='UTF-8' && $encode!='CP936'){
		$q=iconv($encode,'utf-8',$q);
	}
	return $q;
}*/

function gbk2utf8($string, $encoding = 'utf8') {
	if(GBK_UTF8_FUN==2){
		/*$encode=mb_detect_encoding($q,array('ASCII','GB2312','GBK','UTF-8','BIG5'));
		if($encode!='UTF-8' && $encode!='CP936'){
			$q=iconv($encode,'utf-8',$q);
		}
		return $q;*/
		if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$string) == true){
			return $string;
		}
		else{
			return iconv('gb2312','utf-8',$string);
		}
	}
	else{
		$is_utf8 = preg_match('%^(?:[\x09\x0A\x0D\x20-\x7E]| [\xC2-\xDF][\x80-\xBF]|  \xE0[\xA0-\xBF][\x80-\xBF] | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}    |  \xED[\x80-\x9F][\x80-\xBF] |  \xF0[\x90-\xBF][\x80-\xBF]{2}  | [\xF1-\xF3][\x80-\xBF]{3}  |  \xF4[\x80-\x8F][\x80-\xBF]{2} )*$%xs', $string);
		if ($is_utf8 && $encoding == 'utf8') {
			return $string;
		}
		elseif ($is_utf8) {
			return mb_convert_encoding($string, $encoding, "UTF-8");
		} else {
			return mb_convert_encoding($string, $encoding, 'gbk,gb2312,big5');
		}
	}
}

function dd_glob($dir){
	if(!preg_match('/.*\/$/',$dir)){
		$dir.='/';
	}
	$a=array();
	$b=array();
	$a=glob($dir.'*');
	$b=glob($dir.'.*');
	foreach($b as $k=>$v){
		if($v==$dir.'.' || $v==$dir.'..'){
			unset($b[$k]);
		}
	}
	if(empty($a)){
		return $b;
	}
	elseif(empty($b)){
		return $a;
	}
	else{
		return array_merge($a,$b);
	}
}

function get2var(){
	foreach($_GET as $k=>$v){
		global $$k;
		$$k=$v;
	}
}

function post2var($arr=array(),$strict=0){
	$re=1;
	foreach($_POST as $k=>$v){
		if($v==='' && $strict==1){ //严格检测post，不准有空
			$re=0;
			break;
		}
		global $$k;
		$$k=htmlspecialchars($v);
		if(!empty($arr)){
			$arr=array_diff($arr,array($k));
		}

	}
	if(!empty($arr)){  //严格检测post，不准不存在
		if(count($arr)>0){
		    $re=0;
	    }
	}
	return $re;
}

function dd_file_put($file,$data,$mode=FILE_USE_INCLUDE_PATH){
	//if($mode!=FILE_APPEND && is_file($file)) unlink($file);
	return file_put_contents($file,$data,$mode);
}

function data_type($v,$type=1){
	if($type==1){
		return (int)$v;
	}
	elseif($type==2){
		return (floor($v*100))/100;
	}
}

function zhengchu($a,$b){
	if($a/$b!=(int)($a/$b)){
		return 0;
	}
	else{
		return 1;
	}
}

function del_magic_quotes_gpc($content){
	if(get_magic_quotes_gpc()==1){
		if(strpos($content,'\\"')!==false){
			$content=str_replace('\\"','"',$content);
		}
		if(strpos($content,"\\'")!==false){
			$content=str_replace("\\'","'",$content);
		}
	}
	return $content;
}

function dd_hash_hmac( $algo , $data , $key , $raw_output = false ){
	if(function_exists('hash_hmac')){
		return hash_hmac($algo, $data, $key, $raw_output);
	}

	$algo = strtolower($algo);
	if($algo == 'sha1'){
		$pack = 'H40';
	}
	elseif($algo == 'md5')
	{
		$pack = 'H32';
	}
	else
	{
		return '';
	}
	$size = 64;
	$opad = str_repeat(chr(0x5C), $size);
	$ipad = str_repeat(chr(0x36), $size);
	if (strlen($key) > $size) {
		$key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
	} else {
		$key = str_pad($key, $size, chr(0x00));
	}
	for ($i = 0; $i < strlen($key) - 1; $i++) {
		$opad[$i] = $opad[$i] ^ $key[$i];
		$ipad[$i] = $ipad[$i] ^ $key[$i];
	}
	$output = $algo($opad.pack($pack, $algo($ipad.$data)));
	return ($raw_output) ? pack($pack, $output) : $output;
}
function manage_select_shop_convert($seller_nicks){
	include (DDROOT . '/comm/Taoapi.php');
	include (DDROOT . '/comm/ddTaoapi.class.php');
	$ddTaoapi = new ddTaoapi;
	$shop=$ddTaoapi->taobao_shop_get($seller_nicks);
	$list=2;
	if($shop==104){
	}
	else{
		$jssdk_shops_convert['method']='taobao.taobaoke.widget.shops.convert';
		$jssdk_shops_convert['outer_code']=(int)$dduser['id'];
		$jssdk_shops_convert['user_level']=(int)$dduser['level'];
		$jssdk_shops_convert['seller_nicks']=$seller_nicks;
		$jssdk_shops_convert['list']=(int)$list;
		foreach($shop as $k=>$v){
			$jssdk_shops_convert[$k]=$v;
		}
	}
	return $jssdk_shops_convert;
}
?>
<?php //多多
class rewrite {
	public $n = 0;
	public $cur_path='';
	
	function __construct(){
		$cur_path=str_replace('data/rewrite/php/'.filename(),'',$_SERVER['PHP_SELF']);
		$cur_path=preg_replace('#^/#','',$cur_path);
		$this->cur_path=$cur_path;
	}
	
	function replace($a,$fuhao){
		return preg_replace('/\\'.$fuhao.'([a-zA-Z0-9])/','\\'.$fuhao.'\1',$a);
	}

	function guize($a, $b, $type) {
		$a = $this->cur_path . $a;
		$b = $this->cur_path . $b;
		switch ($type) {
			case 'htaccess' :
				$a = 'RewriteRule ' . $this->replace($a,'.') . '$';
				$b = '/' . $this->replace($b,'?');
				$str = $a . ' ' . $b;
				break;

			case 'httpd' :
				$a = 'RewriteRule ^/' . $a . '$';
				$a = $this->replace($a,'.');
				$b = $this->replace($b,'?');
				$b = '/' . $this->replace($b,'.');
				$str = $a . ' ' . $b;
				break;

			case 'lighttpd';
				$a = '"/' . $a . '$"';
				$b = '"' . $b . '",';
				$str = $a . ' => ' . $b;
				break;

			case 'nginx';
				$a = 'rewrite /' . $a . '$';
				$b = '/' . $b . ' last;';
				$str = $a . ' ' . $b;
				break;

			case 'web_config';
				$this->n++;
				$str = '<rule name="Imported Rule ' . $this->n . '">' . "\r\n";
				$str .= '<match url="^' . $a . '$" ignoreCase="false" />' . "\r\n";
				$b = str_replace('&', '&amp;', $b);
				$b = preg_replace('#\$(\d)#', '{R:\1}', $b);
				$str .= '<action type="Rewrite" url="' . $b . '" />' . "\r\n";
				$str .= "</rule>\r\n";
				break;
		}
		return $str . "\r\n";
	}

	function run($guize) {
		$str='';

		$plugin_rewrite_arr=dd_glob(DDROOT.'/plugin/rewrite/');
		foreach($plugin_rewrite_arr as $v){
			$b=include($v);
			$str= $str.$this->loop($b,$guize);
		}
		
		$a=include(DDROOT.'/data/rewrite.php');
		$str= $str.$this->loop($a,$guize);
		
		return $str;
	}
	
	function loop($a,$guize){
		$str = '';
		$alias=dd_get_cache('alias');
		foreach ($a as $dmod => $row) {
			foreach ($row as $dact => $arr) {
				foreach ($arr as $shuzu) {
					if(isset($alias[$dmod.'/'.$dact][0])){
						$dmod_zdy=$alias[$dmod.'/'.$dact][0];
					}
					else{
						$dmod_zdy=$dmod;
					}
					if(isset($alias[$dmod.'/'.$dact][1])){
						$dact_zdy=$alias[$dmod.'/'.$dact][1];
					}
					else{
						$dact_zdy=$dact;
					}

					if ($dmod=='qita' && $dact=='qita') {
						$str .= $this->guize($shuzu['a'], $shuzu['b'], $guize);
					} else {
						if ($shuzu['b'] != '') {
							$shuzu['b'] = '&' . $shuzu['b'];
						}
						$str .= $this->guize($dmod_zdy . '/' . $dact_zdy . $shuzu['a'], 'index.php?mod=' . $dmod . '&act=' . $dact . $shuzu['b'], $guize);
						if ($dmod !== 'index' && $dact == 'index' && $shuzu['a']=='.html' && $shuzu['b']=='') {
							$str .= $this->guize($dmod . '/', 'index.php?mod=' . $dmod . '&act=' . $dact . $shuzu['b'], $guize);
							$str .= $this->guize($dmod, 'index.php?mod=' . $dmod . '&act=' . $dact . $shuzu['b'], $guize);
						}
					}
				}
			}
		}
		return $str;
	}
}
?>
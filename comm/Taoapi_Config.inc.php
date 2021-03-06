<?php
//多多淘宝客 www.duoduo123.com 优化 12年03月20日
/*
警告: 修改该文件必须保存为无ROM头的文件,也就是去掉文件头签名
如果使用记事本改的话可能会出现获取数据乱码的问题
*/

//设置获取数据的编码. 支持UTF-8 GBK GB2312 
//需要 iconv或mb_convert_encoding 函数支持
//UTF-8 不可写成UTF8
$apiConfig['Charset'] = 'UTF-8';

//设置数据环境
//true 测试环境 false 正式环境
$apiConfig['TestMode'] = false;

//您的appKey和appSecret 支持多个appKey

global $webset;

$key_arr=$webset['appkey'];
$k_nums=0;
foreach($key_arr as $key=>$row){
	if($row['num']>0){
		$proArr[]=$row['num'];
		$k_nums++;
	}
}
function pro_rand($proArr) {
	$result = '';
	//概率数组的总概率精度
	$proSum = array_sum($proArr);

	foreach ($proArr as $key => $proCur) {
		$randNum = mt_rand(1, $proSum);
		if ($randNum <= $proCur) {
			$result = $key;
			break;
		} else {
			$proSum -= $proCur;
		}
	}

	return $result;
}

for ($k = 0; $k < $k_nums; $k++) {
	$result = pro_rand($proArr);
	$apiConfig['AppKey'][$key_arr[$result]['key']] = $key_arr[$result]['secret'];
	unset($proArr[$result]);
}

$error_word='appkey不能为空';
if(MOD=='tao' && ACT=='report'){ //获取订单，只是用一个key，并赋值session
	if($webset['taobao_session']['value']==''){
		PutInfo('淘宝授权session不能为空！');
	}
	
	unset($apiConfig['AppKey']);
    $apiConfig['taobao_session'] = $webset['taobao_session']['value'];
	$apiConfig['AppKey'][$webset['taoapi']['jssdk_key']] = $webset['taoapi']['jssdk_secret'];
	$error_word='appkey列表不能为空！';
}

if(empty($apiConfig['AppKey'])){
	PutInfo($error_word);
}

//当appKey不只一个时,API次数超限后自动启用下一个APPKEY
//false:关闭 true:开启
$apiConfig['AppKeyAuto'] = true;

//设置API版本,1 表示1.0 2表示2.0
$apiConfig['Version'] = 2;

//设置sign加密方式,支持 md5 和 hmac 
//版本2.0时才可以使用 hmac
$apiConfig['SignMode'] = 'md5';

//显示或关闭错语提示,
//true:关闭 false:开启
$apiConfig['CloseError'] = true;

//开启或关闭API调用日志功能,开启后可以查看到每天APPKEY调用的次数以及调用的API
//false:关闭 true:开启
$apiConfig['ApiLog'] = false;

//开启或关闭错误日志功能
//false:关闭 true:开启

$apiConfig['Errorlog'] = (int)$webset['taoapi']['errorlog'];

//设置API读取失败时重试的次数,可以提高API的稳定性,默认为3次
$apiConfig['RestNumberic'] = 0;

//设置数据缓存的时间,单位:小时;0表示不缓存

$apiConfig['Cache'] =$webset['taoapi']['cache_time'];

//设置缓存保存的目录
$apiConfig['CachePath'] = DDROOT.'/data/temp/taoapi';

//积分比例
$apiConfig['fxbl'] =$webset['fxbl'];

//淘宝账号
$apiConfig['taobao_nick'] =$webset['taobao_nick'];

//淘宝pid
$apiConfig['taobao_pid'] =$webset['taobao_pid'];

//搜索框完整pid
$apiConfig['taobao_search_pid'] =$webset['taoapi']['taobao_search_pid'];

//天猫全站返利1.5%  个别类别（黄金，家电等0.5%）
$apiConfig['tmall_commission_rate'] =$webset['taoapi']['tmall_commission_rate']>=0?$webset['taoapi']['tmall_commission_rate']:0.005;

//聚划算全站返利2% 平均值
$apiConfig['ju_commission_rate'] =$webset['taoapi']['ju_commission_rate']>=0?$webset['taoapi']['ju_commission_rate']:0.01;

//是否获取商品实时价格
$apiConfig['promotion'] =$webset['taoapi']['promotion'];

//jssdk_key
$apiConfig['jssdk_key'] =$webset['taoapi']['jssdk_key'];

//是否获取商品实时价格
$apiConfig['jssdk_secret'] =$webset['taoapi']['jssdk_secret'];

//自动清除过期缓存的时间间隔，
//格式是：* * * *
//其中第一个数表示分钟，第二个数表示小时，第三个数表示日期，第四个数表示月份
//多个之间可以用半角分号隔开
//示例：
//要求每天早上的8点1分清除缓存，格式是：1 8 * *
//要求每个月的1号晚上12点5分清除缓存，格式是：5 12 1 *
//要求每隔5天就在上午10点3分清除缓存，格式是：3 10 1,5,10,15,20,25 *
//如果设为0或格式不对将不开启此功能
//缓存清除操作每天只会执行一次
$apiConfig['ClearCache'] = "1,4,7,10,14 * * *"; //默认为每小时的 1 3 7 10 14 进行自动缓存清除

//每次调用API后自动清除原有传入参数
//false:关闭 true:开启
$apiConfig['AutoRestParam'] = true;
unset($webset);
return $apiConfig;
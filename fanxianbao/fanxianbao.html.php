<?php
include('../comm/dd.config.php');
ob_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>多多返现宝</title>
</head>
<body>
<script language="javascript">
var win=external.menuArguments;
if (typeof(win)!="undefined") {
	if (win.document.body.readyState == "complete") {
		if (win.document.URL.indexOf("taobao.com")>=0 || win.document.URL.indexOf("tmall.com")>=0 || win.document.URL.indexOf("hitao.com")>=0) {
			var fanuser = '';
			var url = window.location.href.split("?");
		 	if (url.length==2) fanuser = url[1];
			if (fanuser=='') {
				var url = window.location.href.split("#");
				if (url.length==2) fanuser = url[1];
			}
		 	win.document.charset="UTF-8";
		 	var js=win.document.createElement('script');
		 	js.type='text/javascript';
		 	js.src='http://<?=URL?>/fanxianbao/fanxianbao.js';
		 	js.setAttribute("charset","UTF-8");
		 	js.id = 'fanxianbao';
		 	js.value = fanuser;
		 	win.document.getElementsByTagName('html')[0].insertBefore(js, win.document.getElementsByTagName('html')[0].firstChild);
		} else {
			alert('此站不支持右键返现');
		}
    } else window.status='未完成';
} else window.status='请点右键先';
</script>
</body>
</html>
<?php
$c=ob_get_contents();
dd_file_put('fanxianbao.html',$c);
ob_clean();
?>
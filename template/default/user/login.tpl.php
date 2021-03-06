<?php
$css[]=TPLURL."/css/usercss.css";
include(TPLPATH."/header.tpl.php");
?>
<script charset="utf-8" type="text/javascript" src="js/jquery.validate.js" ></script>
<script>
$(function(){
	$('#username').focus(function(){
	    $(this).next('div').show();
	});

    $('#login_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules : {
            username : {
                required : true,
                byteRange: [3,30,'utf-8']
            },
            password : {
                required : true,
                minlength: 6
            }
        },
        messages : {
            username : {
                required : '账号必填',
                byteRange: '账号长度错误'
            },
            password  : {
                required : '密码必填',
                minlength: '密码长度错误'
            }
        }/*,
		submitHandler: function(form) {   
			ajaxPostForm(form,'<?=u('user','index',array('start'=>1))?>');
        } */
    });
});
</script>
<div class="mainbody">
<div class="mainbody1000">
<?=AD(15)?>
	<div class="register">
    <div class="register_left">
     <p class="title">会员登陆</p>
     <form id="login_form" name="login_form" method="post" action="<?=u('user','login')?>">
     <table width="600" border="0" align="left" cellpadding="0" cellspacing="0" hight="100" name="zhuce" >
		<tr>
		  <td width="15%" height="55" align="right">&nbsp;&nbsp;用户名 *&nbsp;&nbsp;</td>
		  <td><div style="position:relative"><input name="username" type="text" id="username" class="ddinput" /><div class="denglu_xuanfu">请输入您的用户名或Email地址</div></div></td>
		  <td width="40%" id="ckusername"><label class="field_notice">请输入账号</label></td>
		</tr>
		<tr>
		  <td height="55" align="right" >密码 *&nbsp;&nbsp;</td>
		  <td><input name="password" type="password" id="password"  class="ddinput"></td>
		  <td id="ckpass"><label class="field_notice">请输入密码</label></td>
		</tr>
		
		<tr>
		  <td height="55" align="right" >&nbsp;</td>
		  <td colspan="2"><label><input name="remember" id="remember" type="checkbox" checked="checked" value="1" />记住我，两周免登陆</label></td>
	    </tr>
		<tr>
		  <td height="55" align="right" >&nbsp;</td>
		  <td><input type="hidden" name="from" value="<?=$url_from?>" /><input type="submit" name="sub" value="登 陆"  class="register_b"> <a class="login_pwfont" href="<?=u('user','getpassword')?>">忘记密码</a> </td>
		  <td height="55"></td>
		</tr>
	  </table>
      </form>
     
      </div>
      <div class="register_right">
        <div class="register_right_1">
          <p>还没有账号？轻松注册 ！ </p>
          <div style="margin:auto;width:80px"><a href="<?=u('user','register')?>" class="register_b2" style="display:block; line-height:29px; color:#FFF; margin-top:10px">注 册</a></div>
        </div>
        <?php if($app_show==1){?>
              <div class="register_right_2">
              <p>您也可以用以下合作网站账号登录</p>
              <ul>
              <?php foreach($apps as $row){?>
                <li><a class="<?=$row['code']?>" href="<?=u('api',$row['code'],array('do'=>'go'))?>"><img src="<?=TPLURL.'/images/login/'.$row['code'].'_1.gif'?>" alt="<?=$row['title']?>" /> <?=$row['title']?></a></li>
              <?php }?>              
              </ul>
          </div>
          <?php }?>
      </div>

    </div>
</div>
</div>		  
<?php
include(TPLPATH."/footer.tpl.php");
?>
<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>我的</title>
<link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
<link href="/ll/themes/lailong/Public/simpleboot/themes/simplebootx/theme.min.css">
<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
<!--<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/dd.css">-->
<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/my.css">
<!--<link rel="stylesheet" href="assets/css/app.css">-->

</head>

<style>
.am-with-fixed-navbar{
	padding-bottom:0;
}
body{
padding-top:0;
}
@media (max-width: 767px){
	body {
    padding-right: 0;
    padding-left: 0;
}
}

.am-accordion-gapped .am-active .am-accordion-title:after{
	transform：rotate(270deg)；
}
.am-list>li{
border:1px solid #f4f5f7;
}
#divimg{width: 50px;height: 50px;float: left;}
</style>
<body  >
<!--我的-->
<div style="padding:4px;">
<section data-am-widget="accordion" class="am-accordion am-accordion-gapped" data-am-accordion='{  }'>
<?php if(is_array($child)): foreach($child as $k=>$c): if(($k) == "0"): ?><dl class="am-accordion-item am-active" style="border-bottom: none;">
			<dt class="am-accordion-title" style="background: white;border-bottom-color:#f4f5f7; height: 60px;">
				<a href="<?php echo U('mine/user_info?child'); echo ($c["id"]); ?>"><div id="divimg" style="background:<?php if(!empty($c[avatar])): ?>url('data/upload/avatar/<?php echo ($c["avatar"]); ?>')no-repeat center;background-size:cover;margin-right: 10px;<?php else: ?>url('/ll/themes/lailong/Public/images/moren.png')no-repeat center;background-size:cover;margin-right: 10px;<?php endif; ?>"><icon></icon></div></a><div style="height:50px;font-size: 1.6rem;color: black;line-height:50px;"><?php if($c['nickname'] == ''){ echo ($c["name"]); }else{echo $c['nickname'];} ?></div>
			</dt>
			<dd class="am-accordion-bd am-collapse am-in">
				<!-- 规避 Collapase 处理有 padding 的折叠内容计算计算有误问题， 加一个容器 -->
				<div class="am-accordion-content">
					<ul class="am-list" style="margin-top: 0px;">
						<li class="am-list-item-dated" style="border-top: none;line-height:30px;">
							<a href="<?php echo U('Mine/member?child='); echo ($c["id"]); ?>" class="am-list-item-hd ">
								<img src="/ll/themes/lailong/Public/images/user.png" alt="">
								<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">会员信息</span>
								<span style="position:absolute;top: 8px;right:26px;color: #92998b;"><?php if($c[vip_state] == 0): ?>未认证<?php elseif($c[vip_state] == 1): ?>认证中<?php elseif($c[vip_state] == 2): ?>认证失败<?php elseif($c[vip_state] == 3): ?>已认证<?php endif; ?></span>
								<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
									  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</a>
						</li>
						<li class="am-g am-list-item-dated" style="line-height:30px">
							<a href="<?php echo U('Mine/order_list?id='); echo ($c["id"]); ?>"  class="am-list-item-hd ">
								<img src="/ll/themes/lailong/Public/images/course.png" alt="">
								<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">购买的课程</span>
								<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
									  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</a>

						</li>
						<li class="am-g am-list-item-dated" style="border-bottom: none;line-height:30px">
							<a href="<?php echo U('Mine/my_intention?child='); echo ($c["id"]); ?>" class="am-list-item-hd ">
								<img src="/ll/themes/lailong/Public/images/ides.png" alt="">
								<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">课程意向</span>
								<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
									  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</a>

						</li>
					</ul>
				</div>
			</dd>
		</dl>
	<?php else: ?>
		<dl class="am-accordion-item" style="border-bottom: none">
			<dt class="am-accordion-title" style="background: white;border:none;">
				<a href="<?php echo U('mine/user_info?child'); echo ($c["id"]); ?>"><img style="background:url('<?php if(!empty($c[avatar])): ?>/ll/data/upload/avatar/<?php echo ($c["avatar"]); else: ?>/ll/themes/lailong/Public/images/moren.png<?php endif; ?>')no-repeat center;background-size:cover;" alt=""></a><span style="font-size: 1.6rem;color: black"><?php if(!empty($c[nickname])): echo ($c["nickname"]); else: echo ($c["name"]); endif; ?></span>
			</dt>
			<dd class="am-accordion-bd am-collapse">
				<!-- 规避 Collapase 处理有 padding 的折叠内容计算计算有误问题， 加一个容器 -->
				<div class="am-accordion-content">
					<ul class="am-list">
						<li class="am-list-item-dated" style="border-top: none;line-height:30px">
							<a href="<?php echo U('Mine/member?child='); echo ($c["id"]); ?>" class="am-list-item-hd ">
								<img src="/ll/themes/lailong/Public/images/user.png" alt="">
								<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">会员信息</span>
								<span style="position:absolute;top: 8px;right:26px;color: #92998b;"><?php if($c[vip_state] == 0): ?>未认证<?php elseif($c[vip_state] == 1): ?>认证中<?php elseif($c[vip_state] == 2): ?>认证失败<?php elseif($c[vip_state] == 3): ?>已认证<?php endif; ?></span>
								<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
									  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</a>
						</li>
						<li class="am-g am-list-item-dated" style="line-height:30px">
							<a href="<?php echo U('Mine/order_list?id='); echo ($c["id"]); ?>"  class="am-list-item-hd ">
								<img src="/ll/themes/lailong/Public/images/course.png" alt="">
								<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">购买的课程</span>
								<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
									  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</a>

						</li>
						<li class="am-g am-list-item-dated" style="border-bottom: none;">
							<a href="<?php echo U('Mine/my_intention?child='); echo ($c["id"]); ?>" class="am-list-item-hd " style="line-height:30px">
								<img src="/ll/themes/lailong/Public/images/ides.png" alt="">
								<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">课程意向</span>
								<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
									  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</a>

						</li>
					</ul>
				</div>
			</dd>
		</dl><?php endif; endforeach; endif; ?>
	<dl class="am-accordion-item" style="background: white;border:none;">
		<ul class="am-list">
			<li class="am-g am-list-item-dated" style="position: relative;border-top: none">
				<a  href="<?php echo U('Mine/member');?>" class="am-list-item-hd " style="background: white">
					<img src="/ll/themes/lailong/Public/images/add.png" alt="" style=" width: 50px;height: 50px;margin-right: 10px;">
					<span style="font-size: 1.6rem;color: #000;line-height: 20px;position:absolute;top:20px; left: 64px;">添加小孩</span>
					<span style="position: absolute;top: 21px;right:9px;font-size: 20px;color: #92998b;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
				</a>
			</li>
		</ul>
	</dl>
</section>
<section style="margin-top: 30px;" data-am-widget="accordion" class="am-accordion am-accordion-gapped" data-am-accordion='{  }'>
<div class="am-accordion-content">
	<ul class="am-list">

		<li class="am-g am-list-item-dated" style="border-top: none;line-height:30px">
			 <a href="<?php echo U('Mine/integration');?>" class="am-list-item-hd "> 
				<img src="/ll/themes/lailong/Public/images/jifen.png" alt="">
				<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left:35px;">我的积分</span>
				<span id="userscore" style="position:absolute;top: 8px;left:117px;color: #92998b;"><?php echo ($u["integral"]); ?></span>
				<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
					  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
			 </a> 
			<span style="border: 1px solid #45e1b3;width: 65px;height: 22px;line-height: 21px;text-align: center; position:absolute;top: 11px;right: 26px;color: #45e1b3;" id="sign"> <?php if($bool == 0): ?>签到<?php else: ?>已签到<?php endif; ?></span>
		</li>
		<li class="am-g am-list-item-dated;" style="line-height:30px">
			<a href="<?php echo U('Mine/collection');?>" class="am-list-item-hd ">
				<img src="/ll/themes/lailong/Public/images/sc.png" alt="">
				<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">我的收藏</span>
				<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
					  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
			</a>
		</li>
		<li class="am-g am-list-item-dated;"style="line-height:30px">
			<a href="<?php echo U('Mine/my_message');?>" class="am-list-item-hd ">
				<img src="/ll/themes/lailong/Public/images/passege.png" alt="">
				<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">我的消息</span>
				<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
					  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
			</a>
		</li>
		<li class="am-g am-list-item-dated "style="line-height:30px">
			<a href="<?php echo U('Rulepage/recommend?userid='); echo ($_SESSION[weixin_user_id]); ?>" class="am-list-item-hd ">
				<img src="/ll/themes/lailong/Public/images/tuijian.png" alt="">
				<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">我的推荐</span>
				<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
					  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
			</a>
		</li>
		<li class="am-g am-list-item-dated;"style="line-height:30px">
			<a href="<?php echo U('Mine/feedback');?>" class="am-list-item-hd ">
				<img src="/ll/themes/lailong/Public/images/fankui.png" alt="">
				<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">意见反馈</span>
				<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
					  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
			</a>
		</li>
		<li class="am-g am-list-item-dated" style="border-bottom: none;margin-bottom: 54px;line-height:30px">
			<a href="<?php echo U('Mine/setting');?>" class="am-list-item-hd ">
				<img src="/ll/themes/lailong/Public/images/shezhi.png" alt="">
				<span style="font-size: 1.6rem;color: #000;line-height: 17px;position:absolute;top:13px; left: 35px;">设置</span>
				<span style="position: absolute;top: 12px;right:8px;font-size: 20px;color: #92998b;"
					  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
			</a>
		</li>
	</ul>
</div>
</section>
</div>
<!--<footer>
<div data-am-widget="navbar"class="am-navbar am-cf am-navbar-default " id="">
			<ul class="am-navbar-nav am-cf am-avg-sm-4"
				style="background: #fbfbfb;">
				<li><a href="<?php echo U('Course/course');?>"> <img class="show"
						src="/ll/themes/lailong/Public/images/course1.png" alt="课程" /> <img
						style="display: none" class="hide"
						src="/ll/themes/lailong/Public/images/coursed.png" alt="课程" /> <span
						class="am-navbar-label" style="color: #bfc6d1;">课程</span>
				</a></li>
				<li><a href="<?php echo U('Mine/server');?>"> <img class="show1"
						src="/ll/themes/lailong/Public/images/server.png" alt="管家服务" /> <img
						style="display: none" class="hide1"
						src="/ll/themes/lailong/Public/images/servered.png" alt="管家服务" /> <span
						class="am-navbar-label txt1" style="color: #bfc6d1;">管家服务</span>
				</a></li>
				<li><a href="<?php echo U('Mine/my');?>"> <img class="show2"
						src="/ll/themes/lailong/Public/images/my.png" alt="我的" /> <img
						style="display: none" class="hide2"
						src="/ll/themes/lailong/Public/images/myd.png" alt="我的" /> <span
						class="am-navbar-label txt2" style="color: #bfc6d1;">我的</span>
				</a></li>
			</ul>
</div>
</footer>-->
	<br>
<br>
<br>
<!-- Footer ================================================== -->
<hr>
<?php echo hook('footer');?>
<div id="footer">
<!--预加载 -->
  <div class="myloading am-text-center" style="line-height:34px; width:100px;height:70px;background-color:rgba(0,0,0,0.3); position:fixed;top:35%;left:35%;z-index:9999; display:none;">
              <span style="font-size:20px;" class="am-icon-spinner am-icon-pulse"></span></br>
                加载中...
  </div>
<div data-am-widget="navbar"class="am-navbar am-cf am-navbar-default " id="">
			<ul class="am-navbar-nav am-cf am-avg-sm-4"
				style="background: #fbfbfb;">
				<li><a href="<?php echo U('Course/course');?>"> <img class="show"
						src="/ll/themes/lailong/Public/images/course1.png" alt="课程" /> <img
						style="display: none" class="hide"
						src="/ll/themes/lailong/Public/images/coursed.png" alt="课程" /> <span
						class="am-navbar-label" style="color: #bfc6d1;">课程</span>
				</a></li>
				<li><a href="<?php echo U('Mine/server');?>"> <img class="show1"
						src="/ll/themes/lailong/Public/images/server.png" alt="管家服务" /> <img
						style="display: none" class="hide1"
						src="/ll/themes/lailong/Public/images/servered.png" alt="管家服务" /> <span
						class="am-navbar-label txt1" style="color: #bfc6d1;">管家服务</span>
				</a></li>
				<li><a href="<?php echo U('Mine/my');?>"> <img class="show2"
						src="/ll/themes/lailong/Public/images/my.png" alt="我的" /> <img
						style="display: none" class="hide2"
						src="/ll/themes/lailong/Public/images/myd.png" alt="我的" /> <span
						class="am-navbar-label txt2" style="color: #bfc6d1;">我的</span>
				</a></li>
			</ul>
		</div>
</div>
<?php echo ($site_tongji); ?>
	<!--[if (gte IE 9)|!(IE)]><!-->
	<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>
	<!--<![endif]-->
	<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
	<script src="/ll/themes/lailong/Public/js/weixin/my.js"></script>
	<!--[if lte IE 8 ]>
<!--<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>-->
	<![endif]-->
	
<script>
$("#sign").click(function(){
	var inter=$('#userscore').text();
	$.post('<?php echo U("Mine/sign");?>',
		 	function(data){
				if(data[0]=="101"){
					$("#my-alert").modal();
			 		$("#alert_cont").text(data[1]);
			 		$('#sign').text('已签到');
			 		$('#userscore').text(data[2]);
				}else{
					$("#my-alert").modal();
			 		$("#alert_cont").text(data[1]);
			 		return;
				}
	});
})


</script>
</body>
</html>
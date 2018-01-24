<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>管家服务</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/course.css">
    <style>
		@media all and (orientation: landscape) { 
		#lf{
			left:-80px;
		}
	}
        .am-list .am-list-item-desced a, .am-list .am-list-item-thumbed a{
            color: #000;
        }
    </style>
    <!--<link rel="stylesheet" href="assets/css/app.css">-->
</head>
<body>
<!--切换-->
<div class="qiehuang">
    <div data-am-widget="tabs" class="am-tabs am-tabs-default" style="margin: 0;margin-top:11px">
        <ul class="am-tabs-nav am-cf" style="position: fixed; top: 5px; left: calc(50% - 90px); z-index: 999">
            <li id="fw" class="am-active" style="border: 1px solid;background: white; border-radius: 5px 0 0 5px"><a href="[data-tab-panel-0]">服务</a></li>
            <li id="zx" class="" style="border: 1px solid;background: white;border-left: none; border-radius: 0 5px 5px 0;"><a href="[data-tab-panel-1]">资讯</a></li>
        </ul>
    <!-----------------------服务------------------------------------------------------->
    <div class="am-tabs-bd" style="border: none; margin-top: 40px;">
        <div data-tab-panel-0 class="am-tab-panel am-active" style="padding: 0;">
            <div data-am-widget="list_news" class="am-list-news am-list-news-default am-list-news-bd">
                <ul class="am-list" id="service_list">
                    <!--缩略图在标题左边-->
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="padding-left: 5px;margin-bottom: 11px; border: none;" class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                            <div class="am-u-sm-3 am-list-thumb" style="padding-left: 4px;padding-top: 8px;">
                                <a href="<?php echo U('Mine/server_art',['id'=>$vo['id'],'type'=>'s']);?>">
									<div style="width: 72px;height: 72px;margin-left: -2px;margin-top:-6px; background: url(<?php echo ($imgurl); echo ($vo["icon"]); ?>) no-repeat center;background-size:cover;border-radius:50%;"></div>
                                  
                                </a>
                            </div>
                            <div id="lf" class=" am-u-sm-9 am-list-main" style="padding-top: 2px;">
                                <h6  class="am-list-item-hd"><a class="" style="font-size: 1.6rem;color:black;">
								<a style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis; display:block;" style="color:black" href="<?php echo U('Mine/server_art',['id'=>$vo['id'],'type'=>'s']);?>"><?php echo ($vo["title"]); ?></a></h6>
                                <a href="<?php echo U('Mine/server_art',['id'=>$vo['id'],'type'=>'s']);?>">
                                    <div class="am-list-item-text" style="font-size: 1.4rem">
                                        <?php echo ($vo["content"]); ?>
                                    </div>
                                </a>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <?php if($typea == 1): ?><p style="text-align:center;color: #0e90d2;" class="select_f" name="1" id="service">点击加载更多</p><?php endif; ?>
            </div>
        </div>
        <div id="box" data-tab-panel-1 class="am-tab-panel am-active" style="padding: 0;">
            <div data-am-widget="list_news" class="am-list-news am-list-news-default am-list-news-bd">
                <ul class="am-list" id="information_list">
                    <!--缩略图在标题左边-->
                    <?php if(is_array($ilist)): $i = 0; $__LIST__ = $ilist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="padding-left: 5px;margin-bottom: 11px; border: none;" class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
                            <div class="am-u-sm-3 am-list-thumb" style="padding-left: 4px;padding-top: 8px">
                                <a  href="<?php echo U('Mine/server_art',['id'=>$vo['id'],'type'=>'i']);?>">
                                   	<div style="width: 72px;height: 72px;margin-left: -2px;background: url(<?php echo ($imgurl); echo ($vo["icon"]); ?>) no-repeat center;background-size:cover;border-radius:50%;"></div>
                                </a>
                            </div>
                            <div id="lf" class=" am-u-sm-9 am-list-main" style="padding-top: 2px;">
                                <h6  class="am-list-item-hd">
								<a class="" style="font-size: 1.6rem;color:black;">
								<a style="color:black;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; display:block;" href="<?php echo U('Mine/server_art',['id'=>$vo['id'],'type'=>'i']);?>"><?php echo ($vo["title"]); ?></a></h6>
                                <a  href="<?php echo U('Mine/server_art',['id'=>$vo['id'],'type'=>'i']);?>">
                                    <div class="am-list-item-text" style="font-size: 1.4rem">
                                        <?php echo ($vo["content"]); ?>
                                    </div>
                                </a>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
                <?php if($typeb == 1): ?><p style="text-align:center;color: #0e90d2;" class="select_f" name="1" id="information">点击加载更多</p><?php endif; ?>
            </div>
        </div>
</div>
</div>
</div>
<!-- 顶部背景色 -->
<div style="width: 100%;background: #f4f5f7;position: fixed;top: 0;height: 50px;z-index: 200;">
</div>
<footer style="overflow: hidden;z-index: 999">
        <div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default "
             id="">
            <ul class="am-navbar-nav am-cf am-avg-sm-4" style="background: #fbfbfb;">
                <li >
                    <a href="<?php echo U('Course/course');?>">
                        <img class="show" src="/ll/themes/lailong/Public/images/course1.png" alt="课程"/>
                        <img style="display: none" class="hide" src="/ll/themes/lailong/Public/images/coursed.png" alt="课程"/>
                        <span class="am-navbar-label">课程</span>
                    </a>
                </li>
                <li >
                    <a href="<?php echo U('Mine/server');?>">
                        <img class="show1" src="/ll/themes/lailong/Public/images/server.png" alt="管家服务"/>
                        <img  style="display: none" class="hide1" src="/ll/themes/lailong/Public/images/servered.png" alt="管家服务"/>
                        <span class="am-navbar-label txt1">管家服务</span>
                    </a >
                </li>
                <li >
                    <a href="<?php echo U('Mine/my');?>">
                        <img class="show2" src="/ll/themes/lailong/Public/images/my.png" alt="我的"/>
                        <img  style="display: none" class="hide2" src="/ll/themes/lailong/Public/images/myd.png" alt="我的"/>
                        <span class="am-navbar-label txt2">我的</span>
                    </a>
                </li>
            </ul>
        </div>
</footer>

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<!--<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>-->
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
<script src="/ll/themes/lailong/Public/js/weixin/server.js"></script>
<script>
$("#box").css("display","none");

$("#zx").click(function(){
	$("#box").css("display","block");
})



//加载更多服务
$(".select_f").click(function(){
	var num=$(this).attr("name");
	var table=$(this).attr("id");
	var id = $(this).attr('id');
	$.post('<?php echo U("Mine/select_f");?>',
            { num : num , table : table , id : id},
            function(data){
            	console.log(data);
            	if(data[1]!=""){
            		$("#"+table).attr("name",data[1]);
            	}else{
            		$("#"+table).css("display","none");
            	}
            	$("#"+table+"_list").append(data[0]);
            });
})
</script>
</body>
</html>
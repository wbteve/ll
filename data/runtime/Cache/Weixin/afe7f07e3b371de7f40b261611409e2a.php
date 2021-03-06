<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>订单详情</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/dd.css">
	<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/public.css">
	<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>	

</head>
<style>
.am-list>li{border:none;}
.sta1 ul li{
	line-height:18px;
}
</style>
<body>
<!--订单详情-->
<div class="am-tabs-bd" style="border: none">
    <!--  <div data-tab-panel-0 class="am-tab-panel am-active">-->
    <div class="am-cf am-intro-default" style="margin-top: 0px;padding: 12px 10px">
        <div class="am-g am-intro-bd" style="padding: 0px">
            <div class="xq" style="background:white;height: 70px;padding: 0px 10px;">
                <div class="am-intro-left am-u-sm-2" style="width:50px;height: 50px;margin-top: 10px;border-radius:50%; text-align: center;background: url('<?php echo ($url); echo ($listmes["cover"]); ?>') no-repeat center;background-size:cover;"></div>
                <div class="am-intro-right am-u-sm-10" style="position: relative;top:5px;">
                    <p style="font-size: 16px;margin-top: 8px;color: #4672fb;font-weight: bold;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                    <?php echo ($listmes["title"]); ?></p>
                    <p style="font-size: 11px;margin-top: -17px;margin-bottom:0px;">开课时间：<?php echo date("Y-m-d H:i",strtotime($listmes['time']));?></p>
                    <i class="fa fa-angle-right" aria-hidden="true" style="position: absolute;font-size: 16px;color: #acb1a7; top: 27px; right: 2px;"></i>
                </div>
            </div>
        </div>
      </div>
</div>

<div class="use" style="padding: 5px 10px;margin-top: -6px">
    <ul class="am-list" style="margin-bottom:0px;">
        <li style="text-align: center;height: 50px;padding: 0 10px;border-top: none;margin-bottom: 0px;border-bottom:1px solid #f4f5f7;">
            <a style="color: black;font-size: 16px;height:50px;line-height:50px;padding:0px;">
                <span style="float: left">所需积分</span>
                <span style="float: right; color: #9ba195;" id="jfnum"><?php echo ($listmes["bintegral"]); ?></span>
            </a>
        </li>
        <?php if(!empty($listmes[classroom])): ?><li style="text-align: center;height: 62px;padding: 0 10px;margin-bottom: 0px;border-bottom:1px solid #f4f5f7;">
	            <a style="color: black;font-size: 16px">
	                <span style="float: left;margin-top: -1px;"><?php echo ($listmes["classroom"]); ?></span>
	                <span style="position: absolute;bottom: 8px;left:9px;font-size: 12px;color:#9ba195;"><?php echo ($listmes["address"]); ?></span>
	                <a  style="float: right;color:#9ba195;position:absolute;top:6px;right:10px;" href="tel:<?php echo ($listmes["classroomphone"]); ?>"><span><img style="width: 20px; height: 20px;display:inline-block;margin-top:-2px;" src="/ll/themes/lailong/Public/images/lianxi.png" alt="">&nbsp;联系商家</span></a>
	            </a>
       		 </li><?php endif; ?>
        <li style="text-align: center;height: 50px;padding: 0 10px;margin-bottom: 0px;border-bottom:1px solid #f4f5f7;">
            <a style="color: black;font-size: 16px;height:50px;line-height:50px;padding:0px;">
                <span style="float: left">讲师</span>
                <span style="float: right; color: #9ba195;position:absolute;right:10px;"><?php echo ($listmes["name"]); ?></span>
            </a>
        </li>
        <li style="text-align: center;height: 50px;padding: 0 8px;border-bottom: none;margin-bottom: 0px;">
            <a style="color: black;font-size: 16px;height:50px;line-height:50px;padding:0px;">
                <span style="float: left">上课学生</span>
                <span style="float: right; color: #9ba195;line-height:48px;position:absolute;right:10px;"><?php echo ($listmes["cname"]); ?></span>
            </a>
        </li>
    </ul>
</div>
<!--订单-->
<div class="sta1" style="margin-top:8px;">
    <ul class="am-list" style="margin-bottom:0px;">
        <li>
            <a style="overflow: hidden;">
                <span style="color: #9ba195; float: left;font-size:16px;">订单号码</span>
                <span  style="color: black;margin-left: 18px;font-size:16px;" id="dd"><?php echo ($listmes["order_id"]); ?></span>
                <!-- <span style="float: right;display:inline-block;text-align:center;
                font-size: 12px;color: #28ddaa; width: 50px;height: 19px;line-height: 17px; border: 1px solid #28ddaa;">复制</span> -->
            </a>
        </li>
        <li>
            <a>
                <span style="color: #9ba195;float: left;font-size:16px;">订单时间</span>
                <span style="color: black;margin-left: 18px;font-size:16px;"><?php echo ($listmes["createtime"]); ?></span>
            </a>
        </li>
        <li>
            <a>
                <span style="color: #9ba195;float: left;font-size:16px;">支付方式</span>
                <span style="color: black;margin-left: 18px;font-size:16px;">积分支付</span>
            </a>
        </li>
    </ul>
</div>

<!--备注-->
<?php if(!empty($listmes['note'])): ?><div class="sta2" style="margin-top:8px;">
    <ul class="am-list" style="margin-bottom:0px;">
        <li style="overflow: hidden;">
            <a href="#" style="overflow: hidden">
                <span style="color: black; float: left;font-size: 15px">备注</span>
                <br>
                <span style="color: #9ba195;float: left;font-size: 12px">
                    <?php echo ($listmes["note"]); ?>
                </span>
            </a>
        </li>
    </ul>
</div><?php endif; ?>
<div class="sta1" <?php if(!empty($listmes['note'])): ?>style="margin-top:14px;"<?php else: ?>style="margin-top:8px;"<?php endif; ?>>
    <ul class="am-list">
        <li>
            <a href="#" style="overflow: hidden">
                <span style="color:black; float: left;font-size: 16px">订单跟踪</span>
            </a>
        </li>
        <?php if(is_array($state)): foreach($state as $key=>$vo): ?><li class="a">
	            <a href="#">
	                <span style="color: black;float: left;font-size: 16px"><?php echo ($type_state[$vo[state]]); ?></span>
	                <span style="color: black;float: right; margin-left: 18px;font-size: 16px"><?php echo ($vo["createtime"]); ?></span>
	            </a>
	        </li><?php endforeach; endif; ?>
    </ul>
</div>
<footer  data-am-widget="footer" style="position: fixed;bottom: 0;">
    <?php if($listmes['state'] ==0){ ?>
        <button id="zf">支付</button>
    <?php }elseif($listmes['state'] ==1){ if($listmes['cancel_state']=="0"||$listmes['cancel_state']=="2"){ ?>
        <a href="<?php echo U('Mine/cancel_order',['id'=>$_GET['id']]);?>"><button>取消订单</button></a>
    <?php }elseif($listmes['cancel_state']=="1"){ ?>
        <a><button>取消申请中</button></a>  
    <?php }}elseif($listmes['state'] == 3){ ?>
        <button>已完成</button>
    <?php }elseif($listmes['state'] == 4){ ?>
        <button>已取消</button>
    <?php } ?>
</footer>

<!--悬浮按钮-->


<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-bd" id="alert_cont">
      Hello world！
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn">确定</span>
    </div>
  </div>
</div>

<div class="am-modal am-modal-alert" tabindex="-1" id="default-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-bd" id="alert_conts">
      Hello world！
    </div>
    <input type="hidden" id="returnval"/> 
    <div class="am-modal-footer">
      <span class="am-modal-btn true">确定</span>
    </div>
  </div>
</div>
<div class="am-modal am-modal-alert" tabindex="-1" id="conform-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-bd" id="conform_conts">
      Hello world！
    </div>
    <input type="hidden" id="returnval"/> 
    <div class="am-modal-footer">
      <span class="am-modal-btn cancel">取消</span>
      <span class="am-modal-btn tobuy">购买</span>
    </div>
  </div>
</div>
<input type="hidden" id="moban" value="/ll/themes/lailong/">

<!--浮动导航-->
<div class="nav_bar" style="z-index:999;bottom:60px;left:20px">
	<ul class="am-list" id="panel">
		<li style="background:none!important;"><a href="<?php echo U('Mine/my');?>"><img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/user.png"></a></li>
		<li style="background:none!important;"><a href="<?php echo U('Mine/server');?>"><img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/gn.png"></a></li>
		<li style="background:none!important;"><a href="<?php echo U('Course/course');?>"><img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/course.png"></a></li>
	</ul>
	<!--<div id="flip" class="icon_nav"></div>-->
	<div id="flip" name="0" style="background:none" >
		<img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/open.png">
	</div>
</div>

<script src="/ll/themes/lailong/Public/js/weixin/public.js"></script>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
</body>
<script>

    $(function(){
        $('#zf').click(function(){
            var jf = $('#jfnum').text();
            var url = "<?php echo U('Mine/payjifen');?>";
            $.ajax({
                url : url,
                type : 'POST',
                data : {'jf':jf,'dd':"<?php echo $_GET[id];?>"},
                success : function(data){
                    if(data[0] == '1'){
                    	$("#my-alert").modal();
				 		$("#alert_cont").text(data[1]);
				 		return;
                    }else if(data[0] == '0'){
                    	$("#default-alert").modal();
				 		$("#alert_conts").text(data[1]);
                        window.setTimeout("refreshPage()",5000);
                    }else{
                    	$("#my-alert").modal();
				 		$("#alert_cont").text(data[1]);
				 		return;
                    }
                }
            })
        })
    })
    function refreshPage()
    {
    window.location.reload();
    
    }
</script>
</html>
<?php
define ( "URL1", "https://t2s.refineit.cn/wxoauth_21g/index.php?g=weixin&m=oauthfw&a=index&url=" );//鉴权页面路径
define('SITE_URL','https://t2s.refineit.cn/lailong');//项目URL
define('SITE_URLS',"https://t2s.refineit.cn");//项目URL
define('PAY_URL',"https://t2s.refineit.cn/wxoauth_21g");
define("NOTIFY_URL",urlencode(PAY_URL."/WxPayTest/example/notify2.php"));//设置回调URL
define('CODE_LAST_TIME',"15");//验证码过期时间单位(分钟)
define("PROJECTNAME", "lailong");
define("ROOT", $_SERVER['DOCUMENT_ROOT'].'/'.PROJECTNAME);//文件传入时需要的根目录
define("AVATAR_ROOT", SITE_URLS.'/'.PROJECTNAME);//服务器项目路径
define ( "BUY_MODEL", "92V1Glh0diFeCq6_kWa0nTGrCJE_ldfpS3RYwR693Os" ); // 购买成功通知
define ( "TOKEN", "weixin" );
define ( "APPID", "wx6ccce8752525b8cc" );
define ( "APPSECRET", "7d87a2a84199b99cf6c5765f657fcac4" );
define('TONGZHI_MODEL', 'WxMde2DGqeW8i6cMV8dtHBxbVpndrB8WKdtY5rU7LCA');
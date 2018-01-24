<?php
namespace Common\Controller;
use Common\Controller\HomebaseController;
class MemberbaseController extends HomebaseController{
	
	function _initialize(){
				if (empty($_SESSION ['userinfo']) || ! isset ( $_SESSION ['userinfo'] )) {
				if (! isset ( $_GET ['userInfo'] )) {
					$url = URL1.urlencode(SITE_URLS.$_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']."&");
					header("Location: $url");
					exit();
				}else{
					$_SESSION ['userinfo'] = $_GET ['userInfo'];
				}
			}
			if(isset($_GET ['userInfo'])){
				$usersi=$_GET ['userInfo'];
			}else{
				$usersi=$_SESSION ['userinfo'];
			}
			$userinfo =  json_decode($usersi,true);
			$userinfo =  json_decode($userinfo,true);
			$open_id=$userinfo['openid'];
		
		 
		//设置session openid
		$_SESSION[weiopen_id]=$open_id;
		$_SESSION[weimes]=$userinfo;
		
		$users=M("user")->where("openid='$open_id'")->find();
		$_SESSION['weixin_user_id']=$users['id'];
		if(empty($users)){//跳转绑定页面
			$this->redirect("Center/index");
		}
	}
	
}
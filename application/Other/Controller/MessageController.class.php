<?php

namespace Other\Controller;
use Common\Controller\AdminbaseController;
use Weixin\Controller\PublicController;
use Think\Log;
require 'php/jiguang.php';
error_reporting(E_ALL^E_NOTICE);
class MessageController extends AdminbaseController {
    private $_appkeys = 'fff82c736e828424fa1bbb80';
    private $_masterSecret = 'bc6ff9522db3d84edfafb4ac';
    private $bool=1;
	function _initialize() {
	}
    /**
     *消息列表
     */
    public function index() {
        $course = isset ( $_REQUEST ['course'] ) ? $_REQUEST ['course'] : ''; // 关键字
        $user_id = isset ( $_REQUEST ['user_id'] ) ? $_REQUEST ['user_id'] : ''; // 关键字
        $where= "1=1";
        //判断是否表单处提交的数据，如果是就重置session值
        if($_REQUEST['leixing']==1){
            $_SESSION['course']=$course;
            $_SESSION['users_id']=$user_id;
        }
        if($_SESSION['course'] != ''){
            $where .= " and c.id = $_SESSION[course]";
        }
        if($_SESSION['users_id'] != ''){
            $where .= " and  n.user_id = $_SESSION[users_id]";
        }
        if($_POST['type']=='全部'){
            $_SESSION['course']="";
            $_SESSION['users_id']="";
        }
        $model = M ("news");
        $count = $model->where($where)->table(C('DB_PREFIX')."news as n")
              ->join(C('DB_PREFIX')."course as c on c.id = n.course_id",'left')
              ->join(C('DB_PREFIX')."user as u on u.id = n.user_id",'left')->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->field("n.*,c.title as coursename,u.phone")
              ->table(C('DB_PREFIX')."news as n")
              ->join(C('DB_PREFIX')."course as c on c.id = n.course_id",'left')
              ->join(C('DB_PREFIX')."user as u on u.id = n.user_id",'left')
              ->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $c=M('course')->select();
        $this->assign('c', $c);
        $u=M('user')->select();
        $this->assign('u', $u);
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
        $this->assign("formget",$_SESSION); 
       	$this->display();
    }
    //添加
     public function add(){
        //筛选今天过后的课程//当前时间吧？就这么决定了
        $today=date("Y-m-d H:i:s");
         $res=M('course')->where(" start_time >= '".$today."' ")->select();
         $user=M('user')->select();
         $this->assign('user',$user);
         $this->assign('res',$res);
         $this->display();
     }
     public function add_post(){
         $title=$_REQUEST['title'];
         $course_id=$_REQUEST['course_id'];
         $icon=$_REQUEST['icon1'];
         $content=$_REQUEST['content'];
         $type=$_REQUEST['type'];
          if(empty($title)){
             $this->error("请填写标题");
         }
         // if(empty($course_id)){
         //    $this->error("请选择课程");
         // }
       /*   if(empty($icon)){
             $this->error("请填写图片地址");
         } */
         if(empty($content)){
             $this->error("请填写内容");
         }
         if(empty($type)&&$type!='0'){
            $this->error("请选择推送平台");
         } 
         // if(empty($user_id)){	
         //     $this->error("请选择成员");
         // }
         //$t=M('Course')->field("title")->where("id = $course_id")->find();
         //$u=M('user')->field("phone")->where("id= $user_id")->find();
         $push = new \JPushZDY();
         if(empty($course_id)){
             $data=array(
                 'title'=>$title,
                 'type'=>$type,
                 'icon'=>$icon,
                 'course_id'=>0,
                 'content'=>$content,
                 //'user_id'=>$user_id,
                 'createtime'=>date('Y-m-d H:i:s',time())
             );
             M('news')->add($data);
             //安卓app
             if($type == 0){
                 $result = $push->push('all',$content,'','','86400');
             }
             //微信
             if($type == 1){
                /*  $data = array (
                     'userName' => array ( 'value' => urlencode ( $name )),
                     'courseName' => array ( 'value' => urlencode ("test")),
                     'date' => array ( 'value' => urlencode ( "1份" )),
                     'remark'=>array ( 'value' => urlencode ('sss')),
                 );
                 foreach($usa as $u=>$a){
                     if(!empty($a['openid'])){
                         $this->doSend ( 0, $a['openid'], TONGZHI_MODEL,"", $data );
                     }
                 }
                 $this->success("发送成功"); */
             }
             //安卓 微信
             if($type == 2){
                 $result = $push->push('all',$content,'','','86400');
                /*  $data = array (
                     'productType' => array ( 'value' => urlencode ( "商品名" )),
                     'name' => array ( 'value' => urlencode ("test")),
                     'number' => array ( 'value' => urlencode ( "1份" )),
                     'expDate' => array ( 'value' => urlencode (date("Y-m-d",time()+$timend*3600*24))),
                     'remark'=>array ( 'value' => urlencode ('sss')),
                 );
                 $usa=M('user')->field("openid")->select();
                 foreach($usa as $u=>$a){
                     if(!empty($a['openid'])){
                         $this->doSend ( 0, $a['openid'], TONGZHI_MODEL,"", $data );
                     }
                 } */
             }
             
         }else{//存在课程
            $i= M('intention')->field("user_id")->where("course_id = $course_id")->select();
            foreach($i as $k=>$v){
                $data=array(
                    'title'=>$title,
                    'type'=>$type,
                    'icon'=>$icon,
                    'course_id'=>$course_id,
                    'content'=>$content,
                    'createtime'=>date('Y-m-d H:i:s',time())
                );
                if($v['user_id'] == 0){
                    $this->error("所选课程没有意向用户");
                }else{
                    $data['user_id']=$v['user_id'];
                }
                M('news')->add($data);
              
                $receives = array('alias'=>array($v['user_id']));//别名
                //安卓app
                if($type == 0){
                    $result = $push->push($receives,$content,'','','86400');
                }
                $usa=M('user')->field("name,phone,openid")->where("id = $v[user_id]")->find();
                $c=M('course')->field('title,start_time')->where("id = $course_id")->find();
                if(!empty($usa[name])){
                    $name=$usa[name];
                }else{
                    $name=$usa[phone];
                }
                //微信单推
                if($type == 1){
                    $data = array (
                     'userName' => array ( 'value' => urlencode ( $name )),
                     'courseName' => array ( 'value' => urlencode ($c[title])),
                     'date' => array ( 'value' => urlencode ( $c[start_time] )),
                     'remark'=>array ( 'value' => urlencode ("参加完课程请确认课程")),
                    );
                    $usa=M('user')->field("openid")->where("id = '$v[user_id]'")->find();
                        $this->doSend ( 0, $usa['openid'], COURSE_MODEL,"", $data );
                }
                //安卓 微信
                if($type == 2){
                    $result = $push->push($receives,$content,'','','86400');
                     $data = array (
                     'userName' => array ( 'value' => urlencode ( $name )),
                     'courseName' => array ( 'value' => urlencode ($c[title])),
                     'date' => array ( 'value' => urlencode ( $c[start_time] )),
                     'remark'=>array ( 'value' => urlencode ("参加完课程请确认课程")),
                    );
                    $usa=M('user')->field("openid")->where("id = '$v[user_id]'")->find();
                    if(!empty($usa['openid'])){
                        $this->doSend ( 0, $usa['openid'], COURSE_MODEL,"", $data );
                    }
                }
            }
         }
         $this->success("发送成功",U('message/index')); exit();
     }
     public function delete(){
         if(M('news')->delete($_REQUEST[id])){
             $this->success("操作成功");
         }else{
             $this->error("操作失败");
         }
     }
    
     // 发送自定义的模板消息
     public function doSend($id, $touser, $template_id, $url, $data, $topcolor = '#7B68EE') {
         /*
          * $data = array ( 'first' => array ( 'value' => urlencode ( "您好,您已购买成功" ), 'color' => "#743A3A" ), 'name' => array ( 'value' => urlencode ( "商品信息:微时代电影票" ), 'color' => '#EEEEEE' ), 'remark' => array ( 'value' => urlencode ( '永久有效!密码为:1231313' ), 'color' => '#FFFFFF' ) );
          */
         $log = new Log();
          
         $template = array (
             'touser' => $touser,
             'template_id' => $template_id,
             'url' => $url,
             'topcolor' => $topcolor,
             'data' => $data
         );
         $json_template = json_encode ( $template );
         $log->write($json_template.'111');
         $access_token = $this->get_access_token();
         $log->write($access_token.'222');
         $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
          
         $dataRes = $this->request_post2 ( $url, urldecode ( $json_template ) );
         $log->write($dataRes.'555');
     
     }
     function get_access_token() {
         $appid = APPID;
         $appsecret = APPSECRET;
         $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
         $log = new Log();
         $log->write($url);
         $ch = curl_init ();
         curl_setopt ( $ch, CURLOPT_URL, $url );
         curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
         curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
         curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
         $output = curl_exec ( $ch );
         curl_close ( $ch );
         $jsoninfo = json_decode ( $output, true );
         $log->write($jsoninfo);
         $access_token = $jsoninfo ["access_token"];
         return $access_token;
     }
     /**
      * 发送post请求
      *
      * @param string $url
      * @param string $param
      * @return bool mixed
      */
     function request_post2($url = '', $param = '') {
         $log = new Log();
         $log->write($url.$param.'3333');
         if (empty ( $url ) || empty ( $param )) {
             return false;
         }
         $postUrl = $url;
         $curlPost = $param;
         $ch = curl_init (); // 初始化curl
         curl_setopt ( $ch, CURLOPT_URL, $postUrl ); // 抓取指定网页
         curl_setopt ( $ch, CURLOPT_HEADER, 0 ); // 设置header
         curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); // 要求结果为字符串且输出到屏幕上
         curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
         curl_setopt ( $ch, CURLOPT_POST, 1 ); // post提交方式
         curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curlPost );
         $data = curl_exec ( $ch ); // 运行curl
         $log->write(curl_error ( $ch ).'44444');
         curl_close ( $ch );
         return $data;
     }

          //过滤效率图
     function up(){
         $savename="";
         $config = array (
             'FILE_UPLOAD_TYPE' => sp_is_sae () ? "Sae" : 'Local',
             'rootPath' =>  './data/upload/message/',
             /* 'maxSize' => 2097152, // 2M  */
             /* 'maxSize' => 104857600, // 100M  */
             'saveName' => array (
                 'uniqid',
                 $param.time()
             ),
             'exts' => array (
                 'jpg',
                 'png',
                 'jpeg',
                 'gif',
                 'bmp'
             ),
             'autoSub' => false
         );
         $upload = new \Think\Upload ( $config );
         $info = $upload->upload ();
         $first = array_shift($info);
         $savename= $first['savename'];
         //ajax返回数据
         if ($savename) {
             $this->ajaxReturn ( sp_ajax_return ( array (
                 'iconname'=>$savename
             ), "上传成功！", 1 ), "AJAX_UPLOAD" );
         } else {
             $this->ajaxReturn ( sp_ajax_return ( array (), $upload->getError (), 0 ), "AJAX_UPLOAD" );
         }
     }
     function deleteicon()
     {
         if(!empty($_POST['img2']))
         {
             unlink("./data/upload/message/$_POST[img2]");
         }
     }
} 

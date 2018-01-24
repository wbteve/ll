<?php

namespace Classification\Controller;
use Common\Controller\AdminbaseController;
use Think\Log;
require 'php/jiguang.php';
class ClassificationController extends AdminbaseController {
	function _initialize() {
	}
    /**
     *讲师列表
     */
    public function teacherlist() {
        $teacher_name = isset ( $_REQUEST ['teacher_name'] ) ? $_REQUEST ['teacher_name'] : ''; // 关键字
        $gradename = isset ( $_REQUEST ['gradename'] ) ? $_REQUEST ['gradename'] : ''; // 关键字
        $where= "1=1";
        //判断是否表单处提交的数据，如果是就重置session值
        if($_REQUEST['leixing']==1){
            $_SESSION['teacher_name']=$teacher_name;
            $_SESSION['gradename']=$gradename;
        }
        if($_SESSION['teacher_name'] != ''){
            $where .= " and (name like '%$_SESSION[teacher_name]%')";
        }
        if($_SESSION['gradename'] != ''){
            $where .= " and (teaching_grade like '%$_SESSION[gradename]%')";
        }
        if($_POST['type']=='全部'){
            unset( $_SESSION['teacher_name']);
            unset( $_SESSION['gradename']);
        }
        $g=M('grade')->order("index_id asc")->select();
        $model = M ("teacher");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $this->assign('g', $g);
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
        $this->assign("formget",$_SESSION); 
       	$this->display();
    }
    //添加课程
     public function addteacher(){
         $this->display();
     }
     //添加操作
     public function add_post(){
         $name=$_REQUEST['name'];
         $avatar=$_POST['avatar'];
         $university=$_REQUEST['university'];
         $teaching_grade=$_REQUEST['teaching_grade'];
         $teaching_results=$_REQUEST['teaching_results'];
         $experience=$_REQUEST['experience'];
         $features=$_REQUEST['features'];
         if(empty($name)){
             $this->error("请填写讲师姓名");
         }
         if(empty($avatar)){
             $this->error("请选择头像");
         }
         if(empty($university)){
             $this->error("请填写毕业大学");
         }
         if(empty($teaching_grade)){
             $this->error("授课年级");
         }
         if(empty($teaching_results)){
             $this->error("请填写教学成果");
         }
         if(empty($experience)){
             $this->error("请填写教学经验");
         }
         if(empty($features)){
             $this->error("请填写教学特点");
         }
         $chongming=M('teacher')->where("name = '$name'")->find();
         if($chongming){
             $this->error("此讲师已存在");
         }
         $data=array(
             'name'=>$name,
             'avatar'=>$avatar,
             'university'=>$university,
             'teaching_grade'=>$teaching_grade,
             'teaching_results'=>$teaching_results,
             'experience'=>$experience,
             'features'=>$features,
             'createtime'=>date('Y-m-d H:i:s')
         );
         if(M('teacher')->add($data)){
             $this->success('创建讲师成功',U('classification/teacherlist'));
         }else{
             $this->error('创建讲师失败');
         }
     }
     //编辑
     public function editeacher(){
         $res=M("teacher")->where("id = $_REQUEST[editid]")->find();
         $this->assign('list',$res);
         $this->display();
     }
     public function edit_post(){
         $editid=$_REQUEST['editid'];
         $name=$_REQUEST['name'];
         $avatar=$_POST['avatar'];
         $university=$_REQUEST['university'];
         $teaching_grade=$_REQUEST['teaching_grade'];
         $teaching_results=$_REQUEST['teaching_results'];
         $experience=$_REQUEST['experience'];
         $features=$_REQUEST['features'];
         if(empty($name)){
             $this->error("请填写讲师姓名");
         }
         if(empty($avatar)){
             $this->error("请选择头像");
         }
         if(empty($university)){
             $this->error("请填写毕业大学");
         }
         if(empty($teaching_grade)){
             $this->error("授课年级");
         }
         if(empty($teaching_results)){
             $this->error("请填写教学成果");
         }
         if(empty($experience)){
             $this->error("请填写教学经验");
         }
         if(empty($features)){
             $this->error("请填写教学特点");
         }
         $data=array(
             'name'=>$name,
             'avatar'=>$avatar,
             'university'=>$university,
             'teaching_grade'=>$teaching_grade,
             'teaching_results'=>$teaching_results,
             'experience'=>$experience,
             'features'=>$features,
         );
         if(M('teacher')->where("id = $editid")->save($data)){
             $this->success('修改讲师成功',U('classification/teacherlist'));
         }else{
             $this->error('修改讲师失败');
         }
     }

     public function deleteteacher(){
        $id = I("get.id",0,"intval");
        if (M('teacher')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
     }
     //过滤效率图
     function up(){
         $savename="";
         $config = array (
             'FILE_UPLOAD_TYPE' => sp_is_sae () ? "Sae" : 'Local',
             'rootPath' =>  './data/upload/avatar/',
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
             unlink("./data/upload/avatar/$_POST[img2]");
         }
     }

     public function childlist(){
        $_SESSION['num_child']="";
        $_SESSION['c_res']="";
        $name=$_REQUEST['name'];
        $nickname=$_REQUEST['nickname1'];
        $gender=$_REQUEST['gender1'];
        $school=$_REQUEST['school1'];
        $grade=$_REQUEST['grade1'];
        $vip_state=$_REQUEST['vip_state1'];
        $startbirthday=$_REQUEST['startbirthday1'];
        $endbirthday=$_REQUEST['endbirthday1'];
        $where="1=1";
        if(!empty($name)){
            $where.=" and name like '%".$name."%' ";
            $parameter['name']=$name;
            $this->assign('name',$name);
        }
        if(!empty($nickname)){
            $where.=" and nickname like '%".$nickname."%' ";
            $parameter['nickname1']=$nickname;
            $this->assign('nickname',$nickname);
        }
        if(!empty($gender)){
            if($gender=="3"){
                $gender1=0;
            }else{
                $gender1=$gender;
            }
            $where.=" and gender =  ".$gender1;
            $parameter['gender1']=$gender;
            $this->assign('gender',$gender);
        }
        if(!empty($school)){
            $where.=" and school like '%".$school."%' ";
            $parameter['school1']=$school;
            $this->assign('school',$school);
        }
        if(!empty($grade)){
            $where.=" and grade like '%".$grade."%' ";
            $parameter['grade1']=$grade;
            $this->assign('grade',$grade);
        }
        if(!empty($vip_state)){
            if($vip_state=='99'){
                $vip_state1=0;
            }else{
                $vip_state1=$vip_state;
            }
            $where.=" and vip_state = ".$vip_state1;
            $parameter['vip_state1']=$vip_state;
            $this->assign("vip_state",$vip_state);
        }
        if(!empty($startbirthday)){
            $where.=" and birthday >= '".$startbirthday."' ";
            $parameter['startbirthday1']=$startbirthday;
            $this->assign('startbirthday',$startbirthday);
        }
        if(!empty($endbirthday)){
            $where.=" and birthday <= '".$endbirthday."' ";
            $parameter['endbirthday1']=$endbirthday;
            $this->assign('endbirthday',$endbirthday);
        }
        $model = M ("child");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->where($where)->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('list', $list);
        if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
        }  
        $this->assign("page", $page->show("Admin"));
        $this->display();  
     }
     public function addchild(){
        $u_id=$_REQUEST['u_id'];
        if($u_id){
            $uinfo=M('user')->field('id,name')->where(" id = ".$u_id)->find();
            $this->assign("uinfo",$uinfo);
        }
        
        $this->display();
     }
     public function addchild_post(){

        if(empty($_POST['name'])){
            $this->error("孩子名字不能为空");
        }
        if(empty($_POST['birthday'])){
            $this->error("生日不能为空");
        }
        if(empty($_POST['school'])){
            $this->error("所在学校不能为空");
        }
        if(empty($_POST['grade'])){
            $this->error("所在年级不能为空");
        }
        // if($_POST['vip_state']=='4'){
        //     $this->error("请先绑定用户");
        // }
        if(!empty($_POST['u_id'])&&empty($_POST['username'])){
            $this->error("用户需要填写姓名后才能进行关联操作");
        }
        $u_id=$_POST['u_id'];
        $appellation=$_POST['appellation'];
        unset($_POST['appellation']);
        unset($_POST['u_id']);
        unset($_POST['username']);
        //新增的时候可以认证成功
        if(IS_POST){
            if (M("child")->create()!==false){
                if (M("child")->add()!==false) {
                    if($u_id){
                        //获取刚添加的孩子id
                        $child_id= M('child')->getLastInsID();
                        //添加到成员表
                        
                        $data['appellation']=$appellation;
                        $data['child_id']=$child_id;
                        $data['user_id']=$u_id;
                        $data['createtime']=date("Y-m-d H:i:s");
                        M("member")->add($data);
                        //添加完后判断是否为认证成功
                        if($_POST['vip_state']=='4'){
                            //认证成功，用户获得积分
                            $uinfo=M('user')->where(" id = ".$u_id)->find();
                            $needintegral=M('encourage_config')->where(" type = 0 ")->find();
                            $data1['integral']=intval($uinfo['integral']+$needintegral['integral']);
                            $data1['id']=$u_id;
                            M('user')->save($data1);
                            //积分添加记录
                            $data2['user_id']=$u_id;
                            $data2['obtain_type']=0;
                            $data2['is_obtain']=1;
                            $data2['integral']=$needintegral['integral'];
                            $data2['createtime']=date("Y-m-d H:i:s");
                            $data2['content']="认证孩子成功";
                            M('integral')->add($data2);
                        }
                    }
                    
                    $this->success(L('ADD_SUCCESS'), U("classification/childlist"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("child")->getError());
            }
        
        }
     }
     public function editchild(){
        $u_id=$_REQUEST['u_id'];
        if($u_id){
            $uinfo=M('user')->field('id,name')->where(" id = ".$u_id)->find();
            $this->assign("uinfo",$uinfo);
        }
        $res=M("child")->where("id = $_REQUEST[editid]")->find();
        if($res['id']){
                $info=M("member")->field("user_id,appellation")->where(" child_id = ".$res['id'])->find();
                $this->assign("info",$info);
            
            
            if($info['user_id']){
                $uinfo=M("user")->field("id,name")->where(" id = ".$info['user_id'])->find();
                $this->assign("uinfo",$uinfo);
            }else{
                if($u_id){
                    $uinfo=M('user')->field('id,name')->where(" id = ".$u_id)->find();
                    $this->assign("uinfo",$uinfo);
                }  
            }
        }
        
        $this->assign($res);
        $this->display();
     }
     public function editchild_post(){

        if(empty($_POST['name'])){
            $this->error("孩子名字不能为空");
        }
        if(empty($_POST['birthday'])){
            $this->error("生日不能为空");
        }
        if(empty($_POST['school'])){
            $this->error("所在学校不能为空");
        }
        if(empty($_POST['grade'])){
            $this->error("所在年级不能为空");
        }
        if(empty($_POST['appellation'])){
            $this->error("用户与孩子的称呼不能为空");
        }
        //查询原来孩子的状态
        $childinfo=M("child")->where("1=1 and id = '".$_POST['id']."' ")->find();

        if($_POST['vip_state']=='3'&&$childinfo['vip_state']!="3"){
            //添加积分给用户//查询用户//备注，无法确定给哪个用户积分//1可以确定了
            $info=M('member')->where(" child_id =  ".$_POST['id'])->find();
            //添加积分
            //查询应该添加的积分
            $needintegral=M('encourage_config')->where(" type = 0 ")->find();
            if($info['user_id']||$_POST['u_id']){
                //用户id
                if(empty($info['user_id'])){
                    $u_id=$_POST['u_id'];
                }else{
                    $u_id=$info['user_id'];
                }
                $uinfo=M('user')->where(" id = ".$u_id)->find();
                $data1['integral']=$uinfo['integral']+$needintegral['integral'];
                $data1['id']=$u_id;
                M('user')->save($data1);
                //积分添加记录
                $data2['user_id']=$u_id;
                $data2['obtain_type']=0;
                $data2['is_obtain']=1;
                $data2['integral']=$needintegral['integral'];
                $data2['content']="认证孩子成功";
                $data2['createtime']=date("Y-m-d H:i:s");
                M('integral')->add($data2);
            }else{
                $this->error("尚未关联用户");
            }
            
        }

        if(IS_POST){
            $user_id=$_POST['u_id'];
            $vip_state=$_POST['vip_state'];
            $appellation=$_POST['appellation'];
            unset($_POST['appellation']);
            unset($_POST['u_id']);
            if (M("child")->create()!==false){
                if (M("child")->save()!==false) {
                    //获取刚添加的孩子id
                    $child_id=$_POST['id'] ;
                    //查询member表是否存在
                    $is_exist=M("member")->where(" child_id = '".$child_id."' and user_id = '".$user_id."' ")->find();
                    $usa=M('user')->field("openid")->where("id = $user_id")->find();
                    if($vip_state =='2'&&$childinfo['vip_state']!="2"){
                       /* $data = array (
                         'first' => array ( 'value' => urlencode ( "您的小孩认证失败" )),
                         'keyword1' => array ( 'value' => urlencode ("初级会员")),
                         'keyword2' => array ( 'value' => urlencode ( "未通过" )),
                         'keyword3' => array ( 'value' => urlencode (  date('Y-m-d H:i:s',time()))),
                         'remark'=>array ( 'value' => urlencode ("请重新申请，我们会及时处理"))
                        );
                         $this->doSend ( 0, $usa['openid'], AUTH_MODEL,"", $data ); */
                        $content="您的小孩认证失败，请修改后重新申请认证";
                        $push = new \JPushZDY();
                        $receive = array('alias'=>array($user_id));//别名
                        $result = $push->push($receive,$content,'','','86400');
                    }
                    if($vip_state =='3'&&$childinfo['vip_state']!="3"){
                        $data = array (
                         'first' => array ( 'value' => urlencode ( "您的小孩认证失败" )),
                         'keyword1' => array ( 'value' => urlencode ("初级会员")),
                         'keyword2' => array ( 'value' => urlencode ( "未通过" )),
                         'keyword3' => array ( 'value' => urlencode (  date('Y-m-d H:i:s',time()))),
                         'remark'=>array ( 'value' => urlencode ("请重新申请，我们会及时处理")),
                        );
                            $this->doSend ( 2, $usa['openid'], AUTH_MODEL,"", $data );
                        $content="您的小孩认证成功";
                        $push = new \JPushZDY();
                        $receive = array('alias'=>array($user_id));//别名
                        $result = $push->push($receive,$content,'','','86400');
                    }
                    if(empty($is_exist)){
                        //添加到成员表
                        $data4['child_id']=$child_id;
                        $data4['user_id']=$user_id;
                        $data4['appellation']=$appellation;
                        $data4['createtime']=date("Y-m-d H:i:s");
                        M("member")->add($data4);
                    }else{
                        $data4['child_id']=$child_id;
                        $data4['user_id']=$user_id;
                        $data4['appellation']=$appellation;
                        $data4['id']=$is_exist['id'];
                        M("member")->save($data4);
                    }
                    $this->success(L('ADD_SUCCESS'), U("classification/childlist"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("child")->getError());
            }
        
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
     public function changechild(){
        $id=$_REQUEST['id'];
        $type=$_REQUEST['type'];
        $u=M('user')->field("u.id")->table(C('DB_PREFIX')."user as u")->join(C('DB_PREFIX').'member as m on m.user_id = u.id','left')->where("m.child_id = $id")->find();
        if($id&&$type){
            $datax['id']=$id;
            if($type=='1'){
                $datax['vip_state']=3;//成功
                
            }else{
                $datax['vip_state']=2;//失败
                
            }
           if($id&&$type=='1'){
                //添加积分给用户//查询用户//备注，无法确定给哪个用户积分//1可以确定了
            $info=M('member')->where(" child_id =  ".$id)->find();
            if(empty($info['user_id'])){
                echo "2";die;//尚未绑定用户
            }else{
                $u_id=$info['user_id'];
            //添加积分
            //查询应该添加的积分
            $needintegral=M('encourage_config')->where(" type = 0 ")->find();
                $uinfo=M('user')->where(" id = ".$u_id)->find();
                if(empty($uinfo)){
                    echo "2";die;
                }else{
                    $data1['integral']=$uinfo['integral']+$needintegral['integral'];
                    $data1['id']=$u_id;
                    M('user')->save($data1);
                    //积分添加记录
                    $data2['user_id']=$u_id;
                    $data2['obtain_type']=0;
                    $data2['is_obtain']=1;
                    $data2['integral']=$needintegral['integral'];
                    $data2['content']="认证孩子成功";
                    $data2['createtime']=date("Y-m-d H:i:s");
                    M('integral')->add($data2);
                    
                }
                
            }
            
           }

            
            

        }
        if(empty($u['id'])){
              echo 3;  die;
            }
            $usa=M('user')->field("openid")->where("id = $u[id]")->find();
        if($id&&$type=='1'){
             $data = array (
                 'first' => array ( 'value' => urlencode ( "您的小孩认证成功" )),
                 'keyword1' => array ( 'value' => urlencode ("初级会员")),
                 'keyword2' => array ( 'value' => urlencode ( "通过" )),
                 'keyword3' => array ( 'value' => urlencode (  date('Y-m-d H:i:s',time()))),
                 'remark'=>array ( 'value' => urlencode ("请为您的小孩添加喜欢的课程吧")),
                 );
               /*  $this->doSend ( 0, $usa['openid'], AUTH_MODEL,"", $data );
                $content="您的小孩认证已认证成功";
                $push = new \JPushZDY();
                $receive = array('alias'=>array($u[id]));//别名
                $result = $push->push($receive,$content,'','','86400'); */
        }elseif($id&&$type=='2'){
             /* $data = array (
             'first' => array ( 'value' => urlencode ( "您的小孩认证失败" )),
             'keyword1' => array ( 'value' => urlencode ("初级会员")),
             'keyword2' => array ( 'value' => urlencode ( "未通过" )),
             'keyword3' => array ( 'value' => urlencode ( date('Y-m-d H:i:s',time()))),
             'remark'=>array ( 'value' => urlencode ("请重新申请，我们会及时处理")),
            );
                $this->doSend ( 0, $usa['openid'], AUTH_MODEL,"", $data ); */
                $content="您的小孩认证失败，请修改后重新申请认证";
                $push = new \JPushZDY();
                $receive = array('alias'=>array($u[id]));//别名
                $result = $push->push($receive,$content,'','','86400');
        }
        $a = M("child")->save($datax);
                    if($a){
                        echo 1;die;
                    }else{
                        echo 2;die;
                    }
     }

     public function member(){
        $childname=$_REQUEST['childname'];
        $username=$_REQUEST['username'];
        $appellation=$_REQUEST['appellation'];
        $phone=$_REQUEST['phone'];
        $where="1=1";
        if(!empty($childname)){
            $where.=" and (c.name like '%".$childname."%' or c.nickname like '%".$childname."%' ) ";
            $parameter['childname']=$childname;
            $this->assign('childname',$childname);
        }
        if(!empty($username)){
            $where.=" and u.name like '%".$username."%' ";
            $parameter['username']=$username;
            $this->assign('username',$username);
        }
        if(!empty($appellation)){
            $where.=" and m.appellation like '%".$appellation."%' ";
            $parameter['appellation']=$appellation;
            $this->assign('appellation',$appellation);
        }
        if(!empty($phone)){
            $where.=" and u.phone like '%".$phone."%' ";
            $parameter['phone']=$phone;
            $this->assign('phone',$phone);
        }
        $model=M('member');
        $count = $model->alias('m')
        ->join(" left join ".C('DB_PREFIX')."user u on u.id = m.user_id 
                left join ".C('DB_PREFIX')."child c on c.id = m.child_id ")
        ->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->alias('m')->field("m.*,u.name as username,c.name as childname,u.phone,c.nickname as childnickname")
        ->join(" left join ".C('DB_PREFIX')."user u on u.id = m.user_id 
                left join ".C('DB_PREFIX')."child c on c.id = m.child_id ")
        ->where($where)->order("m.id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign('list', $list);
        if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
        }  
        $this->assign("page", $page->show('Admin'));
        $this->display();
     }

     public function addmember(){
        //查询孩子
        $child=M("child")->select();
        $this->assign("child",$child);
        $users=M("user")->select();
        $this->assign("users",$users);

        $this->display();
     }

     public function addmember_post(){
        if(empty($_POST['child_id'])){
            $this->error("请选择孩子");
        }
        if(empty($_POST['user_id'])){
            $this->error("请选择用户");
        }
        if(empty($_POST['appellation'])){
            $this->error("请填写称呼");
        }
        if(IS_POST){
            if (M("member")->create()!==false){
                if (M("member")->add()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("classification/member"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("member")->getError());
            }
        
        }
     }

     public function editmember(){
        $child=M("child")->select();
        $this->assign("child",$child);
        $users=M("user")->select();
        $this->assign("users",$users);
        $res=M("member")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
     }

     public function editmember_post(){
        if(empty($_POST['child_id'])){
            $this->error("请选择孩子");
        }
        if(empty($_POST['user_id'])){
            $this->error("请选择用户");
        }
        if(empty($_POST['appellation'])){
            $this->error("请填写称呼");
        }
        if(IS_POST){
            if (M("member")->create()!==false){
                if (M("member")->save()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("classification/member"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("member")->getError());
            } 
        }
     }

     public function relation_user(){
        //查询用户
        $type=$_REQUEST['type'];
        $this->assign("type",$type);
        $child_id=$_REQUEST['child_id'];
        if($child_id){
            $this->assign("child_id",$child_id);
        }
        $where="1=1";
        $name=$_REQUEST['name'];
        $phone=$_REQUEST['phone'];
        if(!empty($name)){
            $where.=" and name like '%".$name."%' ";
            $parameter['name']=$name;
            $this->assign("name",$name);
        }
        if(!empty($phone)){
            $where.=" and phone like '%".$phone."%' ";
            $parameter['phone']=$phone;
            $this->assign("phone",$phone);
        }
        $count = M("user")->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $user_list=M("user")->where($where)->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
        if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
        }
        $this->assign("page",$page->show("Admin"));
        $this->assign("user_list",$user_list);
        $this->display();

     }

     public function teachertype(){
        $count=M("teacher_type")->count();
        $page = $this->page($count,C('PAGENUM'));
        $list=M('teacher_type')->order("index_id ASC")->limit($page->firstRow . ',' . $page->listRows)->select();
        $this->assign("list",$list);
        $this->assign("page",$page->show("Admin"));
        $this->display();
     }

     public function addteachertype(){
        $this->display();
     }
     public function addteachertype_post(){
        if(empty($_POST['title'])){
            $this->error("教师类型不能为空");
        }
        if(empty($_POST['index_id'])){
            $_POST['index_id']=99;
        }
        $is_exist=M("teacher_type")->where(" title = '".$_POST['title']."' ")->find();
        if(!empty($is_exist)){
            $this->error("教师类型已存在");
        }
        if(IS_POST){
            $_POST['createtime']=date("Y-m-d H:i:s");
            if (M("teacher_type")->create()!==false){
                if (M("teacher_type")->add()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("classification/teachertype"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("teacher_type")->getError());
            } 
        }
     }
     public function editaddteachertype(){
        $res=M("teacher_type")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
     }
     public function editteachertype_post(){
        if(empty($_POST['title'])){
            $this->error("教师类型不能为空");
        }
        if(empty($_POST['index_id'])){
            $_POST['index_id']=99;
        }
        $is_exist=M("teacher_type")->where(" title = '".$_POST['title']."' ")->find();
        if(!empty($is_exist)){
            $this->error("教师类型已存在");
        }
        if(IS_POST){
            if (M("teacher_type")->create()!==false){
                if (M("teacher_type")->save()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("classification/teachertype"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("teacher_type")->getError());
            } 
        }
     }
     public function deleteteachertype(){
        $id = I("get.id",0,"intval");
        if (M('teacher_type')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
     }

     public function teachertypeorder(){
        $listorders=$_POST['listorders'];
        //遍历取值
        if($listorders){
            foreach ($listorders as $k => $v) {
                //$k为需要修改的id，$v为修改的值
                if($k&&($v||$v=='0')){
                    //存在才修改
                    $data="";//初始化
                    $data['id']=$k;
                    $data['index_id']=$v;
                    M("teacher_type")->save($data);
                }
            }
        }
        $this->success("排序成功");
     }
}

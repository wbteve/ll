<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;
use Think\Log;
class LoginController  extends PublicController {
    /**
     * 用户登录
     */
    public function login()
    {
        $phone = $_REQUEST['phone'];
        $password = md5($_REQUEST['password']);
        $clientUUID = $_REQUEST['uuid'];
        if (empty($phone) || empty($password)) {
             $this->emptyResult();
        }
        $model = M("user");
        $is_account=$model->where("phone = '$phone'")->find();
        if(empty($is_account)){
            $msg = array(
                "code" => 105,
                "msg" => "账号不存在"
            );
            echo json_encode($msg);
            $this->remove_boms();
            exit();
        } 
        
            $user = $model->where("phone='$phone' and password='$password'")->find();
            if (empty($user)) {
                $msg = array(
                    "code" => 201,
                    "msg" => '账号或密码错误',
                );
                echo json_encode($msg);
                exit;
            }
       
        $result['last_login_time']=date("Y-m-d H:i:s");
        $model->where("phone='$phone' and password='$password'")->save($result);
       
       
        //获取token
        $token = $this->getUserToken($clientUUID, $phone);
        $msg = array(
            "code" => 101,
            "msg" => '登录成功',
            "token" => $token,
            "data" => $user,
        );
        echo json_encode($msg);
        exit();
    }
    //获取积分记录接口
    function getscorelist(){
        $token=$_REQUEST['token'];
        $userid=$_REQUEST['user_id'];
        $this->checkAccess($token);
        //积分记录
        $res=M('integral')->where('user_id = '.$userid)->select();
        if(!res){
            $msg = array(
                "code" => 202,
                "msg" => '获取数据失败',
            );
            echo json_encode($msg);
            exit();
        }
        $msg = array(
            "code" => 101,
            "msg" => '获取数据成功',
            "data" => $res,
        );
        echo json_encode($msg);
        exit();
    }
}
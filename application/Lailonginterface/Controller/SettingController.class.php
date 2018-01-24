<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;

class SettingController  extends PublicController {
    public function updatephoneorpwd(){
        $token=$_REQUEST['token'];
        $userid=$this->checkAccess($token);
        $oldpwd=$_REQUEST['oldpwd'];
        $phone=$_REQUEST['phone'];
        $newpwd=$_REQUEST['newpwd'];
        //判断密码
        $u=M('user')->field("password")->where("id = $userid")->find();
        if($u['password'] != md5($oldpwd)){
            $this->errorResult("账户密码不匹配，无法修改");
        }
        if(!empty($phone)){
            $code=$_REQUEST['code'];
            //判断手机号是否存在
            $count=M('user')->where("phone = '$phone'")->count();
            if($count >0){
                $this->errorResult("此手机号为当前绑定手机号");
            }
            $count=M('sms')->where("phone = '$phone' and code = '$code'")->count();
            if($count<=0){
                $this->errorResult("验证码不正确，无法修改");
            }
            M('user')->where("id = $userid")->save(array('phone'=>$phone));
                $this->successShortResult("修改手机号成功");
        }
        if(!empty($newpwd)){
            $repwd=$_REQUEST['repwd'];
             
            if($u['password'] == md5($newpwd)){
                $this->errorResult("修改密码不能与原密码相同");
            }
            if($newpwd != $repwd){
                $this->errorResult("两次密码不一致");
            }
            M('user')->where("id = $userid")->save(array('password'=>md5($newpwd)));
            $this->successShortResult("修改密码成功");
        }
    }
}
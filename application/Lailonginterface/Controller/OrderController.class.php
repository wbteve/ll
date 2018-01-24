<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;

class OrderController  extends PublicController {
    /**
     * 生成订单
     */
    public function makeorder()
    {
       $token=$_REQUEST['token'];
       $userid=$this->checkAccess($token);
       $child=$_REQUEST['child_id']; 
       $course_id=$_REQUEST['course_id'];
       $note=$_REQUEST['note'];
       if( empty($course_id) || empty($child) || $child==0 || $course_id==0){
           $this->emptyResult();
       }
       $p=M('course')->field("integral")->where("id = '$course_id'")->find();
       $enr=M('enrollment')->where("course_id = $course_id and user_id = $userid and child_id=$child and state =0")->find();
       if($enr){
           $this->errorResult2($enr[id]);
       } 
       $result=M('enrollment')->where("course_id = $course_id and user_id = $userid and child_id=$child and state =1")->find();
       if($result){
           $this->errorResult2($result[id]);
       } 
          
       $data=array('order_id'=>'lailong'.uniqid(),'child_id'=>$child,'state'=>0,'course_id'=>$course_id,'user_id'=>$userid,'note'=>$note,'createtime'=>date('Y-m-d H:i:s',time()),'integral'=>$p[integral]);
       $res=M('enrollment')->add($data);
        if($res){
            $param=array('enrollment_id'=>$res,'state'=>0,'state_text'=>"订单已提交",'createtime'=>date('Y-m-d H:i:s',time()));
            M('enrollment_state')->add($param);
            //$res=M('course')->where("id = $course_id")->find();
            
            $this->successLongResult($res,'生成订单成功');
        }else{
            $this->errorResult("生成订单失败");
        }
    }
     /**
     * 向报名未支付订单插入孩子
     */
   /* public function getnopayorder(){
        $token=$_REQUEST['token'];
        $this->checkAccess($token);
        $orderid=$_REQUEST['order_id'];
        $child=$_REQUEST['child'];
        if($orderid == 0){
            $this->emptyResult();
        }
        M('enrollment')->where("id = $orderid")->save(array('child_id'=>$child));
        $this->successShortResult("操作成功");
    } */
    /**
     * 获取学生列表
     */
    public function getstudentlist(){
        $token=$_REQUEST['token'];
        $user_id=$this->checkAccess($token);
        $res=M('child')->field("m.*")->table(C('DB_PREFIX').'child as m ')->join(C('DB_PREFIX')."member as c on c.child_id = m.id",'left')->where("c.user_id = $user_id")->select();
        foreach($res as $r=>$rs){
           $res[$r][avatar] = __ROOT__.'/data/upload/avatar/'.$rs[avatar];
        }
        if($res){
            $this->successLongResult($res, "获取学生列表成功");
        }else{
            $this->errorResult("未获取到学生列表");
        }
    }
    /**
     * 获取选择学生
     */
    public function findstudent(){
        $token=$_REQUEST['token'];
        $this->checkAccess($token);
        $child=$_REQUEST['child'];
        $c=M('Child')->field("id,name")->where("id = $child")->find();
        if($c){
            $this->successLongResult($c, "获取学生id成功");
        }else{
            $this->errorResult("未获取到学生id");
        }
    }
    /**
     * 取消订单
     */
    public function cancelorder(){
        $token=$_REQUEST['token'];
        $this->checkAccess($token);
        $content=$_REQUEST['content'];
        $orderid=$_REQUEST['orderid'];
        if(empty($content)){
            $this->emptyResult();
        }
        $e=M('enrollment')->field("state")->where("id = $orderid")->find();
        if($e[state] ==4){
            $this->successShortResult("订单已取消");
            exit();
        }
        if(M('enrollment')->where("id = $orderid")->save(array('cancel_state'=>1,'note'=>$e[note].'|订单取消中，取消理由为：'.$content))){
            
            $this->successShortResult("订单提交取消申请");
        }else{
            $this->errorResult("订单无法取消");
        }
    }
    /**
     * 意见反馈表
     */
    public function feedback(){
        $token=$_REQUEST['token'];
        $user=$this->checkAccess($token);
        $content=$_REQUEST['content'];
        if(empty($content)){
            $this->emptyResult();
        }
        if(M('feedback')->add(array('user_id'=>$user,'content'=>$content,createtime=>date('Y-m-d H:i:s',time())))){
            $this->successShortResult("反馈成功");
        }else{
            $this->errorResult("反馈失败");
        }
    }
}
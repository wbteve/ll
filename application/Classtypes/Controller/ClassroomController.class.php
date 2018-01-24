<?php

namespace Classtypes\Controller;
use Common\Controller\AdminbaseController;
class ClassroomController extends AdminbaseController {
	function _initialize() {
	}
     public function classroomlist(){
         $where= "1=1";
         $title=$_REQUEST['title'];
         $phone=$_REQUEST['phone'];
         $address=$_REQUEST['address'];
         $startctime=$_REQUEST['startctime'];
         $endctime=$_REQUEST['endctime'];

         if(!empty($title)){
            $where.=" and title like '%".$title."%' ";
            $parameter['title']=$title;
            $this->assign('title',$title);
         }
         if(!empty($phone)){
            $where.=" and phone like '%".$phone."%' ";
            $parameter['phone']=$phone;
            $this->assign('phone',$phone);
         }
         if(!empty($address)){
            $where.=" and address like '%".$address."%' ";
            $parameter['address']=$address;
            $this->assign('address',$address);
         }
         if(!empty($startctime)){
            $where.=" and ctime >= '".$startctime."' ";
            $parameter['startctime']=$startctime;
            $this->assign('startctime',$startctime);
         }
         if(!empty($endctime)){
            $where.=" and ctime <= '".$endctime."' ";
            $parameter['endctime']=$endctime;
            $this->assign('endctime',$endctime);
         }
         $model = M ("classroom");
         $count = $model->where($where)->count();
         $page = $this->page($count, C('PAGENUM'));
         $list = $model->where($where)->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
         $this->assign('list', $list);
         if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
         } 
         $this->assign("page", $page->show('Admin'));
         $this->display();
     }
     public function add(){
        $this->display();
     }
     public function add_post(){
        if(empty($_POST['title'])){
            $this->error("教室名字不能为空");
        }
        if(empty($_POST['address'])){
            $this->error("地址不能为空");
        }
        if(empty($_POST['phone'])){
            $this->error('联系人手机号不能为空');
        }else{
            if(preg_match("/^((\d{3}-\d{8}|\d{4}-\d{7,8})|(1[3|4|5|7|8][0-9]{9}))$/",$_POST['phone'])){

            }else{
              $this->error("手机号格式不对");
            }
        }
        
      
            if(IS_POST){
                $_POST['ctime']=date("Y-m-d H:i:s");
                if (M("classroom")->create()!==false){
                    if (M("classroom")->add()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Classroom/classroomlist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("classroom")->getError());
                }
        
            }
       
        
     }
     public function edit(){
        $res=M("classroom")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
     }
     public function edit_post(){
        if(empty($_POST['title'])){
            $this->error("教室名字不能为空");
        }
        if(empty($_POST['address'])){
            $this->error("地址不能为空");
        }
        if(empty($_POST['phone'])){
            $this->error('联系人手机号不能为空');
        }else{
            if(preg_match("/^((\d{3}-\d{8}|\d{4}-\d{7,8})|(1[3|4|5|7|8][0-9]{9}))$/",$_POST['phone'])){

            }else{
              $this->error("手机号格式不对");
            }
        }
            if(IS_POST){
                if (M("classroom")->create()!==false){
                    if (M("classroom")->save()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Classroom/classroomlist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("classroom")->getError());
                }
            }
     }
     public function delete(){
        $id = I("get.id",0,"intval");
        if (M('classroom')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}

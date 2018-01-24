<?php

namespace Other\Controller;
use Common\Controller\AdminbaseController;
class EncourageConfigController extends AdminbaseController {
	function _initialize() {
	}
    /**
     * 积分配置列表
     */
    public function encourageconfiglist() {
        
        $model = M ("encourage_config");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
       	$this->display();
    }
    //添加积分配置
     public function add(){
         $this->display();
     }
     public function add_post(){
         if(empty($_POST['integral'])){
            $this->error("积分数量不能为0");
         }
         //判断是否存在了
         $is_exist=M('encourage_config')->where(" type = ".$_POST['type'])->find();
         if($is_exist){
            $this->error("所选类型已存在");
         }
         if(IS_POST){
                
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("encourage_config")->create()!==false){
                    if (M("encourage_config")->add()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("EncourageConfig/encourageconfiglist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("encourage_config")->getError());
                }
        
            }
     }

     public function edit(){
        $res=M("encourage_config")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
     }

    public function edit_post(){
        if(empty($_POST['integral'])){
            $this->error("积分数量不能为0");
        }
        $is_exist=M('encourage_config')->where(" type = ".$_POST['type']." and id != ".$_POST['id'])->find();
         if($is_exist){
            $this->error("所选类型已存在");
         }
        if(IS_POST){
                
            $_POST['createtime']=date("Y-m-d H:i:s");
            if (M("encourage_config")->create()!==false){
                if (M("encourage_config")->save()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("EncourageConfig/encourageconfiglist"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("encourage_config")->getError());
            }
        
        }
    }
    public function delete(){
        if(M('encourage_config')->where("id = $_REQUEST[id]")->delete()){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
}

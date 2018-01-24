<?php

namespace Classtypes\Controller;
use Common\Controller\AdminbaseController;
class TextbookController extends AdminbaseController {
	function _initialize() {
	}
     public function textbooklist(){
         $where= "1=1";
         $subject=$_REQUEST['subject'];
         $press=$_REQUEST['press'];
         $grade=$_REQUEST['grade1'];
         if(!empty($subject)){
            $where.=" and subject like '%".$subject."%' ";
            $parameter['subject']=$subject;
            $this->assign('subject',$subject);
         }
         if(!empty($press)){
            $where.=" and press like '%".$press."%' ";
            $parameter['press']=$press;
            $this->assign('press',$press);
         }
         if(!empty($grade)){
            $where.=" and grade like '%".$grade."%' ";
            $parameter['grade1']=$grade;
            $this->assign('grade',$grade);
         }

         $model = M ("textbook");
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
     public function addtextbook(){
        //表结构不变，然后只是获取方式更换
        $subject=M('subject')->select();
        $this->assign('subject',$subject);
        $press=M('press')->select();
        $this->assign('press',$press);
        $grade=M('grade')->select();
        $this->assign('grade',$grade);
        $this->display();
     }
     //逻辑重写
     public function add_post(){
        if(empty($_POST['subject'])){
            $this->error("科目不能为空");
        }
        if(empty($_POST['press'])){
            $this->error("出版社不能为空");
        }
        if(empty($_POST['grade'])){
            $this->error("学段不能为空");
        }
        if(IS_POST){
            $textbook['subject']=$_POST['subject'];
            $textbook['press']=$_POST['press'];
            $textbook['grade']=$_POST['grade'];
            $textbook['updatetime']=date("Y-m-d H:i:s");
            $textbook['createtime']=date("Y-m-d H:i:s");
            if(M("textbook")->add($textbook)!==false){
                unset($_POST['subject']);
                unset($_POST['press']);
                unset($_POST['grade']);
                $datax=$_POST;
                if(empty($datax)){
                    $this->success("操作成功", U("Textbook/textbooklist"));
                }else{
                    $datax['t_id'] = M('textbook')->getLastInsID();
                    $this->add_chapter($datax);
                }
                

            }else{
                $this->error("添加教科书失败");
            }
            
        
        }else{
            $this->error("操作失败");
        }
     }
     public function edittextbook(){
        //展示章节内容
        $t_id=$_REQUEST['editid'];
        $zhang=M('chapter')->where(" textbook_id =  ".$t_id." and parent_id = 0 ")->order("id ASC")->select();
        if($zhang){
            foreach ($zhang as $k => $v) {
                if($v){
                    $zhang[$k]['jie']=M('chapter')->where(" textbook_id = ".$t_id." and parent_id = ".$v['id'])->order("id ASC")->select();
                }
            }
        }
        $this->assign('zhang',$zhang);
        $res=M("textbook")->where("id = $_REQUEST[editid]")->find();
        $this->assign('res',$res);
        $subject=M('subject')->select();
        $this->assign('subject',$subject);
        $press=M('press')->select();
        $this->assign('press',$press);
        $grade=M('grade')->select();
        $this->assign('grade',$grade);
        $this->display();
     }
     public function edit_post(){
        if(empty($_POST['subject'])){
            $this->error("科目不能为空");
        }
        if(empty($_POST['press'])){
            $this->error("出版社不能为空");
        }
        if(empty($_POST['grade'])){
            $this->error("学段不能为空");
        }
        if(empty($_POST['t_id'])){
            $this->error("数据错误");
        }
        if(IS_POST){
            $subject=$_POST['subject'];
            $press=$_POST['press'];
            $grade=$_POST['grade'];
            $textbook['id']=$_POST['t_id'];
            $textbook['subject']=$subject;
            $textbook['press']=$press;
            $textbook['grade']=$grade;
            $textbook['updatetime']=date("Y-m-d H:i:s");
            if(M("textbook")->save($textbook)!==false){
                
                unset($_POST['subject']);
                unset($_POST['press']);
                unset($_POST['grade']);
                $datax=$_POST;
                //var_dump($datax);die;
                if(empty($datax)){
                    $this->success("操作成功", U("Textbook/textbooklist"));
                }else{
                    
                    $this->add_chapter($datax);
                }
            }else{
                $this->error("操作失败");
            }
        }
     }
     public function deletetextbook(){
        $id = I("get.id",0,"intval");
        if (M('textbook')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
     function add_chapter($datax){
        //出现问题，需要重新看一下啊数据
        //没问题了
        //数据处理
        $textbook_id=$datax['t_id'];//获取textbook_id
        //$textbook_id=1;//懒得刷新了
        if(empty($textbook_id)){
            $this->error("数据异常，请重试");
        }
        $i=$datax['i'];//判断章的数量//用途还没想好//似乎没什么用吧？暂时。废话一会//有用的，节的数字对应章，//没用= =//判断是否数据有误吧？//检查使用的吧//似乎需要这个数字了，//试试给zhang也打个标记符
        //重写//用处来了，可以判断循环多少次
        M("chapter")->where(" textbook_id = ".$textbook_id)->delete();
        for($j=0;$j<=$i;$j++){
            $zhang="";//初始化
            $zhang=$datax['zhang'.$j];
            if(!empty($zhang)){
                //初始化一下对下面使用过的
                $data="";
                $num="";
                $jie="";
                $parent_id="";
                $data['title']=$zhang;
                $data['parent_id']=0;//表示章
                $data['textbook_id']=$textbook_id;
                $data['createtime']=date("Y-m-d H:i:s");
                M('chapter')->add($data);
                $parent_id= M('chapter')->getLastInsID();
                //出错概率很小的吧？//就不做判断了
                $jie=$_POST['jie'.$j];
                if($jie){
                    foreach ($jie as $key => $value) {
                        if(!empty($value)){
                            //初始化一下
                            $data1="";
                            $data1['title']=$value;
                            $data1['parent_id']=$parent_id;
                            $data1['textbook_id']=$textbook_id;
                            $data1['createtime']=date("Y-m-d H:i:s");
                            M('chapter')->add($data1);
                        }
                        
                        //应该录入完成了吧？//可能展示页需要修改一下
                    }
                }
            }
        }
            $this->success("操作成功", U("Textbook/textbooklist"));
    }
}

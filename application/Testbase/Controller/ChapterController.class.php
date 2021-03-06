<?php

namespace Testbase\Controller;
use Common\Controller\AdminbaseController;
class ChapterController extends AdminbaseController {
	function _initialize() {
	}
     public function chapterlist(){
        //书名
        $textbook=M('textbook')->select();
        $this->assign('textbook',$textbook);
         $where= "1=1";
         $title=$_REQUEST['title'];
         $textbook_id=$_REQUEST['textbook_id'];
         $is_chapter=$_REQUEST['is_chapter'];
         if(!empty($title)){
            $where.=" and c.title like '%".$title."%' ";
            $parameter['title']=$title;
            $this->assign('title',$title);
         }
         if(!empty($is_chapter)){
            //1为章，2为节
            if($is_chapter=='1'){
                $where.=" and c.parent_id = '0' ";
            }elseif($is_chapter=='2'){
                $where.=" and c.parent_id != '0' ";
            }
            $parameter['is_chapter']=$is_chapter;
            $this->assign('is_chapter',$is_chapter);
         }
         if(!empty($textbook_id)){
            $where.=" and c.textbook_id = ".$textbook_id;
            $parameter['textbook_id']=$textbook_id;
            $this->assign('textbook_id',$textbook_id);
         }
         $model = M ("chapter");
         $count = $model->alias('c')
         ->join(" left join ".C('DB_PREFIX')."textbook t on t.id=c.textbook_id left join ".C("DB_PREFIX")."chapter c2 on c2.parent_id = c.id ")
         ->where($where)->count();
         $page = $this->page($count, C('PAGENUM'));
         $list = $model->alias('c')
         ->field("c.*,c2.title as parent_title,t.subject,t.press,t.grade ")
         ->join(" left join ".C('DB_PREFIX')."textbook t on t.id=c.textbook_id left join ".C("DB_PREFIX")."chapter c2 on c.parent_id = c2.id ")
         ->where($where)->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
         $this->assign('list', $list);
         if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
         } 
         $this->assign("page", $page->show('Admin'));
         $this->display();
     }
     public function addchapter(){
        //查询书
        $textbook=M('textbook')->select();
        $this->assign("textbook",$textbook);
        $this->display();
     }
     public function add_post(){
        if(empty($_POST['title'])){
            $this->error("标题不能为空");
        }
        if(empty($_POST['textbook_id'])){
            $this->error("所属书不能为空");
        }
        if(IS_POST){
            $_POST['createtime']=date("Y-m-d H:i:s");
            if (M("chapter")->create()!==false){
                if (M("chapter")->add()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("Chapter/chapterlist"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("chapter")->getError());
            }  
        }    
     }
     public function getchapter(){
        $textbook_id=$_REQUEST['textbook_id'];
        if(!empty($textbook_id)){
            $chapter=M('chapter')->field("id,title")->where(" textbook_id = ".$textbook_id." and parent_id = 0 " )->select();
            echo json_encode($chapter);
        }
     }
     public function editchapter(){
        $textbook=M('textbook')->select();
        $this->assign("textbook",$textbook);

        $res=M("chapter")->where("id = $_REQUEST[editid]")->find();
        $parent=M("chapter")->where("textbook_id = $res[textbook_id] and parent_id = 0 ")->select();
        //var_dump($parent);die;
        $this->assign("parent",$parent);
        $this->assign($res);
        $this->display();
     }
     public function edit_post(){
        if(empty($_POST['title'])){
            $this->error("标题不能为空");
        }
        if(empty($_POST['textbook_id'])){
            $this->error("所属书不能为空");
        }
        if(IS_POST){

            if (M("chapter")->create()!==false){
                if (M("chapter")->save()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("Chapter/chapterlist"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("chapter")->getError());
            }  
        } 
     }
     public function delete(){
        $id = I("get.id",0,"intval");
        if (M('chapter')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}

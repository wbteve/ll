<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;

class IntentionController  extends PublicController {
    /**
     * 填写意向
     */
    public function add()
    {
       $token=$_REQUEST['token'];
       $intention=$_REQUEST['intention'];
       $child=$_REQUEST['child'];
       $user_id=$this->checkAccess($token);
       if(empty($intention)){
           $this->emptyResult();
       }
       $data=array('user_id'=>$user_id,'content'=>$intention,'child_id'=>$child,'createtime'=>date('Y-m-d H:i:s',time()));
       if(M('intention')->add($data)){
           $this->successShortResult("提交意向成功");
       }else{
           $this->errorResult("提交意向失败");
       }
    }
    /**
     * 意向选择
     */
    public function addforchose()
    {
        $token=$_REQUEST['token'];
        $child_id=$_REQUEST['child_id'];
        $grade=$_REQUEST['grade'];
        $press=$_REQUEST['press'];
        $subject=$_REQUEST['subject'];
        $chapter=$_REQUEST['chapter'];
        $sub_chapter=$_REQUEST['sub_chapter'];
        $question_type=$_REQUEST['question_type'];
        $question_difficulty=$_REQUEST['question_difficulty'];
        $topic_set=$_REQUEST['topic_set'];
        $wanted_start_time=$_REQUEST['wanted_start_time'];
        $teacher=$_REQUEST['teacher'];
        $class_type=$_REQUEST['class_type'];
        $user_id=$this->checkAccess($token);
        if( empty($child_id) || empty($subject)){
            $this->emptyResult();
        }
        $data=array(
            'user_id'=>$user_id,
            'child_id'=>$child_id,
            'grade'=>$grade,
            'press'=>$press,
            'subject'=>$subject,
            'chapter'=>$chapter,
            'sub_chapter'=>$sub_chapter,
            'question_type'=>$question_type,
            'question_difficulty'=>$question_difficulty,
            'topic_set'=>$topic_set,
            'wanted_start_time'=>$wanted_start_time,
            'teacher'=>$teacher,
            'class_type'=>$class_type,
            'createtime'=>date("Y-m-d H:i:s",time())
        );
        if(M('intention')->add($data)){
            $this->successShortResult("提交意向成功");
        }else{
            $this->errorResult("提交意向失败");
        }
    }
   /*  //获取学段
    public function getgrade(){
        $token=$_REQUEST['token'];
        $user_id=$_REQUEST['user_id'];
        if(M('grade'))
    } */
}
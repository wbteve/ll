<?php
namespace Collection\Controller;
use Common\Controller\AdminbaseController;

class CollectionController  extends AdminbaseController {
    /**
     * 收藏管理列表
     */
    public function collectionlist(){
      $search=$_REQUEST['search'];

      $where = "1=1";
      $uname=$_REQUEST['uname1'];
      $uphone=$_REQUEST['uphone'];
      $ctitle=$_REQUEST['ctitle'];
      $startcreatetime=$_REQUEST['startcreatetime'];
      $endcreatetime=$_REQUEST['endcreatetime'];
        if(!empty($uname)){
          $where.=" and u.name like '%".$uname."%' ";
          $parameter['uname1']=$uname;
          $this->assign('uname',$uname); 
        }
        if(!empty($startcreatetime)){
          $where.=" and c.createtime >= '".$startcreatetime."' ";
          $parameter['startcreatetime']=$startcreatetime;
          $this->assign('startcreatetime',$startcreatetime);
        }
        if(!empty($endcreatetime)){
          $where.=" and c.createtime <= '".$endcreatetime."' ";
          $parameter['endcreatetime']=$endcreatetime;
          $this->assign('endcreatetime',$endcreatetime);
        }
        if(!empty($uphone)){
          $where.=" and u.phone like '%".$uphone."%' ";
          $parameter['uphone']=$uphone;
          $this->assign('uphone',$uphone); 
        }
        if(!empty($ctitle)){
          $where.=" and cc.title like '%".$ctitle."%' ";
          $parameter['ctitle']=$ctitle;
          $this->assign('ctitle',$ctitle);
        }

      $count=M("collection")->alias('c')->join(' left join '.C('DB_PREFIX').'user as u on c.user_id=u.id left join '.C('DB_PREFIX').'course as cc on cc.id = c.course_id ')
            ->where($where)->count();
      $page = $this->page($count, C('PAGENUM'));
      $list = M("collection")->alias('c')
          ->field("c.*,u.name as uname,u.phone as uphone,u.integral as uintegral,cc.integral as cintegral,cc.title as ctitle")
          ->join(' left join '.C('DB_PREFIX').'user as u on c.user_id=u.id left join '.C('DB_PREFIX').'course as cc on cc.id = c.course_id ')
          ->where($where)
          ->order("c.id DESC")
          ->limit($page->firstRow, $page->listRows)
          ->select();
          if($parameter){
            foreach ($parameter as $key => $value) {
              $page->parameter .= "$key=".urlencode($value)."&";
            }
          }
         // var_dump($page->show("Admin"));die;
    $this->assign("page", $page->show("Admin"));
    $this->assign("list",$list);
    $this->display();



  }

}
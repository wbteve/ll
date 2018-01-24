<?php
namespace Users\Controller;
use Common\Controller\AdminbaseController;

class LoginrecordController  extends AdminbaseController {
    /**
     * 登陆记录列表
     */
    public function loginrecordlist(){
      $search=$_REQUEST['search'];

      $where = "1=1";
      $uname=$_REQUEST['uname1'];
      $phone=$_REQUEST['phone'];
      $app_version=$_REQUEST['app_version'];
      $device_name=$_REQUEST['device_name'];
 
          
            $this->assign('uname',$uname);
            if(!empty($_REQUEST['startlogin_time'])){
                $startlogin_time=strtotime($_REQUEST['startlogin_time']);
                $this->assign('startlogin_time',$startlogin_time);
            }
            if(!empty($_REQUEST['endlogin_time'])){
                $endlogin_time=strtotime($_REQUEST['endlogin_time']);
                $this->assign('endlogin_time',$endlogin_time);
            }
        if(!empty($uname)){
          $where.=" and u.name like '%".$uname."%' ";
          $parameter['uname1']=$uname;
        }
        if(!empty($startlogin_time)){
          $where.=" and lr.login_time >= '".$startlogin_time."' ";
          $parameter['startlogin_time']=$startlogin_time;
        }
        if(!empty($endlogin_time)){
          $where.=" and lr.login_time <= '".$endlogin_time."' ";
          $parameter['endlogin_time']=$endlogin_time;
        }
        if(!empty($phone)){
          $where.=" and u.phone like '%".$phone."%' ";
          $parameter['phone']=$phone;
          $this->assign('phone',$phone);
        }
        if(!empty($app_version)){
          $where.=" and lr.app_version like '%".$app_version."%' ";
          $parameter['app_version']=$app_version;
          $this->assign('app_version',$app_version);
        }
        if(!empty($device_name)){
          $where.=" and lr.device_name like '%".$device_name."%' ";
          $parameter['device_name']=$device_name;
          $this->assign('device_name',$device_name);
        }

      $count=M("login_record")->alias('lr')->join(' left join '.C('DB_PREFIX').'user as u on lr.user_id=u.id ')
            ->where($where)->count();
      $page = $this->page($count, 20);
      $loginrecordlist = M("login_record")->alias('lr')
          ->field("lr.*,u.phone,u.id as uid ,u.name as uname,u.recommended_person,u.integral")
          ->join(' left join '.C('DB_PREFIX').'user as u on lr.user_id=u.id ')
          ->where($where)
          ->order("login_time DESC")
          ->limit($page->firstRow, $page->listRows)
          ->select();
          //var_dump($parameter);die;
          if($parameter){
            foreach ($parameter as $key => $value) {
              $page->parameter .= "$key=".urlencode($value)."&";
            }
          }
    $this->assign("page", $page->show('Admin'));
    $this->assign("loginrecordlist",$loginrecordlist);
    $this->display();



  }

}
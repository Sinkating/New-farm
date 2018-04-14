<?php
namespace Home\Controller;
use Think\Controller;
class AddressController extends AllowController {
    public function index(){
    }

    public function chooadres(){
        $address=M("address");
        $where['uid']=$_SESSION['uid'];
        $list=$address->where($where)->field()->select();
        $this->assign("list",$list);
        $this->display('ChooAdres');
    }

    public function address(){
        $this->display('address');
    }

    public function addAddr(){
        $address=M("address");
        $data['username']=$_POST['user'];
        $data['telphone']=$_POST['phone'];
        $data['place']=$_POST['adress'];
        $data['address']=$_POST['city'];
        $data['uid']=$_SESSION['uid'];
        $data['choose']='0';
        $data['uptime']=date("Y-m-d H:i:s");
        $res=$address->data($data)->add();
        if($res){
            $response = array(
                'resultCode'  => 200, 
                'message' => 'success for request',
                'data'  => $res,
            ); 
            $this->ajaxReturn($response,'json');
        }  
    }

    public function DelAddr(){
        $address=M("address");
        $where['id']=$_POST['addrid'];
        $choose=$_POST["choose"];
        if($choose==0){
            $res=$address->where($where)->delete();
            if($res){
                $response = array(
                    'resultCode'  => 200, 
                    'message' => 'success for request',
                    'data'  => $res,
                ); 
            }
        }elseif($choose==1){
            $response = array(
                'resultCode'  => 300, 
                'message' => '默认地址不能删除',
            ); 
        }
        $this->ajaxReturn($response,'json');
        }   

    public function EditAddr(){
        $address=M("address");
        $where['id']=$_POST['addrid'];
        $data['username']=$_POST['user'];
        $data['telphone']=$_POST['phone'];
        $data['place']=$_POST['adress'];
        $data['address']=$_POST['city'];
        $data['uptime']=date("Y-m-d H:i:s");
        $res=$address->where($where)->data($data)->save();
        if($res){
            $response = array(
                'resultCode'  => 200, 
                'message' => 'success for request',
                'data'  => $res,
            ); 
            $this->ajaxReturn($response,'json');
        }  
    }

    public function IsChoose(){
        $address=M("address");
        $where['id']=$_POST['addrid'];
        $info['uid']=$_SESSION['uid'];
        $data1['choose']='0';
        $data2['choose']='1';
        $address->startTrans();//开始事务处理
        $res1=$address->where($info)->data($data1)->save();
        $res2=$address->where($where)->data($data2)->save();
        if($res2){
            $address->commit();
            $response = array(
                'resultCode'  => 200, 
                'message' => 'success for request',
            ); 
            $this->ajaxReturn($response,'json');
        } else{
            $address->rollback();
        } 
    }

    public function eAddr(){
        $address=M("address");
        $where['id']=$_GET['data'];
        $info=$address->where($where)->find();
        $this->assign("info",$info);
        $this->display('editaddr');
    }


}
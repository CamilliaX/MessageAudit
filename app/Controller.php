<?php
/**
**控制器
**/
class Controller
{
	protected $_model;
    public function __construct()
    {
    	$this->_model=new Sql();
    	//数据库配置
    	$db_user='root';
    	$db_pwd='toor';
    	$db_table='test1';
    	$this->_model->connect('localhost',$db_user,$db_pwd,$db_table);
    	session_start();
    	$this->route();
    	$this->show();
    }
    //路由分发
    public function route(){
    	$action=isset($_GET['action'])?$_GET['action']:'none';
    	switch ($action) {
    		case 'add':
    			$this->add();
    			break;
    		case 'delete':
    			$this->delete();
    			break;
    		case 'pass':
    			$this->pass();
    			break;
    		case 'login':
    			$this->login();
    			break;
    	    case 'loginout':
    	    	$this->loginout();
    	    	break;
    		default:
    			# code...
    			break;
    	}
    }
 //视图显示
    public function show(){
    	$this->_model->table='message';
        $this->_model->select(['*']);
        if(!$this->is_login()){
        	$this->_model->where(['view=1']);
        }
    	$message=$this->_model->order(['id desc'])->fetch_all();
    	include 'view.php';
    }
 //用户相关
	private function is_login()
	{
		if(isset($_SESSION['user_id'])){
			return 1;
		}
		else
		{
			return 0;
		}
	}
	private function check_login()
	{
		if(!$this->is_login())
			{
				$this->message("请先登录！");
				exit();
			}
	}
	protected function login()
	{
	
		    if(isset($_GET['name'])&&isset($_GET['pwd']))
			{
				$this->_model->table='user';
				$user=$this->_model->select(['*'])->where(["name='".$_GET['name']."'","AND pwd='".$_GET['pwd']."'"])->fetch_row();
				if($user)
				{
					$_SESSION['user_id']=$user['id'];
					$_SESSION['user_name']=$user['name'];
					$this->message("登陆成功");
				}else{
				$this->message("密码或者用户名错误，请重新登陆");
			}
			}
	}
    protected function loginout()
    {
		$this->check_login();
		unset($_SESSION['user_id']);
		unset($_SESSION['user_name']);
		$this->message("注销成功！");
	}
//留言相关
	public function add(){
		//插入留言
		$data=array(
			'user_name'=>$_GET['user'],
			'view'=>'0',
			'date'=>date("Y-m-d"),
			'content'=>$_GET['content']
		);
		$this->_model->table='message';
		if($this->_model->add($data)){
			$this->message('留言成功');
		}else{
			$this->message('失败请重试');
		}
	}
	public function delete(){
		if(!$this->is_login()){
			$this->message('没有权限');
			exit();
		}
		$this->_model->table='message';
		if($this->_model->delete()->where(['id='.$_GET['id']])->performance()){
			$this->message('删除成功');
		}else{
			$this->message('失败请重试');
		};
	}
	public function pass(){
		if(!$this->is_login()){
			$this->message('没有权限');
			exit();
		}
		$this->_model->table='message';
		$data=array(
            'view'=>'1'
		);
		if($this->_model->updata($data," id='".$_GET['id']."'")){
			$this->message('审核成功');
		}else{
			$this->message('失败请重试');
		}
	}
	public function message($link){
		echo '<script>alert("'.$link.'");</script>';
		echo "<script>window.location.href=\"index.php\";</script>";
	}
}
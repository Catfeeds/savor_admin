<?php
/**
 * @desc   小程序用户公开资源
 * @author zhang.yingtao
 *
 */
namespace Admin\Model\Smallapp;
use Think\Model;
use Common\Lib\Page;
class PublicModel extends Model
{
	protected $tableName='smallapp_public';
	public function addInfo($data,$type=1){
	    if($type==1){
	        $ret = $this->add($data);
	         
	    }else {
	        $ret = $this->addAll($data);
	    }
	    return $ret;
	}
	public function updateInfo($where,$data){
	    $ret = $this->where($where)->save($data);
	    return $ret;
	}
	public function getWhere($fields,$where,$order,$limit,$group){
	    $data = $this->field($fields)->where($where)->order($order)->group($group)->limit($limit)->select();
	    return $data;
	}
	public function getOne($fields,$where,$order){
	    $data =  $this->field($fields)->where($where)->order($order)->find();
	    return $data;
	}
	public function countNum($where){
	    $nums = $this->where($where)->count();
	    return $nums;
	}
	public function getList($fields="a.id",$where, $order='a.id desc', $start=0,$size=5){
	    $list = $this->alias('a')
	                 ->join('savor_smallapp_user user on a.openid= user.openid','left')
            	     ->field($fields)
            	     ->where($where)
            	     ->order($order)
            	     ->limit($start,$size)
            	     ->select();
	    $count = $this->alias('a')
	                  ->where($where)->count();
	    $objPage = new Page($count,$size);
	    $show = $objPage->admin_page();
	    $data = array('list'=>$list,'page'=>$show);
	    return $data;
	}
}
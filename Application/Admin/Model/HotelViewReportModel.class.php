<?php
namespace Admin\Model;
use Think\Model;
use Common\Lib\Page;
class HotelViewReportModel extends Model
{
    protected $connection = 'DB_STATIS';

    protected $tablePrefix = "view_";

    protected $tableName='statistics_hotel';


    public function __consruct($name){
        parent::__construct();
        $this->tableName = $name;
    }
    public function getList($field, $where, $order='id desc',$group, $start=0,$size=5){
	    $list = $this->alias('a')
		->field($field)
		->where($where)
	    ->order($order)
		->group($group)
	    ->limit($start,$size)
	    ->select();

 
	    $count = $this->alias('a')
		->group($group)
		->where($where)
	    ->count();
	    $objPage = new Page($count,$size);
	    $show = $objPage->admin_page();
	    $data = array('list'=>$list,'page'=>$show);
	    return $data;
	}


	public function getWhere($where, $field, $group){
		$list = $this->where($where)->field($field)->group($group)->select();
		return $list;
	}

	public function getOneData($where, $field="*") {
		$data = $this->where($where)->field($field)->find();
		return $data;
	}

	public function getAllData($where, $field="*") {
		$data = $this->alias('a')->where($where)->field($field)->select();
		return $data;
	}
}
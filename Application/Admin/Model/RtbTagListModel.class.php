<?php
namespace Admin\Model;
use Admin\Model\BaseModel;
use Common\Lib\Page;



/**
 * Class TagListModel
 * @package Admin\Model
 */
class RtbTagListModel extends BaseModel{
	protected $tableName='rtbtaglist';



	/**
	 * ��ȡ��ǩ�б��б��ҳ��
	 * @access public
	 * @param string $where ɸѡ����
	 * @param string $order ����
	 *  @param integer $start �ڼ�ҳ
	 *  @param integer $size ÿҳ����
	 *  @return array
	 */
	public function getList($where, $order='id desc', $start=0,$size=5,$field){
		$list = $this->where($where)
			->order($order)
			->limit($start,$size)
			->field($field)
			->select();
		$count = $this->where($where)->count();

		$objPage = new Page($count,$size);
		$show = $objPage->admin_page();
		$data = array('list'=>$list,'page'=>$show);
		return $data;
	}

	public function getPageCount($where){
		$count = $this->where($where)->count();
		return $count;
	}

	public function saveData($data, $where) {
		$bool = $this->where($where)->save($data);
		return $bool;
	}

	public function addData($data) {
		$result = $this->add($data);
		return $result;
	}


	public function getAllList($filed,$where,$order){
		$data = $this->field($filed)->where($where)->order($order)->select();
	    return $data;
	}
}
<?php
namespace Admin\Model;
use Admin\Model\BaseModel;
use Common\Lib\Page;



/**
 * Class TagModel
 * @package Admin\Model
 */
class RtbTagModel extends BaseModel{
	protected $tableName='pub_rtbtag';



	/**
	 * ��ȡ��ǩ�б��б��ҳ��
	 * @access public
	 * @param string $where ɸѡ����
	 * @param string $order ����
	 *  @param integer $start �ڼ�ҳ
	 *  @param integer $size ÿҳ����
	 *  @return array
	 */
	public function getList($where, $order='id desc', $start=0,$size=5){
		$list = $this->where($where)
			->order($order)
			->limit($start,$size)
			->select();
		$count = $this->where($where)->count();
		$objPage = new Page($count,$size);
		$show = $objPage->admin_page();
		$data = array('list'=>$list,'page'=>$show);
		return $data;
	}

	public function saveData($data, $where) {
		$bool = $this->where($where)->save($data);
		return $bool;
	}

	public function addData($data) {
		$result = $this->add($data);
		return $result;
	}


	public function delData($id) {
		$delSql = "DELETE FROM `savor_tag` WHERE tagid = '{$id}'";
		$result = $this -> execute($delSql);
		return  $result;
	}

	public function delWhereData($where) {
	    $result = $this->where($where)->delete();
		return  $result;
	}

	public function getWhereData($where, $field='') {
		$result = $this->where($where)->field($field)->select();
		return  $result;
	}

	public function getAllList($filed,$where,$order){
		$data = $this->field($filed)->where($where)->order($order)->select();
	    return $data;
	}
}
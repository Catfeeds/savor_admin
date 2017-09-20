<?php
/**
 *@author hongwei
 *
 *
 */
namespace Admin\Model;

use Admin\Model\BaseModel;
use Common\Lib\Page;

class DailyContentModel extends BaseModel
{
	protected $tableName='daily_content';



	/**
	 * @desc �������
	 * @access public
	 * @param mixed $data ����
	 * @return boolean
	 */
	public function addData($data) {
		$bool = $this->add($data);
		return $bool;
	}



	/**
	 * @desc ��ȡר����һ������
	 * @access public
	 * @param $field �ֶ���
	 * @param $where ɸѡ����
	 * @param $field ˳��
	 * @return boolean|array()
	 */
	public function getOneRow($where, $field,$order){
		$list = $this->where($where)
			->order($order)
			->limit(1)
			->field($field)->select();
		if(empty($list)){
			return false;
		}else{
			return $list[0];
		}

	}


	/**
	 * @desc ��ȡר�����Ӧ��ϵ������
	 * @access public
	 * @param $field �ֶ���
	 * @param $where ɸѡ����
	 * @return boolean|array()
	 */
	public function fetchDataBySql($field,$where ) {
		$sql = " SELECT $field FROM savor_daily_content
        sg left JOIN savor_daily_relation sr ON sg.id = sr.dailyid
        LEFT JOIN savor_media sm ON sm.id = sr.spictureid
        left join savor_article_source sas on sas.id = sg.source_id
         WHERE $where ";
		$res = $this->query($sql);
		if($res) {
			return $res;
		} else {
			return false;
		}
	}


	/**
	 * @desc ��������
	 * @access public
	 * @param mixed $data ����
	 * @param array $options ���ʽ
	 * @return boolean
	 */
	public function saveData($data, $where) {
		$bool = $this->where($where)->save($data);
		return $bool;
	}

	public function getWhere($where, $field, $order, $limit){
		$list = $this->where($where)
		->field($field)
		->order($order)
		->limit($limit)
		->select();
		return $list;
	}

	public function getList($field, $where, $order='id desc', $start=0,$size=5){
		$list = $this->alias('dc')
			->where($where)
			->field($field)
			->join('savor_daily_home  sh ON dc.id = sh.dailyid',
				'left')
			->join('savor_daily_lk  lk ON sh.lkid =  lk.id', 'left')
			->join('savor_sysuser su ON su.id = dc.creator_id ')
			->order($order)
			->limit($start,$size)
			->select();
		$count = $this->alias('dc')
			->where($where)
			->count();
		$objPage = new Page($count,$size);
		$show = $objPage->admin_page();
		$data = array('list'=>$list,'page'=>$show);
		return $data;
	}





}
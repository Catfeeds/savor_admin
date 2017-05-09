<?php
/**
 * Created by PhpStorm.
 * User: baiyutao
 * Date: 2017/5/9
 * Time: 13:54
 */

namespace Admin\Model;

use Admin\Model\BaseModel;
use Common\Lib\Page;

/**
 * Class BoxAwardModel
 * @package Admin\Model
 */
class BoxAwardModel extends BaseModel
{
	protected $trueTableName=''; //��ʵ����


	/**
	 *�ܹ�����
	 * @access public
	 *
     */
	public function __construct() {
		parent::__construct();
		$this->trueTableName = 'savor_box_award';

	}


	/**
	 * ��ȡ��������
	 * @access public
	 * @param array $where ɸѡ����
	 * @return integer
	 */
    public function getCount($where){
		$numbe = $this->where($where)->count();
		return $numbe;
	}

	/**
	 * �������޸�
	 * @access public
	 * @param array $data ����
	 * @param integer $acttype ��־λ
	 * @return array
	 */
	public function addData($data, $acttype=0) {
		if(0 === $acttype) {
			$result = $this->add($data);
		} else {
			$id = $data['id'];
			$result = $this->where("id={$id}")->save($data);
		}
		return $result;
	}


	/**
	 * ��ȡ�齱�������б��ҳ��
	 * @access public
	 * @param string $where ɸѡ����
	 * @param string $order ����
	 *  @param integer $start �ڼ�ҳ
	 *  @param integer $size ÿҳ����
	 *  @return array
	 */
	public function getList($where, $order='id desc', $start=0,$size=5){
		$sql = "select baw.`date_time` dat,baw.`id` bawid, baw.`box_id` bid, bx.`name` bname,bx.`mac` bmac,  ro.`name` rname, ht.`name` hname,baw.`prize` bpr,baw.`flag` bflag,baw.`create_time` bcr from $this->trueTableName as `baw` left join `savor_box` bx on baw.box_id=bx.id left join `savor_room`
 ro on baw.room_id = ro.id left join `savor_hotel` ht on baw.hotel_id = ht.id where $where and bx.`state`=1 and bx.`flag`=0 and ro.`state`=1 and ro.`flag`=0 and ht.`state`=1 and ht.`flag`=0 order by $order limit $start, $size";


		$list = $this->query($sql);
		$sqlb = "select count(*) cot from $this->trueTableName as `baw` where $where";
		$c_arr = $this->query($sqlb);
		$count = $c_arr[0]['cot'];
		$objPage = new Page($count,$size);

		$show = $objPage->admin_page();
		$data = array('list'=>$list,'page'=>$show);
		return $data;
	}






	/**
	 * ��ȡ����һ���齱������
	 * @param string $where ɸѡ����
	 * @return array
	 */
	public function getOneBoxAward($where){
		$sql = "select  baw.`id` bawid, baw.`box_id` bid, bx.`name` bname,bx.`mac` bmac,  ro.`name` rname, ht.`name` hname,baw.`prize` bpr,baw.`flag` bflag,baw.`create_time` bcr,
 baw.`date_time` dtime from $this->trueTableName as `baw` left join `savor_box` bx on baw.box_id=bx.id left join `savor_room`
 ro on baw.room_id = ro.id left join `savor_hotel` ht on baw.hotel_id = ht.id where $where and bx.`state`=1 and bx.`flag`=0 and ro.`state`=1 and ro.`flag`=0 and ht.`state`=1 and ht.`flag`=0";
		$list = $this->query($sql);
		$list = $list[0];
		return $list;
	}

	public function getAwardData($where){
		$list = $this->where($where)->select();
		return $list;
	}


}//End Class
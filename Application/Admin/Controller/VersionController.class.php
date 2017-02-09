<?php
/**
 *@author hongwei
 *
 *
 * 
 */
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Admin\Model\AdsModel;
class VersionController extends BaseController 
{


	public function client()
	{

		return $this->display('client');
	}

	public function ad(){




			$catModel = new CategoModel;



			$size   = I('numPerPage',50);//��ʾÿҳ��¼��
			$this->assign('numPerPage',$size);
			$start = I('pageNum',1);
			$this->assign('pageNum',$start);
			$order = I('_order','sort_num');
			$this->assign('_order',$order);
			$sort = I('_sort','asc');
			$this->assign('_sort',$sort);
			$orders = $order.' '.$sort;
			$start  = ( $start-1 ) * $size;

			$where = "1=1";

			$name = I('name');

			if($name)
			{
				$this->assign('name',$name);
				$where .= "	AND name LIKE '%{$name}%'";
			}

			$result = $catModel->getList($where,$orders,$start,$size);

			$this->assign('list', $result['list']);
			$this->assign('page',  $result['page']);
			$this->display('addadvertise');

	}

	public function manager(){
		$this->display('');
	}

	public function doadd(){

		//����ads��
		$adModel = new AdsModel();
		$save              = [];
		$save['name']  	   = I('post.name','','trim');
		$save['media_id']  	   = I('post.media_id','','trim');
		$save['duration']  	   = I('post.duration','','trim');
		if($adModel->add($save))
		{
			return $this->output('��ӳɹ�!', 'send/video');
		}
		else
		{
			return  $this->output('���ʧ��!', 'send/doAddMedia');
		}

	}
	/*
	 * �����������Ƿ����
	 */
	public function checkname() {
		$adModel = new AdsModel();
		$name = I('post.name');
		$res = $adModel->where('name='.$name)->select();
		if ($res) {
			echo '0';
		} else {
			echo '1';
		}

	}









}//End Class

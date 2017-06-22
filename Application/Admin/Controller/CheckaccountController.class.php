<?php
/**
 * Project savor_admin
 *
 * @author baiyutao <------@gmail.com> 2017-06-19
 */
namespace Admin\Controller;

use Admin\Controller\BaseController;
use Common\Lib\SavorRedis;
use Common\Lib\Ucpaas;

/**
 * Class CheckaccountController
 * 对账单列表
 * /
 * @package Admin\Controller
 */
class CheckaccountController extends BaseController{


	/**
	 * @desc 对账单列表
	 *
	 */
	public function rplist(){
		$starttime = I('post.starttime','');
		$endtime = I('post.endtime','');
		$stateModel =  new \Admin\Model\AccountStatementModel();
		$size   = I('numPerPage',50);//显示每页记录数
		$this->assign('numPerPage',$size);
		$start = I('pageNum',1);
		$this->assign('pageNum',$start);
		$order = I('_order','sast.create_time');
		$this->assign('_order',$order);
		$sort = I('_sort','desc');
		$this->assign('_sort',$sort);
		$orders = $order.' '.$sort;
		$start  = ( $start-1 ) * $size;
		$fee_type = C('fee_type');
		$where = "1=1";
		if($starttime){
			$this->assign('s_time',$starttime);
			$where .= "	AND sast.create_time >= '{$starttime}'";
		}
		if($endtime){
			$this->assign('e_time',$endtime);
			$where .= "	AND sast.create_time <=  '{$endtime}'";
		}

		$result = $stateModel->getAll($where,$orders, $start=0,$size=5);
		$ind = $start;
		foreach ($result['list'] as &$val) {
			$val['indnum'] = ++$ind;
			foreach ($fee_type as $fk=>$fv){
				if($fk == $val['cost_type']){
					$val['cost_type'] = $fv;
				}
			}
		}
		$acd = array ( 0 => array ( 'cost_type' => '开机费', 'fee_start' => '2017-06-16', 'create_time' => '2017-06-21 16:01:04', 'stremark' => 'dsfwwerwe', 'count' => '2', 'receipt_addr' => 'tian1', 'receipt_tel' => 'tian2,010-82105147', 'receipt_head' => 'tian3', 'receipt_taxnum' => 'tian4', 'uremark' => 'Admin', 'indnum' => 1, ), );
		//var_export($result['list']);

		$this->assign('list', $result['list']);
		$this->assign('page',  $result['page']);
		$this->display('accountlist');
	}


	public function payCash(){
		$did = I('get.detailid',0);
		$statementid = I('get.statementid',0);
		if($did){
			$statedetailModel = new \Admin\Model\AccountStatementDetailModel();
			$info = $statedetailModel->find($did);
			$ch_staus =  $info['check_status'];
			$state = $info['state'];
			if($ch_staus == 2 && $state == 1){
				//更新状态
				$dat['check_status'] = 3;
				$where = 'id = '.$did;
				$statedetailModel->saveData($dat, $where);
				//下发短信
				$info = $statedetailModel->getWhereSql($did);
				$this->sendPayMessage($info);

				$this->output('确认付款成功!', U('checkaccount/showHotel?statementid='.$statementid));

			}else{
				$this->error('您无权限点击');
			}
		}else{
			$this->error('传参不能为空');
		}
	}



	public function showhotel(){

		$statementid = I('statementid',0);
		$statedetailModel = new \Admin\Model\AccountStatementDetailModel();
		$statenoticeModel = new \Admin\Model\AccountStatementNoticeModel();

		if($statementid){
			$size   = I('numPerPage',50);//显示每页记录数
			$this->assign('numPerPage',$size);
			$start = I('pageNum',1);
			$this->assign('pageNum',$start);
			$order = I('_order','sdet.id');
			$this->assign('_order',$order);
			$sort = I('_sort','desc');
			$this->assign('_sort',$sort);
			$orders = $order.' '.$sort;
			$start  = ( $start-1 ) * $size;
			$where = "1=1";
			$where .= " AND sdet.statement_id = ".$statementid;
			$result = $statedetailModel->getAll($where,$orders, $start=0,$size=5);
			$ind = $start;
			$notice_state = C('NOTICE_STATAE');
			$check_state = C('CHECK_STATAE');
			foreach ($result['list'] as &$val){
				$val['indnum'] = ++$ind;
				foreach($check_state as $ch=>$cv){
                      if($ch == $val['check_status']) {
						  $val['ch_mes'] = $cv;
						  if($ch == 3) {
							  $val['cont'] = '2';
						  }else{
							  $val['cont'] = '确认付款完成';
						  }
						  break;
					  }
				}
				foreach($notice_state as $nh=>$nv){
					if($nh == $val['state']) {
						if($val['state'] == 1) {
							$dat['detail_id'] = $val['detailid'];
							$dat['f_type'] = 1;
							$notice_arr = $statenoticeModel->getWhere($dat);
							$nostus = $notice_arr['status'];
							if($nostus == 1){
								$val['no_mes'] = '发送成功';
							}else {
								$val['no_mes'] = '发送失败';
							}
							break;
						} else {
							$val['no_mes'] = $nv;
							break;
						}
					}
				}

			}
			$this->assign('statementid', $statementid);
			$this->assign('list', $result['list']);
			$this->assign('page',  $result['page']);
			$this->display('showHotel');
		}
	}


	/**
	 * 添加对账单信息
	 *
	 */
	public function addcheckaccount(){
		//费用类型
		$fee_type = C('fee_type');
		//各种地址
		$accountconfigModel =  new \Admin\Model\AccountConfigModel();
		$where = ' 1=1 ';
		$order =  'id desc';
		$configinfo = $accountconfigModel->getAll('', $where, $order);
		dump($configinfo);
		$this->assign('fee_list', $fee_type);
		$this->assign('account_config', $configinfo);
		return $this->display('addAccount');
	}





	public function getaccountinfo(){
		$cid = I('post.tid');
		$accountModel = new \Admin\Model\AccountConfigModel();
		$res_save = $accountModel->find($cid);
		$res_save['receipt_tel'] = str_replace(',','  ', $res_save['receipt_tel']);
		if($res_save){
			$result = array('code'=>1,'list'=>$res_save);
		}
		echo json_encode($result);
	}




	/*
 * 处理excel数据
 */
	public function analyseExcel(){
		$path = $_POST['excelpath'];
		if  ($path == '') {
			$res = array('error'=>0,'message'=>array());
			echo json_encode($res);
		}
		$type = strtolower(pathinfo($path, PATHINFO_EXTENSION));
		vendor("PHPExcel.PHPExcel.IOFactory");
		if ($type == 'xlsx' || $type == 'xls') {
			$objPHPExcel = \PHPExcel_IOFactory::load($path);
		} elseif ($type == 'csv') {
			$objReader = \PHPExcel_IOFactory::createReader('CSV')
				->setDelimiter(',')
				->setInputEncoding('GBK')//不设置将导致中文列内容返回boolean(false)或乱码
				->setEnclosure('"')
				->setLineEnding("\r\n")
				->setSheetIndex(0);
			$objPHPExcel = $objReader->load($path);
		} else {
			$this->output('文件格式不正确', 'importdata', 0, 0);
		}

		$sheet = $objPHPExcel->getSheet(0);
		//获取行数与列数,注意列数需要转换
		$highestRowNum = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();
		$highestColumnNum = \PHPExcel_Cell::columnIndexFromString($highestColumn);
		// var_dump($highestRowNum, $highestColumn, $highestColumnNum);
		//取得字段，这里测试表格中的第一行为数据的字段，因此先取出用来作后面数组的键名
		$filed = array();
		for ($i = 0; $i < $highestColumnNum; $i++) {
			$cellName = \PHPExcel_Cell::stringFromColumnIndex($i) . '1';
			$cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
			$filed[] = $cellVal;
		}
		// var_dump($filed);

		//开始取出数据并存入数组
		$data = array();
		for ($i = 2; $i <= $highestRowNum; $i++) {//ignore row 1
			$row = array();
			for ($j = 0; $j < $highestColumnNum; $j++) {
				$cellName = \PHPExcel_Cell::stringFromColumnIndex($j) . $i;
				$cellVal = $sheet->getCell($cellName)->getValue();
				$row[$filed[$j]] = $cellVal;
			}
			$data [] = $row;
		}
		$res = array('error'=>0,'message'=>$data);
		echo json_encode($res);
		die;
	}




	public function doaddCheckAccount(){
		$user = new \Admin\Model\UserModel();
		$statementModel = new \Admin\Model\AccountStatementModel();
		$statedetailModel = new \Admin\Model\AccountStatementDetailModel();
		$statenoticeModel = new \Admin\Model\AccountStatementNoticeModel();
		$arr = array (
			'id' => '',
			'fee' => '1',
			'starttime' => '2017-06-20',
			'endtime' => '2017-06-17',
			'rec_addr' => '2',
			'rec_tel' => '2',
			'rec_head' => '2',
			'rec_taxnum' => '2',
			'accountjson' => '[{"id":7,"name":"永峰","money":18},{"id":8,"name":"茉莉餐厅","money":20333},{"id":5600,"name":"茉莉餐厅","money":20333}]',
			'ajax' => '1',
			'remark' => 'W3R232',
		);
		//$_POST['taginfo'] = preg_replace("/\'/", '"', $_POST['taginfo']);
		$date_now         = date('Y-m-d H:i:s');
		$start_date   = I('post.starttime','');
		$end_date   = I('post.endtime','');
		$rec_addr_id   = I('post.rec_addr','');
		$fee = I('post.fee');
		$remark= I('post.remark','','trim');
		$hotel_acc_arr   = json_decode (I('accountjson'),true);



		$start_date = '2017-06-16';
		$end_date = '2017-06-20';
		$hotel_acc_arr = json_decode ($arr['accountjson'],true);
		$where =' 1=1';
		if($start_date && $end_date){
			if($end_date<=$start_date){
				$this->error('结束时间不能小于等于开始时间');
			}
		}
		//判酒楼是否已经存在以及detail表是否有
		$hotel_acc_info = $this->judgeHotel($hotel_acc_arr,$start_date, $end_date,$fee);
		//var_dump($hotel_acc_info);
		$statement_num = 0;
		foreach($hotel_acc_info as $hk=>$hv){
			if($hv['state'] == 2){
				continue;
			}else{
				if(!isset($hv['state'])){
					$hotel_acc_info[$hk]['state'] = 1;
				}
				$statement_num++;
			}
		}
		var_dump($statement_num);

		//添加savor_account_statement表operator operatorid
		$save['fee_start']  = $start_date;
		$save['fee_end']  = $end_date;
		$save['cost_type'] = $fee;
		$save['receipt_addrid'] = $rec_addr_id;
		$save['remark'] = $remark;
		$save['create_time'] = $date_now;
		$save['update_time'] = $date_now;
		$save['count'] = $statement_num;
		$userInfo = session('sysUserInfo');
		$user_info = $user->getUserInfo($userInfo['id']);
		$save['operatorid'] = $user_info['id'];
		$res = $statementModel->add($save);
		$insertid = $statementModel->getLastInsID();
		if($res){
			//添加savor_account_statement_detail表
			$datalist = array();
			foreach ($hotel_acc_info as $hk=>$hv) {
					$datalist[] = array(
						'hotel_id'=>!empty($hv['id'])?$hv['id']:0,
						'check_status' =>0,
						'statement_id' =>$insertid,
						'money' =>!empty($hv['money'])?$hv['money']:0,
						'state'=>$hv['state'],
						'err_msg'=>'',
						'fee_start'=>$start_date,
						'fee_end' =>$end_date,
						'cost_type' => $fee,
						'create_time' => $date_now,
						'update_time' => $date_now,

					);


			}
			//echo '<hr/><hr/>';
			//var_dump($datalist);

			$rdetail = $statedetailModel->addAll($datalist);
			if($rdetail){
				$rd = array();
				$rd['statement_id'] = $insertid;
				$detail_arr = $statedetailModel->getWhereData($rd);
				var_export($detail_arr);
				var_export($hotel_acc_info);
				$dpr = array();
				$message = array();
				foreach($detail_arr as $dv){
					$dpr[$dv['hotel_id']] = $dv['id'];
				}
				$ma = array();
				foreach($hotel_acc_info as $ha=>$hi){
					if($hi['state'] == 1){

						$message[$ha]['detail_id'] = $dpr[$hi['id']];
						$ma[] = $message[$ha]['detail_id'];
						$message[$ha]['status'] = 0;
						$message[$ha]['f_type'] = 1;
						$message[$ha]['create_time'] = $date_now;
						$message[$ha]['update_time'] = $date_now;
						$message[$ha]['count'] = 0;

					}else{
						continue;
					}

				}
				//添加savor_account_notice表
				$statenoticeModel->addAll($message);
				//添加到redis
				$statenoticeModel->saveStRedis($ma);

			}else{
				$this->error('添加对账单明细失败');
			}

		}else{
			$this->error('添加对账单失败');
		}
	}

	private function judgeHotel($info,$st,$en,$fee){
		$num = array();
		$money = array();
		//判断酒楼是否存在
		$hotelModel = new \Admin\Model\HotelModel();
		$statedetailModel = new \Admin\Model\AccountStatementDetailModel();
		foreach($info as $rk=>$rv) {
			$num[] = $rv['id'];
			$money[$rv['id']] = $rv['money'];
		}
		$num_str = implode(',', $num);
		$dat['id']=array('in',$num_str);
		$dat['flag']= 0;
		$field = 'id,name,bill_per,bill_tel';
		$res = $hotelModel->getWhereData($dat, $field);
		foreach($res as $rk=>$rv) {
			$res[$rk]['money'] = $money[$rv['id']];
			$num_true[] = $rv['id'];
			if(empty($res[$rk]['bill_tel'])){
				$res[$rk]['state'] = 4;
			}
			if($res[$rk]['money']<0){
				$res[$rk]['state'] = 5;
			}
		}
		$count = count($num_true);
		$ar_diff = array_diff($num, $num_true);
		foreach($ar_diff as $av){
			$res[$count]['id'] = $av;
			$res[$count]['state'] = 2;
			$res[$count]['name'] = '';
			$res[$count]['bill_per'] = '';
			$res[$count]['bill_tel'] = '';
			$count++;
		}
		//判断酒楼是否下发
		//ft<=en   开始值要小于给出结束值
        //fe>=st   结束值要大于给出开头值
		$where = ' 1=1 and cost_type='.$fee;
		if($st){
			$where .= " and fee_end >='".$st."'";
		}
		if($en){
			//$start_date = date('YmdH',strtotime($start_date));
			$where .= " AND fee_start <='".$en."' ";
		}
		$num_true_str = implode(',', $num_true);
		$where .= "and hotel_id in ($num_true_str)";
		$field = '`hotel_id`';
		$rest = $statedetailModel->getWhereData($where,$field);
		foreach($rest as $rv){
			$numpp = $rv['hotel_id'];
			$fee_time_num[$numpp] = $numpp;
		}
		foreach($res as $rk=>$rv) {

			if ( isset($fee_time_num[$rv['id']]) &&  !isset($res[$rk]['state'])){
				$res[$rk]['state'] = 3;
			}
		}
		return $res;
	}


	public function sendToSeller(){

		//http://www.a.com/index.php/checkaccount/send_message
		$redis  =  SavorRedis::getInstance();
		$redis->select(15);
		$rkey = 'savor_account_statement_notice';
		$roll_back_arr = array();
		$suca = array();
		$count = 0;
		$maxcount = 8;
		$max = $redis->lsize($rkey);
		$data = $redis->lgetrange($rkey,0,$max);
		$statedetailModel = new \Admin\Model\AccountStatementDetailModel();
		$statenoticeModel = new \Admin\Model\AccountStatementNoticeModel();
		$me_su_arr = array();
		$me_fail_arr = array();
		if(empty($data)){
			echo '数组为空'."\n";
			die;
		}
		//http://www.a.com/showMesLink/1be79d87c7f8360f
		foreach ($data as $val){
			//获取短信发送最大值数量
			$field = 'count,id noticeid, f_type ftype';
			$dat['detail_id'] = $val;
			$notice_arr = $statenoticeModel->getWhere($dat, $field);
			if($notice_arr){
				$count = $notice_arr['count'];
				$noticeid = $notice_arr['noticeid'];
				if ($count >= 8 ) {
					$redis->lPop($rkey);
					continue;
				} else {
					//发送短信
					$info = $statedetailModel->getWhereSql($val);
					$m_state = $this->sendMessage($info);
					if($m_state){
						$redis->lPop($rkey);
						$me_su_arr[] = $noticeid;
						continue;
					}else{
						$roll_back_arr[] = $val;
						$me_fail_arr[] = $noticeid;
						continue;
					}

				}
			}else{
				echo '出错ID:'.$val.'<br/>';
			}

		}
		if($roll_back_arr){
			//更新count字段
			foreach($roll_back_arr as $k){
				$redis->rPush($rkey, $k);
			}
		}
		if($me_su_arr){
			$me_su_str = 'values';
			$where = 'status = 1';
			foreach($me_su_arr as $ma){
				$me_su_str .=  ' ('.$ma.')'.',';
			}
			$me_su_str = substr($me_su_str,0,-1);
			$statenoticeModel->insertDup($me_su_str, $where);
		}
		if($me_fail_arr){
			$me_fail_str = 'values';
			$where = '`count` = `count` + 1';
			foreach($me_fail_arr as $ma){
				$me_fail_str .=  ' ('.$ma.')'.',';
			}
			$me_fail_str = substr($me_fail_str,0,-1);
			$statenoticeModel->insertDup($me_fail_str, $where);
		}
	}


	private function addAccountLog($sjson,$param){

		$log=date("Y-m-d H:i:s")."---".$sjson."---".$param;
		$path = LOG_PATH."Admin/sendmsg_".date("Y-m-d").".log";
		var_dump($path);
		file_put_contents($path, $log."\n",FILE_APPEND);
	}


	private function sendToUcPa($to,$param,$type=1){
		$bool = true;
		$ucconfig = C('SMS_CONFIG');
		$options['accountsid'] = $ucconfig['accountsid'];
		$options['token'] = $ucconfig['token'];
		//确认付款通知
		if($type == 2){

		}else{
			$templateId = $ucconfig['templateid'];
		}
		$ucpass= new Ucpaas($options);
		$appId = $ucconfig['appid'];
		$sjson = $ucpass->templateSMS($appId,$to,$templateId,$param);
		$this->addAccountLog($sjson,$param);
		$sjson = json_decode($sjson,true);
		$code = $sjson['resp']['respCode'];

		if($code === '000000') {
		}else{
			$bool = false;
		}
		return $bool;

	}



	private function sendMessage($info){
		//$sjson  = '{"resp":{"respCode":"000000","templateSMS":{"createDate":"20170621131304","smsId":"3bcd56624d1d60a6e5830c3886f2f31d"}}}';
		$fe_start = $info['fee_start'];
		$fe_end = $info['fee_end'];
		$tel= $info['tel'];
		$detailid = $info['id'];
		$to = $tel;
		$short = encrypt_data($detailid);
		$shortlink = C('HOST_NAME').'/admin/hotelbill/index?id='.$short;
		$shortlink = shortUrlAPI(1, $shortlink);
		echo $shortlink;
		$param="$fe_start,$fe_end,$shortlink";
		$bool = $this->sendToUcPa($tel,$param);
		return $bool;
	}


	private function sendPayMessage($info){
		//$sjson  = '{"resp":{"respCode":"000000","templateSMS":{"createDate":"20170621131304","smsId":"3bcd56624d1d60a6e5830c3886f2f31d"}}}';
		$fe_start = $info['fee_start'];
		$fe_end = $info['fee_end'];
		$tel= $info['tel'];
		$detailid = $info['id'];
		$to = $tel;
		$param="$fe_start,$fe_end,$shortlink";
		$bool = $this->sendToUcPa($tel,$param, 2);
		return $bool;
	}

}

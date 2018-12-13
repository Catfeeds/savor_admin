<?php
/**
 *@author hongwei
 *
 *
 */
namespace Admin\Model\Smallapp;

use Admin\Model\BaseModel;
use Common\Lib\Page;

class ForscreenRecordModel extends BaseModel
{
	protected $tableName='smallapp_forscreen_record';
	
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
	    $data = $this->alias('a')
	                 ->join('savor_box box on a.box_mac=box.mac','left')
	                 ->join('savor_room room on box.room_id=room.id','left')
	                 ->join('savor_hotel hotel on room.hotel_id=hotel.id','left')
	                 ->field($fields)->where($where)
	                 ->order($order)->limit($limit)
	                 ->group($group)->select();
	    return $data;
	}
	public function getOne($fields,$where){
	    $data = $this->field($fields)->where($where)->find();
	    return $data;
	}
	public function countWhere($where){
	    $nums = $this->alias('a')
	                 ->join('savor_box box on a.box_mac=box.mac','left')
	                 ->join('savor_room room on box.room_id=room.id','left')
	                 ->join('savor_hotel hotel on room.hotel_id=hotel.id','left')
	                 ->where($where)->count();
	    return $nums;
	}
	public function getStaticList($fields,$where,$order,$group,$start,$size,$pageNum,$area_id){
	    $list = $this->alias('a')
            	     ->join('savor_box box on a.box_mac=box.mac','left')
            	     ->join('savor_room room on box.room_id=room.id','left')
            	     ->join('savor_hotel hotel on room.hotel_id=hotel.id','left')
            	     ->join('savor_area_info area on hotel.area_id= area.id','left')
            	     ->field($fields)
            	     ->where($where)
	                 ->group($group)
	                 ->limit($start,$size)
	                 ->select();
	    $hotel_list = $this->alias('a')
                    	   ->join('savor_box box on a.box_mac=box.mac','left')
                    	   ->join('savor_room room on box.room_id=room.id','left')
                    	   ->join('savor_hotel hotel on room.hotel_id=hotel.id','left')
                    	   ->join('savor_area_info area on hotel.area_id= area.id','left')
                    	   ->field('hotel.id hotel_id')
                    	   ->where($where)
                    	   ->group($group)
                    	   ->select();
	    $forscreen_hotel_arr = array();
	    foreach($hotel_list as $v){
	        $forscreen_hotel_arr[] = $v['hotel_id'];
	    }
	    
	    $all_count = count($forscreen_hotel_arr);   //投屏互动数据总数
	    $nt_page = ceil($all_count/$size);
	    
	    if($pageNum>=$nt_page){
	        $h_start = ($pageNum-$nt_page);
	        $h_size  = $size - count($list);
	    }
	    $m_hotel = new \Admin\Model\HotelModel();
	    $map = array();
	    if($area_id){
	        $map['a.area_id'] = $area_id;
	    }
	    $map['a.state'] = 1;
	    $map['a.flag']  = 0;
	    if($forscreen_hotel_arr) $map['a.id']    = array('not in',$forscreen_hotel_arr);
	    
	    $heart_hotel_box_type = C('heart_hotel_box_type');
	    
	    $net_box_arr = array_keys($heart_hotel_box_type);
	    $map['a.hotel_box_type'] = array('in',$net_box_arr);
	    
	    $h_list = $m_hotel->alias('a')
	            ->join('savor_area_info area on a.area_id=area.id','left')
	            ->field('a.id hotel_id,area.region_name ,a.name hotel_name,1 as `tstype`')
	            ->where($map)
	            ->limit($h_start,$h_size)
	            ->select();
	    $list = array_merge($list,$h_list);
	    $ret = $m_hotel->alias('a')
	            ->join('savor_area_info area on a.area_id=area.id','left')
	            ->field('a.id hotel_id,area.region_name ,a.name hotel_name')
	            ->where($map)
	            
	            ->select();
	    
	    $count = count($ret);
	    $objPage = new Page($count,$size);
	    $show = $objPage->admin_page();
	    $data = array('list'=>$list,'page'=>$show);
	    return $data;
	}
}
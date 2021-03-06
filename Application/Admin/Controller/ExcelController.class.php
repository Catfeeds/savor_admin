<?php
namespace Admin\Controller;

use Think\Controller;

// use Common\Lib\SavorRedis;
/**
 * @desc 功能测试类
 *
 */
class ExcelController extends Controller
{

    public function exportExcel($expTitle, $expCellName, $expTableData,$filename)
    {
        set_time_limit(90);
        ini_set("memory_limit", "512M");
        vendor("PHPExcel.PHPExcel.IOFactory");
        vendor("PHPExcel.PHPExcel");
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        if($filename == 'hotel') {
            $tmpname = '酒楼资源总表';
        } else if ($filename == 'boxlostreport') {
            $tmpname = '机顶盒失联表';
        }  else if ($filename == 'screencastreport') {
            $tmpname = '投屏次数点播表';
        }  else if ($filename == 'mobile_interaction_final') {
            $tmpname = 'APP包间首次互动数据';
        }  else if ($filename == 'first_mobile_download') {
            $tmpname = '酒楼首次打开数据';
        }  else if ($filename == 'downloadcount') {
            $tmpname = '下载量报表统计';
        }  else if ($filename == 'appcreen') {
            $tmpname = 'app与大屏互动统计';
        }  else if ($filename == 'hotelscreen') {
            $tmpname = '酒楼大屏统计';
        }else if($filename == "allappdownload"){
            $tmpname = 'App下载统计总表';
        }else if($filename == "hotelbillinfo"){
            $tmpname = '对账单酒楼信息联系表';
        }else if($filename == 'toothwash'){
            $tmpname = '活动订单';
        }else if($filename == 'contentads'){
            $tmpname = '内容与广告统计';
        }else if($filename =='hotelBv'){
            $tmpname = '酒楼信息';
        }else if($filename =='contentlink'){
            $tmpname = '内容链接明细';
        }else if($filename =='expcontentwxauth'){
            $tmpname = '文章微信授权日志';
        }else if ($filename == 'optionerrobox'){
            $tmpname = '运维端异常机顶盒';
        }else if($filename == 'dinnerapp_hall_log') {
            $tmpname = '餐厅端日志上报';
        }else if($filename =='option_sh_task_list'){
            $tmpname='上海发布任务列表';
        }else if($filename == 'bind_invite_hotel_info') {
            $tmpname = '餐厅端绑定酒楼数据';
        }else if($filename == 'box_version_condition') {
            $tmpname = '机顶盒版本情况分布';
        }else if($filename == 'box_lost_version_condition') {
            $tmpname = '失联机顶盒分布';
        }else if($filename == 'adver_warn_report') {
            $tmpname = '广告播放异常预警';
        }
        if($filename == "heartlostinfo"){
            $fileName = $expTitle;
            $acp = 3;
        }else{
            $fileName = $tmpname . date('_YmdHis');//or $xlsTitle
        }

        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");

        $objPHPExcel = new \PHPExcel();
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        //   $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        // $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));
        //$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Hello');

        for ($i = 0; $i < $cellNum; $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i][1]);

        }
        // Miscellaneous glyphs, UTF-8
        for ($i = 0; $i < $dataNum; $i++) {
            for ($j = 0; $j < $cellNum; $j++) {
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j] . ($i + 2), $expTableData[$i][$expCellName[$j][0]]);
            }
        }
        if($filename == 'hotel') {
            $objPHPExcel->getActiveSheet()->getColumnDimension()->setWidth(12);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getStyle('D11')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            // $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            //$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        }else if($filename == 'boxlostreport'){
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        }else if($filename == 'hotelbillinfo'){
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        }else if($filename == "heartlostinfo"){
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        }else if($filename == "contentads"){
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    /**
     *
     * 导出内容与广告相关数据备份
     */
    public function expcontentadsbaks(){

        $starttime = I('starttime','');
        $endtime = I('endtime','');
        $adsname = I('adsname');
        $hidden_adsid = I('hadsid');
        $yesday =  date("Y-m-d",strtotime("-1 day"));
        $tmp_box_tv = array();
        //$hidden_adsid = 98;//429
       // $adsname = '刺客信条';
        //$starttime = '2017-08-02';
        //$endtime = '2017-08-08';
      //  $hidden_adsid = 98;
        $where = "1=1";
        if ( $adsname ) {
            $adModel = new \Admin\Model\AdsModel();
            $ads_info = $adModel->find($hidden_adsid);
            if(empty($ads_info)){
                $tmp_box_tv = array();
            }else{
                //判断是否在节目单中发布过
                $ads_media_id = $ads_info['media_id'];
                $mItemModel = new \Admin\Model\MenuItemModel();
                $field = "distinct(`menu_id`)";
                $where .= " AND ads_id={$hidden_adsid}  ";
                $order = 'menu_id asc';
                $menu_arr = $mItemModel->getWhere($where,$order, $field);
                    //判断是否在酒店发布过
                    $where = "1=1";
                    foreach($menu_arr as $ma){
                        $menu_id_str .= $ma['menu_id'].',';
                    }
                    $menu_id_str = substr($menu_id_str,0,-1);
                    $where .= " AND menu_id in ( ".$menu_id_str.')';
                    $mhotelModel = new \Admin\Model\MenuHotelModel();
                    $hotelModel = new \Admin\Model\HotelModel();
                    $field = "distinct(`hotel_id`)";
                    $order = 'hotel_id asc';
                    $hotel_id_arr = $mhotelModel->getWhere($where, $order, $field);
                    //根据hotelid得出box
                    $where = '1=1';
                    foreach($hotel_id_arr as $ha){
                        $hotel_id_str .= $ha['hotel_id'].',';
                    }
                    $hotel_id_str = substr($hotel_id_str,0,-1);
                    $where .= " AND sht.id in ( ".$hotel_id_str.')';
                    $field = 'sht.id hotelid,sht.name,room.id
                              rid,room.name rname,box.name box_name, box.mac,sari
                              .region_name cname';
                    $box_info = $hotelModel->getBoxMacByHid($field, $where);

                    $field = 'sum(play_count) plc,
                    sum(play_time) plt,mac,group_concat(`play_date`) pld';
                    $starttime = date("Ymd", strtotime($starttime));
                    $endtime = date("Ymd", strtotime($endtime));
                    $where = '1=1';
                    $mestaModel = new \Admin\Model\MediaStaModel();
                    $where .= " AND media_id = ".$ads_media_id;
                    $where .= "	AND play_date >= '{$starttime}'";
                    $where .= "	AND play_date <= '{$endtime} '";
                    $group = 'mac';
                    $me_sta_arr = $mestaModel->getWhere($where, $field, $group);
                    //二维数组合并
                    $mp = array_column($me_sta_arr, 'mac');
                    $me_sta_arr = array_combine($mp, $me_sta_arr);
                    //var_dump($mestaModel->getLastSql());
                    //dump($box_info);
                    //dump($me_sta_arr);
                    //获取电视数量
                    //进行比较
                    foreach ($box_info as $bk=>$bv) {
                        $map_mac = $bv['mac'];
                        //先判断是否存在
                        if(array_key_exists($map_mac, $tmp_box_tv)) {
                            $tmp_box_tv[$map_mac]['tv_count'] +=1;
                            continue;
                        }else {
                            if(array_key_exists($map_mac, $me_sta_arr)) {
                                $mv = $me_sta_arr[$map_mac];
                                $mv['pld'] = preg_replace('/(\s)*/','', $mv['pld']);
                                $day_arr = explode(',',$mv['pld']);
                                $day_arr = array_unique($day_arr);
                                $day_str = implode(',', $day_arr);
                                $day_len = count($day_arr);
                                $tmp_box_tv[$map_mac]['cityname'] = $bv['cname'];
                                $tmp_box_tv[$map_mac]['hotel_name'] = $bv['name'];
                                $tmp_box_tv[$map_mac]['rname'] = $bv['rname'];
                                $tmp_box_tv[$map_mac]['play_count'] = $mv['plc'];
                                $tmp_box_tv[$map_mac]['play_time'] = $mv['plt'];
                                $tmp_box_tv[$map_mac]['play_days'] = $day_len;
                                $tmp_box_tv[$map_mac]['publication'] = $day_str;
                                $tmp_box_tv[$map_mac]['tv_count'] = 1;
                                $tmp_box_tv[$map_mac]['mac'] = $map_mac;
                                $tmp_box_tv[$map_mac]['box_name'] = $bv['box_name'];
                            }else{
                                $tmp_box_tv[$map_mac]['cityname'] = $bv['cname'];
                                $tmp_box_tv[$map_mac]['rname'] = $bv['rname'];
                                $tmp_box_tv[$map_mac]['hotel_name'] = $bv['name'];
                                $tmp_box_tv[$map_mac]['play_count'] = '';
                                $tmp_box_tv[$map_mac]['play_time'] = '';
                                $tmp_box_tv[$map_mac]['play_days'] = '';
                                $tmp_box_tv[$map_mac]['publication'] = '';
                                $tmp_box_tv[$map_mac]['tv_count'] = 1;
                                $tmp_box_tv[$map_mac]['mac'] = $map_mac;
                                $tmp_box_tv[$map_mac]['box_name'] = $bv['box_name'];
                            }
                            unset($me_sta_arr[$map_mac]);
                        }

                    }
                    $tmp_box_tv = array_values($tmp_box_tv);
                }

            //需要将传过来name与隐藏域进行对比再次确定它传过来的值是正确的
            //判断是否是广告列表中
        }else{
            $tmp_box_tv = array();
        }
        $xlsCell = array(
            array('cityname', '地区'),
            array('hotel_name', '酒楼名称'),
            array('rname', '包间名称'),
            array('box_name','机顶盒名称'),
            array('mac', 'mac'),
            array('tv_count', '电视数量'),
            array('play_count', '播出次数'),
            array('play_time', '播出时长'),
            array('play_days', '播出天数'),
            array('publication', '上刊日期')
        );
        $xlsName = 'contentads';
        $filename = 'contentads';
        $this->exportExcel($xlsName, $xlsCell, $tmp_box_tv,$filename);
    }





    /**
     *
     * 导出内容与广告相关数据
     */
    public function expcontentads(){

        $starttime = I('starttime','');
        $endtime = I('endtime','');
        $adsname = I('adsname');
        $hidden_adsid = I('hadsid');
        $yesday =  date("Y-m-d",strtotime("-1 day"));
        $tmp_box_tv = array();
        //$hidden_adsid = 98;//429
        // $adsname = '刺客信条';
        //$starttime = '2017-08-02';
        //$endtime = '2017-08-08';
        //  $hidden_adsid = 98;
        $where = "1=1";
        if ( $adsname ) {
            $adModel = new \Admin\Model\AdsModel();
            $ads_info = $adModel->find($hidden_adsid);
            if(empty($ads_info)){
                $tmp_box_tv = array();
            }else{
                $ads_media_id = $ads_info['media_id'];
                $mhotelModel = new \Admin\Model\MenuHotelModel();
                $hotelModel = new \Admin\Model\HotelModel();
                $field = "distinct(`id`) hotel_id";
                $order = 'id asc';
                $where .= " and name not like '%永峰%' ";
                $where .= " and hotel_box_type in (2,3) ";
                $hotel_id_arr = $hotelModel->getWhereorderData($where,  $field, $order);
                //根据hotelid得出box
                $where = '1=1 and box.state = 1 and box.flag = 0 ';
                $hotel_id_str =  array_reduce($hotel_id_arr ,
                    function($result , $v){
                        Return $result.','.$v['hotel_id'];
                    }
                );
                $hotel_id_str = substr($hotel_id_str,1);
                $where .= " AND sht.id in ( ".$hotel_id_str.')';
                $field = 'sht.id hotelid,sht.name,room.id
                              rid,room.name rname,box.name box_name, box.mac,sari
                              .region_name cname';
                $box_info = $hotelModel->getBoxMacByHid($field, $where);

                $field = 'sum(play_count) plc,
                    sum(play_time) plt,mac,group_concat(`play_date`) pld';
                $starttime = date("Ymd", strtotime($starttime));
                $endtime = date("Ymd", strtotime($endtime));
                $where = '1=1';
                $mestaModel = new \Admin\Model\MediaStaModel();
                $where .= " AND media_id = ".$ads_media_id;
                $where .= "	AND play_date >= '{$starttime}'";
                $where .= "	AND play_date <= '{$endtime} '";
                $group = 'mac';
                $me_sta_arr = $mestaModel->getWhere($where, $field, $group);
                //二维数组合并
                $mp = array_column($me_sta_arr, 'mac');
                $me_sta_arr = array_combine($mp, $me_sta_arr);
                //var_dump($mestaModel->getLastSql());
                //dump($box_info);
                //dump($me_sta_arr);
                //获取电视数量
                //进行比较
                foreach ($box_info as $bk=>$bv) {
                    $map_mac = $bv['mac'];
                    //先判断是否存在
                    if(array_key_exists($map_mac, $tmp_box_tv)) {
                        $tmp_box_tv[$map_mac]['tv_count'] +=1;
                        continue;
                    }else {
                        if(array_key_exists($map_mac, $me_sta_arr)) {
                            $mv = $me_sta_arr[$map_mac];
                            $mv['pld'] = preg_replace('/(\s)*/','', $mv['pld']);
                            $day_arr = explode(',',$mv['pld']);
                            $day_arr = array_unique($day_arr);
                            sort($day_arr);
                            $day_str = implode(',', $day_arr);
                            $day_len = count($day_arr);
                            $tmp_box_tv[$map_mac]['cityname'] = $bv['cname'];
                            $tmp_box_tv[$map_mac]['hotel_name'] = $bv['name'];
                            $tmp_box_tv[$map_mac]['rname'] = $bv['rname'];
                            $tmp_box_tv[$map_mac]['play_count'] = $mv['plc'];
                            $tmp_box_tv[$map_mac]['play_time'] = $mv['plt'];
                            $tmp_box_tv[$map_mac]['play_days'] = $day_len;
                            $tmp_box_tv[$map_mac]['publication'] = $day_str;
                            $tmp_box_tv[$map_mac]['tv_count'] = 1;
                            $tmp_box_tv[$map_mac]['mac'] = $map_mac;
                            $tmp_box_tv[$map_mac]['box_name'] = $bv['box_name'];
                        }else{
                            $tmp_box_tv[$map_mac]['cityname'] = $bv['cname'];
                            $tmp_box_tv[$map_mac]['rname'] = $bv['rname'];
                            $tmp_box_tv[$map_mac]['hotel_name'] = $bv['name'];
                            $tmp_box_tv[$map_mac]['play_count'] = '';
                            $tmp_box_tv[$map_mac]['play_time'] = '';
                            $tmp_box_tv[$map_mac]['play_days'] = '';
                            $tmp_box_tv[$map_mac]['publication'] = '';
                            $tmp_box_tv[$map_mac]['tv_count'] = 1;
                            $tmp_box_tv[$map_mac]['mac'] = $map_mac;
                            $tmp_box_tv[$map_mac]['box_name'] = $bv['box_name'];
                            $tmp_box_tv[$map_mac]['hotel_id'] = $bv['hotelid'];
                        }
                        unset($me_sta_arr[$map_mac]);
                    }

                }
                $tmp_box_tv = array_reduce($tmp_box_tv, function($result, $item){
                    $result[$item['hotel_id']][] = $item;
                    return $result;
                });
                ksort($tmp_box_tv);
                $tmp_box_tv = array_reduce($tmp_box_tv, function($result, $item){
                    foreach($item as $k=>$vp){
                        $result[$vp['mac']] = $vp;
                    }
                    return $result;
                });
                $tmp_box_tv = array_values($tmp_box_tv);
            }

            //需要将传过来name与隐藏域进行对比再次确定它传过来的值是正确的
            //判断是否是广告列表中
        }else{
            $tmp_box_tv = array();
        }
        $xlsCell = array(
            array('cityname', '地区'),
            array('hotel_name', '酒楼名称'),
            array('rname', '包间名称'),
            array('box_name','机顶盒名称'),
            array('mac', 'mac'),
            array('tv_count', '电视数量'),
            array('play_count', '播出次数'),
            array('play_time', '播出时长'),
            array('play_days', '播出天数'),
            array('publication', '上刊日期')
        );
        $xlsName = 'contentads';
        $filename = 'contentads';
        $this->exportExcel($xlsName, $xlsCell, $tmp_box_tv,$filename);
    }

    /**
     *
     * 导出心跳相关数据
     */

    public function expheartlost(){
        /*
        导出所有涉及酒店而不根据心跳
        然后与心跳表  对比
        导出
        导出所有涉及酒店
        然后与心跳表  对比*/
        $time = time();
        $heartModel = new \Admin\Model\HeartLogModel();
        $areaModel  = new \Admin\Model\AreaModel();
        $hotel_box_type_arr = C('heart_hotel_box_type');
        $type = I('get.type');
        $main_v = I('get.main_v');
        $hbt_v = I('get.hbt_v');
        $name = I('get.name');
        $area_v = I('get.area_v');
        $areainfo = $areaModel->find($area_v);
        $arname = $areainfo['region_name'];
        $where = ' 1=1 and sht.state = 1 and sht.flag = 0 ';
        //小平台
        if($type == 1){
            $field = 'hex.mac_addr mac,h.hotel_box_type, h.name, hex.hotel_id';
            $xlsName = date("Ymd Hi",$time).$arname.' '.' 小平台心跳情况';
        }else{
            $field = 'b.mac, h.id hotel_id, h.name,h.hotel_box_type,h.remark,h.maintainer ';
            $xlsName = date("Ymd Hi",$time).$arname.' 机顶盒心跳情况';

        }

        if ($main_v) {
            $where .= "	AND sht.maintainer LIKE '%{$main_v}%' ";
        }
        if ($hbt_v) {
            $where .= "	AND sht.hotel_box_type = $hbt_v";
        }else{
            $where .= "	AND (sht.hotel_box_type = 2 or sht.hotel_box_type = 3)";
        }
        if ($area_v) {
            $where .= "	AND sht.area_id = $area_v ";
        }
        if($name){
            $where .= "	AND sht.name LIKE '%{$name}%' ";
        }
        $hboxlist = $heartModel->getAllBox($where,$field,$type);
        //file_put_contents(APP_PATH.'/Runtime/Logs/Admin/1527.txt',$heartModel->getLastSql().PHP_EOL,FILE_APPEND);
        if($type == 1){
            //获取机顶盒数
            foreach ($hboxlist as $rk=>$rv) {
                $number = $heartModel->getBoxNum($rv['hotel_id']);
                if($number==0){
                    unset($hboxlist[$rk]);
                }
            }
        }

        if($type == 1){
            $hfield = 'hotel_id,box_mac mac,max(`last_heart_time`) AS lt';
        }else{
            $hfield = 'hotel_id,sb.state bstate,sb.flag  boflag,box_mac mac,max(`last_heart_time`) AS lt';
        }

        $hearList  = $heartModel->getWhereData($hfield,$type);
        //file_put_contents(APP_PATH.'/Runtime/Logs/Admin/1527.txt',$heartModel->getLastSql().PHP_EOL,FILE_APPEND);
        if ($hboxlist) {
            if($type == 1){

                //获取心跳mac地址小平台
                //由于hotel_id不重复所以可以直接使用函数
                //做一个排重
                if ($hearList) {
                    $tmp = array();
                    foreach($hearList as $hk=>$hv){
                        if(in_array($hv['hotel_id'], $tmp)){
                            unset($hearList[$hk]);
                        }else if(empty($hv['mac'])){
                            unset($hearList[$hk]);
                        }
                        else{
                            $tmp[] = $hv['hotel_id'];
                        }
                        continue;
                    }
                    $h_arr = array_column($hearList, 'hotel_id');
                    $hearList = array_combine($h_arr, $hearList);
                    //flag 1:正常24以内2.24以外3.7天以外
                    //$hp = var_export($hearList,true);
                    foreach($hboxlist as $hk =>$hbv){
                        $hid = $hbv['hotel_id'];
                        if(array_key_exists($hid, $hearList)){
                            //计算时长
                            // dump($hid);
                            $l_time = strtotime($hearList[$hid]['lt']);
                            $ftime = $time-$l_time;
                            $hboxlist[$hk]['htime'] = $ftime;
                            //测试进行修改86400
                            if($ftime<86400){
                                $hboxlist[$hk]['flag'] = '1';
                                $hboxlist[$hk]['bflag'] = '0';
                                $hboxlist[$hk]['lost_time'] = '正常';
                                $hboxlist[$hk]['rate'] = '0';
                            }else if($ftime>604800){
                                $hboxlist[$hk]['flag'] = '0';
                                $hboxlist[$hk]['bflag'] = '1';
                                $hboxlist[$hk]['lost_time'] = '七天以上';
                                $hboxlist[$hk]['htime'] = '1893455000';
                                $hboxlist[$hk]['rate'] = '100%';
                            }else{
                                $hboxlist[$hk]['flag'] = '0';
                                $hboxlist[$hk]['bflag'] = '1';
                                $hboxlist[$hk]['lost_time'] = $this->sec2Time($ftime);
                                $hboxlist[$hk]['rate'] = '100%';
                            }
                        }else{

                            $hboxlist[$hk]['flag'] = '0';
                            $hboxlist[$hk]['bflag'] = '1';
                            $hboxlist[$hk]['htime'] = '1893456000';
                            $hboxlist[$hk]['lost_time'] = '七天以上';
                            $hboxlist[$hk]['rate'] = '100%';
                        }
                        $hboxlist[$hk]['total'] = 1;
                    }
                    $order_arr = array();
                    $order_arr_h = array();
                    foreach($hboxlist as $hval) {
                        $order_arr[] = $hval['htime'];
                        $order_arr_h[] = $hval['hotel_id'];

                    }

                    $arp = array();
                    $flag =0;
                    $bflag = 0;
                    $total = 0;
                    foreach($hboxlist as $hkk=>$hval) {
                        $flag += $hval['flag'];
                        $total += $hval['total'];
                        $bflag += $hval['bflag'];
                        foreach($hotel_box_type_arr as $hk=>$hv){
                            if($hk == $hval['hotel_box_type']){
                                $hboxlist[$hkk]['hotel_box_type'] = $hv;
                            }
                        }

                    }
                    $ce_len = count($hboxlist);
                    $arp['name'] = '总计'.$ce_len.'家酒楼';
                    $arp['hotel_box_type'] = '';
                    $arp['flag'] = $flag;
                    $arp['bflag'] = $bflag;
                    $arp['total'] = $total;
                    $arp['rate'] = round($bflag/$total*100).'%';
                    $arp['lost_time'] = '';
                    array_multisort($order_arr,SORT_DESC,$order_arr_h,SORT_ASC, $hboxlist);
                    array_unshift($hboxlist, $arp);
                }else{
                    foreach($hboxlist as $hk =>$hbv){
                        $hboxlist[$hk]['flag'] = '0';
                        $hboxlist[$hk]['bflag'] = '1';
                        $hboxlist[$hk]['htime'] = '1893456000';
                        $hboxlist[$hk]['lost_time'] = '七天以上';
                        $hboxlist[$hk]['rate'] = '100%';
                        $hboxlist[$hk]['total'] = 1;
                    }
                    $arp = array();
                    $flag =0;
                    $bflag = 0;
                    $total = 0;
                    foreach($hboxlist as $hkk=>$hval) {
                        $flag += $hval['flag'];
                        $total += $hval['total'];
                        $bflag += $hval['bflag'];
                        foreach($hotel_box_type_arr as $hk=>$hv){
                            if($hk == $hval['hotel_box_type']){
                                $hboxlist[$hkk]['hotel_box_type'] = $hv;
                            }
                        }

                    }
                    $ce_len = count($hboxlist);
                    $arp['name'] = '总计'.$ce_len.'家酒楼';
                    $arp['hotel_box_type'] = '';
                    $arp['flag'] = $flag;
                    $arp['bflag'] = $bflag;
                    $arp['total'] = $total;
                    $arp['rate'] = round($bflag/$total*100).'%';
                    $arp['lost_time'] = '';
                    array_multisort($order_arr,SORT_DESC,$order_arr_h,SORT_ASC, $hboxlist);
                    array_unshift($hboxlist, $arp);
                }
                $xlsCell = array(
                    array('name', '酒楼名称'),
                    array('hotel_box_type', '小平台类型'),
                    array('flag', '正常'),
                    array('bflag', '异常'),
                    array('total', '总计'),
                    array('rate', '异常率(%)'),
                    array('lost_time', '失联时长'),
                );
            }else{
                //同样做排重
                $new_arr_heart = array();
                $heart_all = array();
                $nsp = array();
                if ($hearList) {
                    $tmp = array();
                   // $hearListpp = var_export($hearList, true);
                   //  file_put_contents(APP_PATH.'/Runtime/Logs/Admin/1527.txt',$hearListpp.PHP_EOL,FILE_APPEND);
                    foreach($hearList as $hk=>$hv){
                        if(in_array($hv['mac'], $tmp)){
                            unset($hearList[$hk]);
                        }else if($hv['bstate'] != 1 || $hv['boflag'] != 0) {
                            unset($hearList[$hk]);
                        } else {
                            $tmp[] = $hv['mac'];
                        }
                        continue;
                    }
                    foreach($hearList as $hv){
                        $new_arr_heart[$hv['hotel_id']][] = $hv;
                    }
                    foreach($hboxlist as $hbv){
                        $heart_all[$hbv['hotel_id']][] = $hbv;
                    }
                    $nsp = array();
                    foreach ($heart_all as $hea=>$hev){
                        $aflag = 0;
                        $bflag = 0;
                        $total = 0;
                        if(array_key_exists($hea, $new_arr_heart)){
                            //再运算
                            $orign = $hev;
                            $comp_arr = $new_arr_heart[$hea];
                            $orign_mac  = array_column($orign, 'mac');
                            $comp_mac = array_column($comp_arr, 'mac');

                            $len = count(array_diff($orign_mac, $comp_mac));
                            $co_ar_len = count($comp_arr);
                            $bflag = $len;
                            //获取心跳中不超过一天的,得到正常值
                            $aflag = $this->filtertime($comp_arr, $time);
                            //心跳
                            $fail_count = $bflag + $co_ar_len - $aflag;
                            $total = count($orign);
                            $nsp[$hea]['flag'] = $aflag;
                            $nsp[$hea]['bflag'] = $fail_count;
                            $nsp[$hea]['total'] = $total;
                            $nsp[$hea]['rate'] = round($fail_count/$total*100);
                        }else{
                            //根本不存在
                            $nsp[$hea]['flag'] = 0;
                            $nsp[$hea]['bflag'] = count($hev);
                            $nsp[$hea]['total'] = $nsp[$hea]['bflag'];
                            $nsp[$hea]['rate'] = '100';
                        }
                        $nsp[$hea]['maintainer'] = $hev[0]['maintainer'];
                        $nsp[$hea]['name'] = $hev[0]['name'];
                        $nsp[$hea]['hotel_box_type'] = $hev[0]['hotel_box_type'];
                        $nsp[$hea]['remark'] = $hev[0]['remark'];
                        $nsp[$hea]['hotelid'] = $hea;
                    }
                    $flag = 0;
                    $bflag = 0;
                    $total = 0;
                    $order_arr = array();
                    $order_arr_h = array();
                    foreach($nsp as $nval) {
                        $flag += $nval['flag'];
                        $total += $nval['total'];
                        $bflag += $nval['bflag'];

                    }
                    foreach($nsp as $hval) {
                        $order_arr[] = $hval['rate'];
                        $order_arr_h[] = $hval['hotelid'];
                    }
                    $ca_len = count($nsp);
                    $arp = array();
                    $arp['name'] = '总计'.$ca_len.'家酒楼';
                    $arp['flag'] = $flag;
                    $arp['bflag'] = $bflag;
                    $arp['total'] = $total;
                    $arp['rate'] = round($bflag/$total*100);
                    $arp['maintainer'] = '';
                    $arp['hotel_box_type'] = '';
                    $arp['remark'] = '';
                    array_multisort($order_arr,SORT_DESC,$order_arr_h,SORT_ASC, $nsp);
                    array_unshift($nsp, $arp);
                    foreach($nsp as $nk=>$nv){
                        foreach($hotel_box_type_arr as $hk=>$hv){
                            if($hk == $nv['hotel_box_type']){
                                $nsp[$nk]['hotel_box_type'] = $hv;
                            }
                        }
                        $nsp[$nk]['rate'] = $nsp[$nk]['rate'] .'%';


                    }

                    $hboxlist = $nsp;
                }else{
                    foreach($hboxlist as $hbv){
                        $heart_all[$hbv['hotel_id']][] = $hbv;
                    }
                    $nsp = array();
                    foreach ($heart_all as $hea=>$hev) {
                        $aflag = 0;
                        $bflag = 0;
                        $total = 0;
                        //根本不存在
                        $nsp[$hea]['flag'] = 0;
                        $nsp[$hea]['bflag'] = count($hev);
                        $nsp[$hea]['total'] = $nsp[$hea]['bflag'];
                        $nsp[$hea]['rate'] = '100';

                        $nsp[$hea]['maintainer'] = $hev[0]['maintainer'];
                        $nsp[$hea]['name'] = $hev[0]['name'];
                        $nsp[$hea]['hotel_box_type'] = $hev[0]['hotel_box_type'];
                        $nsp[$hea]['remark'] = $hev[0]['remark'];
                        $nsp[$hea]['hotelid'] = $hea;
                    }
                    $flag = 0;
                    $bflag = 0;
                    $total = 0;
                    $order_arr = array();
                    $order_arr_h = array();
                    foreach($nsp as $nval) {
                        $flag += $nval['flag'];
                        $total += $nval['total'];
                        $bflag += $nval['bflag'];

                    }
                    foreach($nsp as $hval) {
                        $order_arr[] = $hval['rate'];
                        $order_arr_h[] = $hval['hotelid'];
                    }
                    $ca_len = count($nsp);
                    $arp = array();
                    $arp['name'] = '总计'.$ca_len.'家酒楼';
                    $arp['flag'] = $flag;
                    $arp['bflag'] = $bflag;
                    $arp['total'] = $total;
                    $arp['rate'] = round($bflag/$total*100);
                    $arp['maintainer'] = '';
                    $arp['hotel_box_type'] = '';
                    $arp['remark'] = '';
                    array_multisort($order_arr,SORT_DESC,$order_arr_h,SORT_ASC, $nsp);
                    array_unshift($nsp, $arp);
                    foreach($nsp as $nk=>$nv){
                        foreach($hotel_box_type_arr as $hk=>$hv){
                            if($hk == $nv['hotel_box_type']){
                                $nsp[$nk]['hotel_box_type'] = $hv;
                            }
                        }
                        $nsp[$nk]['rate'] = $nsp[$nk]['rate'] .'%';


                    }
                    $hboxlist = $nsp;
                }
                $xlsCell = array(
                    array('name', '酒楼名称'),
                    array('maintainer', '维护人'),
                    array('hotel_box_type', '机顶盒类型'),
                    array('flag', '正常'),
                    array('bflag', '异常'),
                    array('total', '总计'),
                    array('rate', '异常率(%)'),
                    array('remark', '酒楼备注')
                );
            }
        }else{
            $hboxlist = array();
        }
        if(empty($hboxlist)){
            if($type == 1){
                $xlsCell = array(
                    array('name', '酒楼名称'),
                    array('hotel_box_type', '小平台类型'),
                    array('flag', '正常'),
                    array('bflag', '异常'),
                    array('total', '总计'),
                    array('rate', '异常率(%)'),
                    array('lost_time', '失联时长'),
                );
                $hboxlist[0]['name'] = '总计0家酒楼';
                $hboxlist[0]['flag'] = '';
                $hboxlist[0]['bflag'] = '';
                $hboxlist[0]['total'] = '';
                $hboxlist[0]['rate'] = '';
                $hboxlist[0]['hotel_box_type'] = '';
                $hboxlist[0]['lost_time'] = '';

            }else{
                $xlsCell = array(
                    array('name', '酒楼名称'),
                    array('maintainer', '维护人'),
                    array('hotel_box_type', '机顶盒类型'),
                    array('flag', '正常'),
                    array('bflag', '异常'),
                    array('total', '总计'),
                    array('rate', '异常率(%)'),
                    array('remark', '酒楼备注')
                );
                $hboxlist[0]['name'] = '总计0家酒楼';
                $hboxlist[0]['flag'] = '';
                $hboxlist[0]['bflag'] = '';
                $hboxlist[0]['total'] = '';
                $hboxlist[0]['rate'] = '';
                $hboxlist[0]['maintainer'] = '';
                $hboxlist[0]['hotel_box_type'] = '';
                $hboxlist[0]['remark'] = '';
            }

        }
        foreach($hboxlist as $hkk=>$hv){
            if(strstr ($hv['name'],'永峰') || strstr ($hv['name'],'茶室')){

                //小平台
                if($type == 1) {
                    if ($hv['lost_time'] == '正常'){
                        $hboxlist[0]['flag'] = $hboxlist[0]['flag']- 1;
                    }else{
                        $hboxlist[0]['bflag'] = $hboxlist[0]['bflag']- 1;
                    }
                    $hboxlist[0]['total'] = $hboxlist[0]['total']- 1;
                }else{
                    $hboxlist[0]['bflag'] = $hboxlist[0]['bflag']- $hv['bflag'];
                    $hboxlist[0]['total'] = $hboxlist[0]['total']- $hv['total'];
                    $hboxlist[0]['flag'] = $hboxlist[0]['flag']- $hv['flag'];
                }
                unset($hboxlist[$hkk]);
            }else{
                if($type == 1) {

                }
            }
        }


        $len = count($hboxlist) - 1;
        $hboxlist[0]['name'] = '总计'.$len.'家酒楼';
        $hboxlist[0]['rate'] = round($hboxlist[0]['bflag']/$hboxlist[0]['total']*100).'%';

        $hboxlist = array_values($hboxlist);
        if (count($hboxlist) == 1) {
            $hboxlist[0]['rate'] = '';
            $hboxlist[0]['flag'] = '';
            $hboxlist[0]['bflag'] = '';
            $hboxlist[0]['total'] = '';
        }
        $filename = 'heartlostinfo';
        $this->exportExcel($xlsName, $xlsCell, $hboxlist,$filename);

    }

    public function filtertime($comp_arr, $time){
        $rs =  array_filter($comp_arr, function ($val)
                use($time) {
                            if ( $time-strtotime($val['lt']) < 86400) {
                                    return true;
                            }else{
                                return false;
                            }
                });
        //得到正常值
       $count = count($rs);
        return $count;
    }

    public function sec2Time($time){
            if(is_numeric($time)){
                $value = array(
                    "days" => 0, "hours" => 0,
                    "minutes" => 0, "seconds" => 0,
                );

            if($time >= 86400){
                $value["days"] = floor($time/86400);
                $time = ($time%86400);
            }
            if($time >= 3600){
                $value["hours"] = floor($time/3600);
                $time = ($time%3600);
            }
            if($time >= 60){
                $value["minutes"] = floor($time/60);
                $time = ($time%60);
            }
            $value["seconds"] = floor($time);
            //return (array) $value;
            $t= $value["days"] ."天"." ". $value["hours"] ."小时". $value["minutes"] ."分";
            Return $t;

        }else{
            return (bool) FALSE;
        }
    }
    /**
     *
     * 导出Excel
     */

    function expboxreportinfo(){
        $filename = 'boxlostreport';
        $dtype = I('get.datetype');

            if ( $dtype == 1) {
                $table = 'heart_count_year';
                $time = date("Y",time());
            } else if ($dtype == 2) {
                $table = 'heart_count_month';
                $time = date("Y-m",time());
            } else if ($dtype == 3) {
                $table = 'heart_count_day';
                $time = date("Y-m-d",time()-86400);

            } else if ($dtype == 4) {
                $table = 'heart_count';
                $starttime = I('get.start','');
                $endtime = I('get.end','');
            }
        $boxreModel =  new \Admin\Model\BoxReportModel($table);
        $where = '1=1 ';
        if($dtype == 4) {
            if($starttime){
                $where .= "	AND time >= '{$starttime}'";
            }
            if($endtime){
                $where .= "	AND time <=  '{$endtime}'";
            }

        } else {

                $where .= "	AND time= '{$time}' ";

        }
        $hname = I('get.hname','');
        if($hname){
            $where .= "	AND hotel_name LIKE '%{$hname}%'";
        }
        $orders = '';
        $rea = $boxreModel->getAllList($where,$orders);
        $box_arr = $rea['list'];
        foreach($box_arr as &$val) {
            if($val['type'] == 1) {
                $val['type'] = '小平台';
                continue;
            }else if($val['type'] == 2){
                $val['type'] = '机顶盒';
                continue;
            }
        }
        $xlsName = "boxreport";
        $xlsCell = array(
            array('box_id', '机顶盒ID'),
            array('box_mac', '机顶盒MAC'),
            array('box_name', '机顶盒名称'),
            array('room_id', '包间ID'),
            array('room_name', '包间名称'),
            array('hotel_id', '酒楼ID'),
            array('hotel_name', '酒楼名称'),
            array('area_id', '区域ID'),
            array('area_name', '区域名称'),
            array('count', '计数'),
            array('type', '类型'),
            array('time', '时间'),
        );

        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }


    /**
     *
     * 导出Excel
     */

    function expfirstmd(){
        $filename = 'first_mobile_download';
        $dtype = I('get.datetype');
        $starttime = I('start','');
        $endtime = I('end','');
        $table = 'first_mobile_download';
        $tuiModel =  new \Admin\Model\TuiRpModel($table);
        $where = '1=1 and time is not null';
        if($starttime){
            $where .= "	AND time >= '{$starttime}'";
        }
        if($endtime){
            $where .= "	AND time <=  '{$endtime}'";
        }
        $hname = I('get.hname','');
        if($hname){
            $where .= "	AND hotel_name LIKE '%{$hname}%'";
        }
        $orders = 'time,hotel_id';
        //$group =  'hotel_id';
        $field = '`download_count` as   dct,hotel_name,time';
        $rea = $tuiModel->getAllList($where, $field, $group, $orders);
        $box_arr = $rea['list'];
        
        $xlsName = "firstmobiledown";
        $xlsCell = array(
            array('hotel_name', '酒店名称'),
            
            array('dct', '首次打开（次）'),
            
            array('time', '时间'),
        );
        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }


    function expint_final(){
        $filename = 'mobile_interaction_final';
        $dtype = I('get.datetype');
        $starttime = I('start','');
        $endtime = I('end','');
        $table = 'first_mobile_interaction_final';
        $tuiModel =  new \Admin\Model\TuiRpModel($table);
        $where = '1=1 ';
        if($starttime){
            $where .= "	AND date_time >= '{$starttime}'";
        }
        if($endtime){
            $where .= "	AND date_time <=  '{$endtime}'";
        }
        $hname = I('get.hname','');
        if($hname){
            $where .= "	AND hotel_name LIKE '%{$hname}%'";
        }
        $orders = ' date_time,hotel_id asc';
        //$group =  'hotel_name,box_name';
        $field = 'count,hotel_name,box_name,date_time';
        $rea = $tuiModel->getAllList($where, $field, $group, $orders);
        $box_arr = $rea['list'];
        $xlsName = "screencastreport";
        $xlsCell = array(
            array('hotel_name', '酒店名称'),
            array('box_name', '机顶盒名称'),
            array('count', '首次连接（次）'),

            array('date_time', '时间'),
        );
        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }

    function expscreenrep(){
        ini_set ('memory_limit', '512M');

        $filename = 'screencastreport';
        $dtype = I('get.datetype');
        if ( $dtype == 1) {
            $table = 'mobile_statistic_year';
            $time = date("Y",time());
        } else if ($dtype == 2) {
            $table = 'mobile_statistic_month';
            $time = date("Y-m",time());
        } else if ($dtype == 3) {
            $table = 'mobile_statistic_date';
            $time = date("Y-m-d",time()-86400);

        } else if ($dtype == 4) {
            $table = 'mobile_statistic_date_all';
            $starttime = I('start','');
            $endtime = I('end','');
        } else if ($dtype == 5) {
            $table = 'mobile_statistic';
        }
        $screenModel =  new \Admin\Model\ScreenRpModel($table);
        $where = '1=1 ';
        if($dtype == 4) {
            if($starttime){
                $where .= "	AND time >= '{$starttime}'";
            }
            if($endtime){
                $where .= "	AND time <=  '{$endtime}'";
            }

        } else {
            if($dtype!=5) {
                $where .= "	AND time= '{$time}' ";
            }
        }
        $hname = I('get.hname','');
        if($hname){
            $where .= "	AND hotel_name LIKE '%{$hname}%'";
        }
        $orders = '';
        $rea = $screenModel->getAllList($where,$orders);
        foreach ($rea['list'] as &$val) {
            if(empty($val['project_count'])){
                $val['project_count'] = 0;
            }
            if(empty($val['demand_count'])){
                $val['demand_count'] = 0;
            }
            if($dtype == 5) {
                $val['time'] = 0;
            }
        }
        $box_arr = $rea['list'];
        $xlsName = "screencastreport";
        $xlsCell = array(

            array('box_mac', '机顶盒MAC'),
            array('box_name', '机顶盒名称'),

            array('room_name', '包间名称'),

            array('hotel_name', '酒楼名称'),

            array('area_name', '区域名称'),
            array('mobile_id', '手机标识'),
            array('project_count', '投屏次数'),
            array('demand_count', '点播次数'),
            array('time', '时间'),
        );
        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }


    function expdownloadcount(){
        $filename = 'downloadcount';
        $dtype = I('get.datetype');
        $downloadModel =  new \Admin\Model\DownloadRpModel();
        $where = '1=1 ';
        $starttime = I('start','');
        $endtime = I('end','');
        if($starttime){
            $where .= "	AND add_time >= '{$starttime}'";
        }
        if($endtime){
            //$where .= "	AND add_time <=  '{$endtime}'";
            $where .= "	AND add_time <=  '{$endtime} 23:59:59'";
        }
        $soucetype = I('get.sourcetype','');
        if($soucetype){
            $where .= "	AND source_type =   '{$soucetype}'";
        }
        $orders = '';
        $rea = $downloadModel->getAllList($where,$orders);
        $so_type = C('source_type');
        $cltype = array(
            '1'=>'android',
            '2'=>'ios',
        );
        $dowload_device_typ = array(
            '1'=>'android',
            '2'=>'ios',
            '3'=>'pc',
        );

        foreach ($rea['list'] as &$val) {
            foreach($cltype as $k=>$v){
                if($k == $val['clientid']){
                    $val['clientid'] = $v;
                }
            }
            foreach($dowload_device_typ as $k=>$v){
                if($k == $val['dowload_device_id']){
                    $val['dowload_device_id'] = $v;
                }
            }

            foreach($so_type as $k=>$v){
                if($k == $val['source_type']){
                    $val['source_type'] = $v;
                }
            }

        }
        $box_arr = $rea['list'];
        $xlsName = "downloadcountreport";
        $xlsCell = array(
            array('source_type', '来源'),
            array('clientid', '手机客户端'),

            array('deviceid', '设备唯一标识'),

            array('dowload_device_id', '点击下载设备'),

            array('hotelid', '酒楼id'),
            array('waiterid', '服务员id'),
            array('add_time', '添加时间'),
        );
        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }

    function expappscreen(){
        $filename = 'appcreen';
        $downloadModel =  new \Admin\Model\AppscreenRpModel();
        $where = '1=1 ';
        $starttime = I('start','');
        $endtime = I('end','');
        if($starttime){
            $sttime = strtotime($starttime);
            $where .= "	AND substring(`timestamps`,0,-3) >= '{$sttime}'";
        }
        if($endtime){
            $etime = strtotime($endtime);
            $where .= "	AND substring(`timestamps`,0,-3) <=  '{$etime}'";
        }


        $orders = 'timestamps desc';
        $rea = $downloadModel->getAllList($where,$orders);
        foreach($rea['list'] as &$val){
            $val['addtime'] = date("Y-m-d",substr($val['timestamps'],0,-3));

        }


        $box_arr = $rea['list'];
        $xlsName = "appcreenreport";
        $xlsCell = array(
            array('area_name', '区域名称'),
            array('hotel_name', '酒楼名称'),

            array('room_name', '包间名称'),

            array('box_name', '机顶盒名称'),

            array('box_mac', '机顶盒mac'),
            array('mobile_id', '手机唯一标识id'),
            array('vcount', '点播次数'),
            array('vtime', '点播时长'),
            array('pcount', '投屏次数'),
            array('ptime', '投屏时长'),
            array('addtime', '添加时间'),
        );
        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }

    function expdeviceinfo(){

        //设备故障数
        $hotel_box_type = C('hotel_box_type');
        $box_state = C('HOTEL_STATE');
        $box_fl = array (
            '0'=>'正常',
            '1'=>'删除',
        );
        $boxModel = new \Admin\Model\BoxModel();
        foreach($hotel_box_type as $hb=>$hv) {

            $map = array();
            $map['sht.hotel_box_type'] = $hb;
            $asm = array();
            foreach($box_fl as $k=>$v) {

                $map['box.flag'] = $k;
                foreach($box_state as $bk=>$bv) {
                    $map['box.state'] = $bk;
                    $box_count = $boxModel->alias('box')
                        ->join(' join savor_room rom on rom.id= box.room_id')
                        ->join(' join savor_hotel sht on sht.id = rom.hotel_id')
                        ->where($map)->count();
                    echo $hv.' '.'冻结状态'.$bv.' 删除状态'.$v.'  机顶盒'.$box_count.'个'.'<br/>';
                    $asm[] = $box_count;
                }

            }
            echo $hv.'机顶盒'.array_sum($asm).'个'.'<br/>';
        }


        $map['sht.flag'] = 0;
        $map['sht.state'] = 1;
        $map['rom.flag'] = 0;
        $map['rom.state'] = 1;

        //每日开机数
        //算日期间隔
        $now = date("Y-m-d");
        $yes = date("Y-m-d", strtotime("today") - 604800);
        $dat_diff = $this->prDates($yes, $now);
        $heartLogModel = new \Admin\Model\HeartLogModel();
        $btype = array(
            '1'=>'小平台',
            '2'=>'机顶盒',
        );

        foreach($btype as $bt=>$bv) {
            $map = array();
            $map['type'] = $bt;
            $lo_arr = array();
            /*foreach($dat_diff as $dk=>$dv) {

                $map['DATE_FORMAT(`last_heart_time`,"%Y-%m-%d")'] = $dv;

                $box_num = $heartLogModel->where($map)->count();
                $lo_arr[] = $box_num;
            }*/
            $box_num = $heartLogModel->where($map)->count();
            echo $bv.'每日开机数'.$box_num.'个'.'<br/>';

        }

        ob_end_clean();
        //导出失陪30天
        //获取所有二代网络5G机顶盒
        $map = array();
        $map['sht.hotel_box_type'] = array('in', array('2','3'));
        $map['box.flag'] = 0;
        $box_id_arr = $boxModel->alias('box')
            ->field('box.id,box.name bname,sht.name hotel_name')
            ->join(' join savor_room rom on rom.id= box.room_id')
            ->join(' join savor_hotel sht on sht.id = rom.hotel_id')
            ->where($map)
            ->select();
        $map = array();
        $map['hear.type'] = 2;
        $box_arr = $heartLogModel->alias('hear')
            ->join(' savor_box box on box.id= hear.box_id')
            ->where($map)->field('hear.box_id')->select();

        $box_arr_hear = array_column($box_arr, 'box_id');
        foreach($box_id_arr as $bk=>$bv) {
            if(in_array($bv['id'], $box_arr_hear)) {
                unset($box_id_arr[$bk]);
                continue;
            }else{
                unset($box_id_arr[$bk]['id']);
            }
            $box_id_arr[$bk]['apk_version'] = '';

        }
        $box_arr = array_values($box_id_arr);

        $filename = 'box_lost_version_condition';
        $xlsName = "boxlostversioncondition";


       /* //报表导出数据
        $map = array();
        $map['hear.type'] = 2;
        $box_arr = $heartLogModel->alias('hear')
        ->join(' savor_box box on box.id= hear.box_id')
        ->where($map)->field('hotel_name,
        apk_version,box.name bname')->select();
        $filename = 'box_version_condition';
        $xlsName = "boxversioncondition";

        */
        $xlsCell = array(
            array('bname', '机顶盒名称'),
            array('hotel_name', '酒楼名称'),
            array('apk_version', '版本号'),
        );
        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);
    }


    function prDates($start,$end){
        $dat = array();
        $dt_start = strtotime($start);
        $dt_end = strtotime($end);
        while ($dt_start<=$dt_end){
            $dat[] = date('Y-m-d',$dt_start);
            $dt_start = strtotime('+1 day',$dt_start);
        }
        return $dat;
    }


    function exphotelscreen(){
        $filename = 'hotelscreen';
        $hscreenModel =  new \Admin\Model\HotelscreenRpModel();
        $where = '1=1 ';
        $starttime = I('start','');
        $endtime = I('end','');
        if($starttime){

            $where .= "	AND (`play_date`) >= '{$starttime}'";
        }
        if($endtime){
            $where .= "	AND (`play_date`) <=  '{$endtime}'";
        }


        $orders = 'id desc';
        $rea = $hscreenModel->getAllList($where,$orders);
        foreach($rea['list'] as &$val){


        }
        $box_arr = $rea['list'];
        $xlsName = "hotelcreenreport";
        $xlsCell = array(
            array('area_name', '区域名称'),
            array('hotel_name', '酒楼名称'),
            array('room_name', '包间名称'),
            array('mac', '机顶盒mac'),
            array('ads_name', '广告名称'),
            array('plc', '播放次数'),
            array('dur', '播放时长'),
            array('play_date', '播放日期'),
        );
        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }

    /*
     *餐厅端目前已经绑定酒楼数据
     */
    function exphotelinvitecode() {
        $filename = 'bind_invite_hotel_info';
        $fileds = 'a.code invite_code,a.bind_mobile, a.bind_time,ht.name hname';
        $where = ' a.state=1 and a.flag = 0';

        $orders = 'a.hotel_id desc';
        $m_hotel_invite_code = new \Admin\Model\HotelInviteCodeModel();
        $list = $m_hotel_invite_code->getInviteExcel($fileds,$where,$orders);
        $xlsName = "bindhotelinfo";
        $xlsCell = array(
            array('hname', '酒楼名称'),
            array('invite_code', '邀请码'),
            array('bind_mobile', '绑定手机号'),
            array('bind_time', '绑定时间'),
        );
        foreach($list as &$val){
            $val['bind_mobile'] = $val['bind_mobile'].' ';
        }

        $this->exportExcel($xlsName, $xlsCell, $list,$filename);

    }
    /*
         *餐厅端投屏日志
         */
    function expdinnerappLog(){
        $filename = 'dinnerapp_hall_log';
        $hallModel =  new \Admin\Model\DinnerHallLogModel();
        $where = '1=1 ';
        $starttime = '2017-12-18 00:00:00';
        $endtime = date("Y-m-d H:i:s");
        if($starttime){

            $where .= "	AND dhlog.(`create_time`) >= '{$starttime}'";
        }
        if($endtime){
            $where .= "	AND dhlog.(`create_time`) <=  '{$endtime}'";
        }
        $where .= " AND dhlog.hotel_id != 7 ";


        $orders = 'dhlog.id desc';
        $rea = $hallModel->getAllList($where,$orders);
        $touping_config = array (
            '1'=>'特色菜',
            '2'=>'宣传片',
            '3'=>'照片',
            '4'=>'视频',
            '5'=>'欢乐词',
        );
        $cli_arr = array('3'=>'android','4'=>'ios');
        foreach($rea as &$val){
            if($val['screen_result'] == 1) {
                $val['screen_result'] = '成功';
            }
            if($val['screen_result'] == 1) {
                $val['screen_result'] = '失败';
            }
            $sty = $val['screen_type'];
            $val['screen_type'] = array_key_exists($sty,
            $touping_config)?$touping_config[$sty]:'';
            $dty = $val['device_type'];
            //加空格可以防止过长显示不完整或者不识别
            $val['mobile'] = $val['mobile'].' ';
            $val['device_id'] = $val['device_id'].' ';
            $val['device_type'] = $cli_arr[$dty];
            $temp = '';
            if($val['info']) {
                $ainfo = json_decode($val['info'], true);
                if( isset($ainfo['single_play']) ) {
                    $temp .= "单个投屏时间:".$ainfo['single_play']."秒,";
                }
                if( isset($ainfo['loop_time']) ) {
                    $temp .= "总投屏时长:".$ainfo['loop_time']."秒,";
                }
                if( isset($ainfo['loop']) ) {
                    if($ainfo['loop'] == 0) {
                        $temp .= "不循环";
                    }
                    if($ainfo['loop'] == 1) {
                        $temp .= "循环";
                    }

                }
                $val['info'] = $temp;
            }
        }
        $xlsName = "dinnerapphalllog";
        $xlsCell = array(
            array('mobile', '手机号'),
            array('invite_code', '邀请码'),
            array('hotel_name', '酒楼名称'),
            array('room_name', '包间名称'),
            array('wew', '欢迎词'),
            array('wet', '欢迎词模版'),
            array('screen_result', '投屏是否成功'),
            array('screen_type', '投屏功能'),
            array('device_type', '设备类型'),
            array('device_id', '设备唯一标识'),
            array('screen_num', '投屏数量'),
            array('screen_time', '投屏总时长'),
            array('info', '投屏设置'),
            array('create_time', '上报时间'),
        );
        $this->exportExcel($xlsName, $xlsCell, $rea,$filename);

    }


    function hotelinfo()
    {//导出Excel
        $boxModel = new \Admin\Model\BoxModel();
        //获取所有数据
        $box_arr = $boxModel->getExNum();
        $filename = 'hotel';
        $xlsName = "User";
        $xlsCell = array(
            array('id', '酒楼id'),
            array('install_date', '安装日期'),
            array('boxstate', '机顶盒状态'),
            array('mac', '机顶盒mac地址'),
            array('rname', '包间名称'),
            array('rtype', '包间类型'),
            array('tbrd', '品牌'),
            array('tsiz', '尺寸'),
            array('tv_source', '电视信号源'),
            array('hname', '酒店名称'),
            array('level', '酒店级别'),
            array('area_id', '酒店区域'),
            array('addr', '酒店地址'),
            array('contractor', '酒店联系人'),
            array('mobile', '手机'),
            array('tel', '固定电话'),
            array('iskey', '重点酒楼'),
            array('maintainer', '合作维护人'),
            array('tech_maintainer', '技术运维人'),
        );

        $this->exportExcel($xlsName, $xlsCell, $box_arr,$filename);

    }



    public function testList()
    {
        //实例化redis
        //         $redis = SavorRedis::getInstance();
        //         $redis->set($cache_key, json_encode(array()));
        $this->display('index');
    }

    public function daorudianping()
    {
        vendor("PHPExcel.PHPExcel.IOFactory");
        $filetmpname = APP_PATH . '../public/2.xls';
        $objPHPExcel = \PHPExcel_IOFactory::load($filetmpname);
        $arrExcel = $objPHPExcel->getSheet(0)->toArray();
        //删除不要的表头部分，我的有三行不要的，删除三次
        array_shift($arrExcel);
        // array_shift($arrExcel);
        // array_shift($arrExcel);//现在可以打印下$arrExcel，就是你想要的数组啦
        //  $arrExcel = array_slice($arrExcel,3,5);
        //查询数据库的字段
        $m = M('a2');
        $fieldarr = $m->query("describe savor_a2");
        foreach ($fieldarr as $v) {
            $field[] = $v['field'];
        }
        array_shift($field);
        $field = array(
            0 => 'tel',
            1 => 'username',
        );
        var_dump($field);
        var_dump($arrExcel);
        //var_dump($arrExcel);
        foreach ($arrExcel as $k => $v) {
            if ($k == 1066) {
                break;
            }
            $fields[] = array_combine($field, $v);//将excel的一行数据赋值给表的字段
        }
        // var_dump($fields);

        //批量插入
        if (!$ids = $m->addAll($fields)) {
            //$this->error("没有添加数据");
            echo 'faile';
        } else {
            echo 'succes';
        }
        // $this->success('添加成功');
    }

    public function daoru()
    {
        vendor("PHPExcel.PHPExcel.IOFactory");
        $filetmpname = APP_PATH . '../public/2.xls';
        $objPHPExcel = \PHPExcel_IOFactory::load($filetmpname);
        $arrExcel = $objPHPExcel->getSheet(0)->toArray();
        //删除不要的表头部分，我的有三行不要的，删除三次
        array_shift($arrExcel);
        // array_shift($arrExcel);
        // array_shift($arrExcel);//现在可以打印下$arrExcel，就是你想要的数组啦
        //  $arrExcel = array_slice($arrExcel,3,5);
        //查询数据库的字段
        $m = M('a2');
        $fieldarr = $m->query("describe savor_a2");
        foreach ($fieldarr as $v) {
            $field[] = $v['field'];
        }
        array_shift($field);
        $field = array(
            0 => 'tel',
            1 => 'username',
        );
        var_dump($field);
        var_dump($arrExcel);
        //var_dump($arrExcel);
        foreach ($arrExcel as $k => $v) {
            if ($k == 1066) {
                break;
            }
            $fields[] = array_combine($field, $v);//将excel的一行数据赋值给表的字段
        }
        // var_dump($fields);

        //批量插入
        if (!$ids = $m->addAll($fields)) {
            //$this->error("没有添加数据");
            echo 'faile';
        } else {
            echo 'succes';
        }
        // $this->success('添加成功');
    }
    public function excelAppDownload(){
        $hotel_name = I('hotel_name','','trim');
        $guardian   = I('guardian','','trim');  
        $start_date = I('start_date');
        $end_date   = I('end_date');
        $where ='';
        $where =" and src in('box','mob','rq')";
        if(!empty($hotel_name)){
            $where .=" and hotel_name like '%".$hotel_name."%'";
        } 
        if(!empty($guardian)){
            $where .=" and guardian like '%".$guardian."%'";
        }
        if($start_date){
            $where .=" and date_time>='".$start_date."'";
        }
        if($end_date){
            $where .= " and date_time<='".$end_date."'";
        }
        
        $m_app_download = new \Admin\Model\AppDownloadModel();
        $download_list = $m_app_download->getDownloadHotel($where ,$order='date_time',$sort='desc');
         
        $data = array();
        foreach($download_list as $key=>$v){
             
            $data[$v['hotel_id']][] = $v;
        }
        
        $count = 0;
        $list = array();
        foreach($data as $key=>$val){
            $list[] = $val;
            $count ++;
        }
         
       
        $rts = array();
        $flag = 0;
        foreach($list as $key=>$val){
            $rts[$flag]['hotel_id']   = $val[0]['hotel_id'];
            $rts[$flag]['hotel_name'] = $val[0]['hotel_name'];
            $rts[$flag]['guardian']   = $val[0]['guardian'];
            //$rts[$flag]['end_date_time']  = $val[0]['date_time'];
            $c_count = count($val) -1;
            //$rts[$flag]['start_date_time'] = $val[$c_count]['date_time'];
            $rts[$flag]['quantum'] = $val[$c_count]['date_time']."--".$val[0]['date_time'];;
            $box = $mob = $rq = $arr = array();
             
            foreach($val as $k=>$v){
                 
                if($v['src'] =='box'){
                    $box[]=$v['mobile_id'];
                }else if($v['src']=='mob'){
                    $mob[] = $v['mobile_id'];
                }else if($v['src']=='rq'){
                    $rq[] = $v['mobile_id'];
                }
            }
            $rts[$flag]['box'] = $box;
            $rts[$flag]['mob'] = $mob;
            $rts[$flag]['rq']  = $rq;
        
             
            $arr = array_merge($box,$mob,$rq);
            $arr = array_unique($arr);
            $rts[$flag]['all'] = $arr;
            $rts[$flag]['box_num'] = count($box);
            $rts[$flag]['mob_num'] = count($mob);
            $rts[$flag]['rq_num']  = count($rq);
            $rts[$flag]['all_num'] = count($arr);
            $flag ++;
        }  
        
        $filename = 'allappdownload';
        $xlsName = "allappdownload";
        $xlsCell = array(
            array('quantum', '时段'),
            array('hotel_name', '酒楼名称'),
            array('guardian', '维护人'),
            array('box_num', '首次投屏数量'),
            array('rq_num', '二维码扫描下载'),
            array('mob_num', '首次打开'),
            array('all_num', '去重后总计'),
        );
        $this->exportExcel($xlsName, $xlsCell, $rts,$filename);
        
    }
    public function excelContAndProm(){
        $where =' 1=1';
        
        /* $start_date = I('start_date');
        $end_date   = I('end_date');
        $userid = I('userid');
        $category_id = I('category_id','0','intval');
        $content_name = I('content_name','','trim');
        if($start_date && $end_date){
            if($end_date<$start_date){
                $this->error('结束时间不能小于开始时间');
            }
        }
        if($start_date){
            $this->assign('start_date',$start_date);
            $start_date = date('YmdH',strtotime($start_date));
            $where .= " and date_time >='".$start_date."'";
        }
        if($end_date){
            $this->assign('end_date',$end_date);
            $end_date = date('YmdH',strtotime($end_date));
            $where .= " and date_time <='".$end_date."'";
        }
        $m_sysuser = new \Admin\Model\UserModel();
        if($userid){
            $this->assign('username',$userid);
            $users = $m_sysuser->getUser(" and id=$userid",'id,username,remark');
            $userinfo = $users[0];
            if($userinfo){
                $where .=" and operators='".$userinfo['username']."' or operators='".$userinfo['remark']."'";
            }
        
        }
        if($category_id){
            $this->assign('category_id',$category_id);
            $where .=" and category_id=$category_id";
        } */
        $content_name = I('content_name','','trim');
        if($content_name){
            $this->assign('content_name',$content_name);
            $where .=" and content_name like '%".$content_name."%'";
        }
        
        $m_content_details_final = new \Admin\Model\ContDetFinalModel();
        $list = $m_content_details_final->getAll($where, "s_read_count desc ");
        
        $filename = 'allcontandprom';
        $xlsName = "allcontandprom";
        foreach($list as $key=>$v){
            if($v['common_value']==0){
                $list[$key]['common_value'] = '纯文本';
            }else if($v['common_value']==1){
                $list[$key]['common_value'] = '图文';
            }else if($v['common_value']==2){
                $list[$key]['common_value'] = '图集';
            }else if($v['common_value']==3){
                $list[$key]['common_value'] = '视频';
            }
            if(empty($v['s_read_count'])){
                $list[$key]['s_read_count'] = 0;
            }
            if(!empty($v['s_read_duration'])){
                $tmp = $list[$key]['s_read_duration']/ $list[$key]['s_read_count'];
                $list[$key]['avg_read_duration'] = changeTimeType($tmp);
            }else {
                $list[$key]['avg_read_duration'] = 0;
            }
            if(empty($v['s_read_duration'])){
                $list[$key]['s_read_duration'] = '0秒';
            }else {
                $list[$key]['s_read_duration'] = changeTimeType($v['s_read_duration']);
            }
            if(empty($v['s_demand_count'])){
                $list[$key]['s_demand_count'] = 0;
            }
            if(empty($v['s_share_count'])){
                $list[$key]['s_share_count'] = 0;
            }
            if(empty($v['s_pv_count'])){
                $list[$key]['s_pv_count'] = 0;
            }
            if(empty($v['s_uv_count'])){
                $list[$key]['s_uv_count'] = 0;
            }
            if(empty($v['s_click_count'])){
                $list[$key]['s_click_count'] = 0;
            }
            if(empty($v['s_outline_count'])){
                $list[$key]['s_outline_count'] = 0;
            }
            
            
        }
        $xlsCell = array(
            array('content_name', '文章标题'),
            array('category_name', '分类'),
            array('common_value', '内容类别'),
            array('operators', '编辑'),
            array('create_time', '创建时间'),
            array('s_read_count', '阅读总次数'),
            array('s_read_duration', '阅读总时长'),
            array('avg_read_duration','平均阅读市场'),
            array('s_demand_count', '点播总次数'),
            array('s_share_count', '分享总次数'),
            array('s_pv_count', 'PV'),
            array('s_uv_count', 'UV'),
            array('s_click_count', '点击数'),
            array('s_outline_count', '外链点击数'),
     
        );
        $this->exportExcel($xlsName, $xlsCell, $list,$filename);
    }
    public function importBillInfo()
    {
       //http://admin.rerdian.com/admin/excel/importBillInfo
        echo 'weeljrlwejr';
        die;
        vendor("PHPExcel.PHPExcel.IOFactory");
        $filetmpname = APP_PATH . '../Public/guang.xlsx';
        $objPHPExcel = \PHPExcel_IOFactory::load($filetmpname);
        $arrExcel = $objPHPExcel->getSheet(0)->toArray();
        
        //删除不要的表头部分，我的有三行不要的，删除三次
        array_shift($arrExcel);
        // array_shift($arrExcel);
        // array_shift($arrExcel);//现在可以打印下$arrExcel，就是你想要的数组啦
        //  $arrExcel = array_slice($arrExcel,3,5);
        //查询数据库的字段
        /* $m = M('a2');
        $fieldarr = $m->query("describe savor_a2");
        foreach ($fieldarr as $v) {
            $field[] = $v['field'];
        }
        array_shift($field);
        $field = array(
            0 => 'tel',
            1 => 'username',
        );
        var_dump($field);
        var_dump($arrExcel);
        //var_dump($arrExcel); */
        $m_hotel = new \Admin\Model\HotelModel();
        
        foreach ($arrExcel as $k => $v) {
            $data = $where = array();
            $info = $m_hotel->getHotelByIds($v['0']); 

            if(!empty($info) && $v['0']>0){
                $data['bill_per'] = $v['4'];
                $data['bill_tel'] = $v['5'];
                $where['id'] = $v['0'];
                //var_dump($data);
                //var_dump($where);
                $rt = $m_hotel->saveData($data, $where);
                //var_dump($rt);exit;
            }
        }
        echo "ok";
    }

    public function exphotelbillinfo(){
        $statementid = I('statementid',0);
        $statedetailModel = new \Admin\Model\AccountStatementDetailModel();
        $statenoticeModel = new \Admin\Model\AccountStatementNoticeModel();
        $filename = 'hotelbillinfo';
        $xlsName = "billinfo";
        $where = "1=1";
        $where .= " AND sdet.statement_id = ".$statementid;
        $orders = 'sdet.id asc';
        $result = $statedetailModel->getAll($where,$orders, 0,999);
        $notice_state = C('NOTICE_STATAE');
        $check_state = C('CHECK_STATAE');
        foreach ($result['list'] as &$val){

            if($val['state']!=1){
                $dinfo = $statedetailModel->find($val['detailid']);
                $val['name'] = $dinfo['hotel_name'];
                $val['money'] = $dinfo['money'];
                foreach($notice_state as $nh=>$nv){
                    if($nh == $val['state']) {
                        $val['state'] = $nv;
                    }
                }
                $val['check_status'] = '';
            }else{
                $dat['detail_id'] = $val['detailid'];
                $dat['f_type'] = 1;
                $notice_arr = $statenoticeModel->getWhere($dat);
                $nostus = $notice_arr['status'];
                if($nostus == 1){
                    $val['state'] = '发送成功';
                }else {
                    $val['state'] = '发送中';
                }
                foreach($check_state as $ch=>$cv){
                    if($ch == $val['check_status']) {
                        $val['check_status'] = $cv;
                    }
                }
            }


        }

        $xlsCell = array(
            array('hotelid', '酒楼id'),
            array('name', '酒楼名称'),
            array('money', '金额'),
            array('state', '通知状态'),
            array('check_status', '对账状态'),
        );

        $this->exportExcel($xlsName, $xlsCell, $result['list'],$filename);
    }
    public function excelToothwash(){
        $m_activity_data = new \Admin\Model\ActivityDataModel();
        //$infos = $m_activity_data->getInfo('*','',' add_time desc','',2);
        $infos = $m_activity_data->getAllInfo('a.*,b.name as act_name,c.goods_name,c.goods_price','','add_time desc');
        $xlsCell = array(
            array('id', 'id'),
            array('receiver', '收货人'),
            array('mobile', '电话'),
            array('address', '收货地址'),
            array('act_name','活动名称'),
            array('goods_name','商品名称',''),
            array('goods_nums','购买数量'),
            array('goods_price','商品单价'),
            array('add_time', '下单时间'),
            array('sourceid','来源')
        );
        $activity_source_arr = C('ACTIVITY_SOURCE_ARR');
        foreach($infos as $key=>$v){
            $infos[$key]['sourceid'] = $activity_source_arr[$v['sourceid']];
        }
        $xlsName = '活动订单';
        $filename = 'toothwash';
        $this->exportExcel($xlsName, $xlsCell, $infos,$filename);
    }
    public function excelHotelBv(){
        $m_hotel = new \Admin\Model\HotelModel();
        $m_area_info = new \Admin\Model\AreaModel();
        $where =array();
        $where['hotel_box_type'] = 3;
        $where['state'] = 1;
        $where['flag']  = 0;
        
        $info = $m_hotel->getWhereData($where,'id,name,area_id,addr');
        foreach($info as $key=>$v){
            $area_info = $m_area_info->field('region_name')->where('id='.$v['area_id'])->find();
            $info[$key]['region_name'] = $area_info['region_name'];
            $sql ="select count(1) as num from savor_tv as tv
                   left join savor_box as box  on tv.box_id=box.id
                   left join savor_room as room on box.room_id= room.id
                   left join savor_hotel as hotel on room.hotel_id= hotel.id 
                   where hotel.id=".$v['id'] .' and tv.state=1 and tv.flag =0';
            $rets = M()->query($sql);
            $info[$key]['tv_count'] = $rets[0]['num'];
        }
        $xlsCell = array(
            array('id', 'id'),
            array('region_name', '城市'),
            array('name','酒楼名称'),
            array('addr', '酒楼地址'),
            array('tv_count', '电视数量'),
           
        );
        $xlsName = '酒楼信息以及版位数量';
        $filename = 'hotelBv';
        $this->exportExcel($xlsName, $xlsCell, $info,$filename);
    }
    public function excelHotelBox(){
        $sql ="select hotel.id as hotel_id,box.id box_id,area.region_name, hotel.name,hotel.addr,box.mac from savor_box box
               left join savor_room room on room.id=box.room_id
               left join  savor_hotel hotel on hotel.id=room.hotel_id
               left join savor_area_info area on area.id=hotel.area_id
               where hotel.state and hotel.flag =0 and box.state=1 and box.flag=0 and hotel.hotel_box_type in(2,3) and hotel.id !=7 and hotel.id!=53 order by hotel.id asc";
        
        $info = M()->query($sql);
        $tmp = array();
        foreach($info as $key=>$v){
            
            $sql ="select count(1) as num from savor_tv as tv
                   left join savor_box as box  on tv.box_id=box.id
                   where box.id=".$v['box_id'] .' and tv.state=1 and tv.flag =0';
            $rets = M()->query($sql);
            $info[$key]['tv_count'] = $rets[0]['num'];
            
        }
        $xlsCell = array(
            
            array('region_name', '城市'),
            array('name','酒楼名称'),
            array('addr', '酒楼地址'),
            array('mac','机顶盒mac'),
            array('tv_count', '电视数量'),
             
        );
        $xlsName = '酒楼信息以及版位数量';
        $filename = 'hotelBv';
        $this->exportExcel($xlsName, $xlsCell, $info,$filename);
        
    }


    public function  expcontentlink() {
        $starttime = I('adsstarttime','');
        $endtime = I('adsendtime','');
        $url = I('url');

        $where = '1=1 ';
        if(empty($starttime) || empty($endtime)){
            echo "<script>alert('请选择开始时间与结束时间');</script>";
           die;
        }
        if($starttime <= $endtime) {
            $stt = strtotime($starttime);
            $ste = strtotime($endtime);
            if($stt == $ste) {
                $ste = $stt+86399;
            } else {
                $ste = $ste+86399;
            }
            $where.=" AND TIMESTAMP/1000>='$stt'";
            $where.=" AND TIMESTAMP/1000<='$ste'";

        }else{
            echo "<script>alert('开始时间必须小于等于结束时间');</script>";
            die;
        }
        if ( $url ) {
            $url = htmlspecialchars_decode('/'.$url);
            $where.=" AND request_url = '$url'";
        }
        $field = '*';
        $clinkModel = new \Admin\Model\ContentLinkModel();
        $result = $clinkModel->fetchDataWhere($where, $order='timestamp desc', $field,2);
        $dat = $result;
        $is_wei = array(
            '0' => '否',
            '1' => '是'
        );
        $is_shou = array(
            '0' => '否',
            '1' => '是'
        );

        foreach($dat as $rk=>$rv) {
            $w = $dat[$rk]['is_wx'];
            $sq = $dat[$rk]['is_sq'];
            $dat[$rk]['is_wx'] = $is_wei[$w];
            $dat[$rk]['is_sq'] = $is_wei[$sq];
            $ctime = substr($dat[$rk]['timestamp'],0 , -3);
            $dat[$rk]['vtime'] = date("Y-m-d H:i:s", $ctime);
        }


        $xlsCell = array(
            array('content_id', '文章id'),
            array('vtime', '访问日期'),
            array('device_type','设备类型'),
            array('is_wx', '是否为微信打开'),
            array('ip','IP'),
            array('net_type', '网络类型'),
            array('is_sq', '是否授权'),
        );
        $xlsName = '内容链接明细';
        $filename = 'contentlink';
        $this->exportExcel($xlsName, $xlsCell, $dat,$filename);

    }
    public function expcontentwxauth(){
        $start_date = I('get.start_date');
        $end_date   = I('get.end_date');
        $contentid   = I('get.contentid');
        
        
        if(!empty($start_date)){
	        $where .= " and a.create_time>='".$start_date." 00:00:00'";
	    }
	    if(!empty($end_date)){
	        $where .=" and a.create_time<='".$end_date." 23:59:59'";
	        
	    }
	    if(!empty($contentid)){
	        $where .=" and a.contentid=$contentid";
	       
	    }
	    $m_content_wx_auth = new \Admin\Model\ContentWxAuthModel();
	    $data = $m_content_wx_auth->getInfo("a.*,b.title ,c.name catname",$where,' a.create_time desc ','',2);
	    
	     foreach($data as $key=>$v){
	         if(!empty($v['nickname'])){
	             $data[$key]['nickname'] = base64_decode(trim($v['nickname']));
	         }
	        //$data[$key]['nickname'] = base64_decode($v['nickname']);
	         switch ($v['sex']){
	            case 0:
	                $data[$key]['sex'] = '';
	            break;
	            case 1:
	                $data[$key]['sex'] = '男';
	            break;
	            case 2:
	                $data[$key]['sex'] = '女';
	            break;
	        } 
	    } 
	 
	    $xlsCell = array(
	        array('id', '日志id'),
	        array('openid', 'openid'),
	        array('nickname','昵称'),
	        array('sex', '性别'),
	        array('country','国家'),
	        array('province', '省份'),
	        array('city', '城市'),
	        array('contentid', '文章id'),
	        array('title', '文章标题'),
	        array('catname', '文章分类'),
	        array('ip_addr', 'IP'),
	        array('long', '经度'),
	        array('lat', '维度'),
	        array('create_time', '访问时间'),
	        
	    );
	    $xlsName = '文章微信授权明细';
	    $filename = 'expcontentwxauth';
	    $this->exportExcel($xlsName, $xlsCell, $data,$filename);
    }
    /**
     * @desc 获取运维端机顶盒为异常状态的数据
     */
    public function reportErroBoxInfo(){
        $m_hotel = new \Admin\Model\HotelModel();
        $now = time();
        $start_time = strtotime('-72 hours');
        $where = '';
        $where = " a.id not in(7,53)  and a.state=1 and a.flag =0 and a.hotel_box_type in(2,3) ";
        $hotel_list = $m_hotel->getHotelLists($where,'','','a.id,a.name hotel_name,a.addr');
        //print_r($hotel_list);exit;
        $m_box = new \Admin\Model\BoxModel();
        $m_heart_log = new \Admin\Model\HeartLogModel();
        $m_repair_box_user = new \Admin\Model\RepairBoxUserModel();
        $m_repair_detail = new \Admin\Model\RepairDetailModel();
        $result = array();
        $repair_type_arr = C('HOTEL_DAMAGE_CONFIG');
        foreach($hotel_list as $key=>$v){
            $where =" 1 and room.hotel_id=".$v['id'].' and a.state =1 and a.flag =0 and room.state =1 and room.flag =0 ';
            $box_list = $m_box->getListInfo( 'a.id,room.name rname, a.name boxname, a.mac,a.id box_id',$where);
            foreach($box_list as $ks=>$vs){
                $tmp = array();
                $where = '';
                $where .=" 1 and hotel_id=".$v['id']." and type=2 and box_mac='".$vs['mac']."'";
            
                $rets  = $m_heart_log->getHotelHeartBox($where,'max(last_heart_time) ltime', 'box_mac');
                
                if(empty($rets)){
                    $tmp['hotel_name'] = $v['hotel_name'];  //酒楼名称
                    $tmp['addr']       = $v['addr'];        //酒楼地址
                    $tmp['rname']      = $vs['rname'];       //包间名称
                    $tmp['boxname']    = $vs['boxname'];     //盒子名称
                    //$tmp['boxid'] = $vs['id'];
                    $tmp['repair_0']   = '';
                    $tmp['repair_1']   = '';
                    $tmp['repair_2']   = '';
                    $repair_info = $m_repair_box_user->getWhere('id,remark'," hotel_id = ".$v['id']." and mac='".$vs['mac']."' and  flag=0",' create_time desc ','0,3',2);
                    foreach($repair_info as $rk=>$rv){
                        $space = '';
                        $detail_info = $m_repair_detail->getWhere('repair_type',' repair_id='.$rv['id'],'id desc','',2);
                        foreach($detail_info as $dk=>$dv){
                            $tmp["repair_".$rk] .= $space . $repair_type_arr[$dv['repair_type']];
                            $space = '、';
                        }
                    }
                    
                    
                    $result[] = $tmp;
                }else {
                    $ltime = $rets[0]['ltime'];
                    $ltime = strtotime($ltime);
                    if($ltime <= $start_time) {
                        //$unusual_num +=1;
                        //$box_list[$ks]['ustate'] = 0;
                        $tmp['hotel_name'] = $v['hotel_name'];  //酒楼名称
                        $tmp['addr']       = $v['addr'];        //酒楼地址
                        $tmp['rname']      = $vs['rname'];       //包间名称
                        $tmp['boxname']    = $vs['boxname'];     //盒子名称
                        //$tmp['boxid'] = $vs['id'];
                        $tmp['repair_0']   = '';
                        $tmp['repair_1']   = '';
                        $tmp['repair_2']   = '';
                        $repair_info = $m_repair_box_user->getWhere('id,remark'," hotel_id = ".$v['id']." and mac='".$vs['mac']."' and  flag=0",' create_time desc ','0,3',2);
                        foreach($repair_info as $rk=>$rv){
                            $space = '';
                            $detail_info = $m_repair_detail->getWhere('repair_type',' repair_id='.$rv['id'],'id desc','',2);
                            foreach($detail_info as $dk=>$dv){
                                $tmp["repair_".$rk] .= $space . $repair_type_arr[$dv['repair_type']];
                                $space = '、';
                            }
                        }
                        
                        $result[] = $tmp;
                    } 
                }
            }
        }
        $xlsCell = array(
            array('hotel_name', '酒楼名称'),
            array('addr', '酒楼地址'),
            array('rname','包间名称'),
            array('boxname', '盒子名称'),
            array('repair_0','维修记录1'),
            array('repair_1', '维修记录2'),
            array('repair_2', '维修记录3'),
            
            
             
        );
        $xlsName = '运维端异常机顶盒';
        $filename = 'optionerrobox';
        $this->exportExcel($xlsName, $xlsCell, $result,$filename);
        
    }
    public function testone(){
        $aa = fopen('./aa.csv', 'w');
        vendor("PHPExcel.PHPExcel");
        
        $PHPReader =new \PHPExcel_Reader_Excel2007();
        if(!$PHPReader->canRead('./aa.csv')){
            $PHPReader = new \PHPExcel_Reader_Excel5();
        }
        if(!$PHPReader->canRead('./aa.csv')){
            $PHPReader = new \PHPExcel_Reader_CSV();
        }
        if(!$PHPReader->canRead('./aa.csv')){
            echo '无法识别';
            return false;
        }
        //读取Excel
        $PHPExcel = $PHPReader->load('./aa.csv');
        //读取工作表1
        $currentSheet = $PHPExcel->getSheet();
        
        $currentSheet->setCellValue('B13','11111s');//表头赋值//
        
        $phpWrite = new \PHPExcel_Writer_CSV($PHPExcel);
        
        $phpWrite->save('./aa.csv');
    }
    public function exportShtask(){
        $m_option_task = new \Admin\Model\OptiontaskModel();
        $where = array();
        $where['a.task_area'] = 9;
        $where['a.task_type'] = 4;
        $where['a.flag']      =0;
        $fields = "a.id, a.task_area, a.task_emerge, a.task_type,b.name hotel_name,a.hotel_address,
                   a.hotel_linkman,a.hotel_linkman_tel,tv_nums,a.state";
        $list = $m_option_task->alias('a')
                              ->join('savor_hotel b on a.hotel_id= b.id','left')
                              ->field($fields)->where($where)->select();
        $model = D();
        
        foreach($list as $key=>$val){
            $repair_str = '';
            $space = '';
            $data = $model->query('select a.box_id,b.name box_name,fault_desc from 
                                   savor_option_task_repair a left join savor_box b
                                   on a.box_id = b.id where a.task_id='.$val['id']);
            if(!empty($data)){
                foreach($data as $k=>$v){
                    $repair_str .= $space .'机顶盒id:'.$v['box_id'].' 机顶盒名称:'.$v['box_name'];
                    $repair_str .=' 故障说明:'.$v['fault_desc'];
                    $space = ',';
                }
            }
            $list[$key]['task_area'] = '上海';
            switch ($val['task_emerge']){
                case '2':
                    $list[$key]['task_emerge'] = '紧急';
                    break;
                case '3':
                    $list[$key]['task_emerge'] = '正常';
                    break;
            }
            switch ($val['task_type']){
                case '1':
                    $list[$key]['task_type'] = '信息检测';
                    break;
                case '8':
                    $list[$key]['task_type'] = '网络改造';
                    break;
                case '2':
                    $list[$key]['task_type'] = '安装验收';
                    break;
                case '4':
                    $list[$key]['task_type'] = '维修';
                    break;
            }
            switch ($val['state']){
                case '1':
                    $list[$key]['state'] = '新任务';
                    break;
                case '2':
                    $list[$key]['state'] = '执行中';
                    break;
                case '3':
                    $list[$key]['state'] = '排队等待';
                    break;
                case '4':
                    $list[$key]['state'] = '已完成';
                    break;
                case '4':
                    $list[$key]['state'] = '拒绝';
                    break;
                    
            }
            $list[$key]['repair_info'] = $repair_str;
        }
        //print_r($list);exit;
        $xlsCell = array(
            array('id', '任务id'),
            array('hotel_name','酒楼名称'),
            array('hotel_address','酒楼地址'),
            array('hotel_linkman','酒楼联系人'),
            array('hotel_linkman_tel','酒楼联系人电话'),
            
            array('task_area', '任务城市'),
            array('task_emerge','任务紧急程度'),
            array('task_type', '任务类型'),
            array('tv_nums','版位数量'),
            
            array('state', '任务状态'),
            array('repair_info', '维修记录'),
        
        );
        $xlsName = '上海运维任务列表';
        $filename = 'option_sh_task_list';
        $this->exportExcel($xlsName, $xlsCell, $list,$filename);
    }


    public function getho() {
       $arr = array ( 0 => '阿根廷庄园（北京店）-餐厅 ', 1 => '百富怡大酒店 ', 2 => '草菁菁（金融街店） ', 3 => '朝尚食都 ', 4 => '大益膳房 ', 5 => '东海汇渔港 ', 6 => '朵颐河鲜 ', 7 => '福润龙庭 ', 8 => '花家怡园（金融街店） ', 9 => '辉哥火锅（8号公馆店） ', 10 => '辉哥火锅（远洋国际店） ', 11 => '江南赋 ', 12 => '江仙雅居（苏州桥店） ', 13 => '经易大丰合 ', 14 => '郡王府半岛明珠酒家 ', 15 => '浏阳河大酒楼 ', 16 => '美锦酒家（港澳中心店） ', 17 => '权茂北京菜 ', 18 => '山釜餐厅 ', 19 => '山海楼 ', 20 => '石榴花开餐厅 ', 21 => '食说江南(鸭王店) ', 22 => '唐宫海鲜舫（大悦城店） ', 23 => '唐宫海鲜舫（好苑建国店） ', 24 => '唐宫海鲜舫（丽都店） ', 25 => '唐宫海鲜舫（西藏大厦店） ', 26 => '天水雅居（木樨地店） ', 27 => '天水雅居（万豪店） ', 28 => '晚枫亭（石佛营店） ', 29 => '万龙洲大兴店 ', 30 => '万龙洲海鲜大酒楼（安定门店） ', 31 => '王府茶楼中轴路店 ', 32 => '新净雅烹小鲜 ', 33 => '盐府（大望路店） ', 34 => '夜上海（长安大戏院店） ', 35 => '怡和春天（怡和店） ', 36 => '俞翰姥爷的海味人生 ', 37 => '悦府.潮州菜 ', 38 => '悦融-精致中菜(金融街店) ', 39 => '粤悦香海鲜舫 ', 40 => '镇三关重庆老火锅（工体旗舰店） ', 41 => '正院大宅门（西翠路店） ', 42 => '万国城MOMASO餐厅 ', 43 => '瞳海鲜料理(崇文门店) ', 44 => '唐宫海鲜舫（新世纪饭店店）', );
        $hotelModel = new \Admin\Model\HotelModel();
        $where['flag'] = 0;
        $where['state'] = 1;
        $ho = array();
        foreach($arr as $v) {
            $where['name']  = trim($v);
            $hotel_info = $hotelModel->where($where)->find();
            $ho[] = $hotel_info['id'];
        }
        var_export($ho);
        $ho = array ( 0 => '41', 1 => '48', 2 => '16', 3 => '70', 4 => '30', 5 => '76', 6 => '17', 7 => '9', 8 => '12', 9 => '46', 10 => '19', 11 => '38', 12 => '436', 13 => '28', 14 => '13', 15 => '126', 16 => '25', 17 => '10', 18 => '26', 19 => '33', 20 => '511', 21 => '478', 22 => '171', 23 => '32', 24 => '39', 25 => '175', 26 => '52', 27 => '99', 28 => '184', 29 => '185', 30 => '186', 31 => '196', 32 => '34', 33 => '225', 34 => '35', 35 => '232', 36 => '465', 37 => '51', 38 => '468', 39 => '37', 40 => '466', 41 => '238', 42 => '27', 43 => '517', 44 => '177', );

    }


    public function expadverwarnreport(){
        $field = 'awarn.*,sb.mac box_mac,  ( CASE awarn.report_adsPeriod WHEN "" THEN "999999999999999"
	WHEN NULL THEN "999999999999999"
ELSE awarn.report_adsPeriod END ) AS reportadsPeriod ';
        $adWarnModel = new \Admin\Model\AdverWarnModel();
        $where = '1=1';
        $order      = I('_order',' reportadsPeriod asc, awarn.last_time asc '); //排序字段
        $result = $adWarnModel->getData($field,$where,$order);

        array_walk($result, function(&$v, $k){
            //修改时间
            $v['hea'] = '否';
            $v['adp'] = '否';
            $v['vid'] = '否';
            if($v['last_time'] >= 24) {
                $v['hea'] = '是';
                $day = floor($v['last_time']/24);
                $hour = floor($v['last_time']%24);
                $v['last_time'] = $day.'天'.$hour.'小时';
            } else {
                $v['last_time'] = $v['last_time'].'小时';
            }
            if( $v['report_adsperiod'] < $v['new_adsperiod'] ) {
                $v['adp'] = '是';
            }
            if( $v['report_demperiod'] != $v['new_demperiod'] ) {
                $v['vid'] = '是';
            }
            $v['report_adsperiod'] = $v['report_adsperiod'].' ';
            $v['report_demperiod'] = $v['report_demperiod'].' ';
        });

        $xlsCell = array(
            array('id', '序号'),
            array('box_id','机顶盒ID'),
            array('box_mac','机顶盒MAC'),
            array('maintainer','维护人'),
            array('room_id','包间ID'),

            array('room_name', '包间名称'),
            array('hotel_id','酒楼ID'),
            array('hotel_name', '酒楼名称'),
            array('last_time','心跳距离现在时间'),

            array('report_adsperiod', '广告期号'),
            array('report_demperiod', '点播期号'),
            array('hea', '心跳异常'),
            array('adp', '广告未更'),
            array('vid', '点播未更'),

        );
        $xlsName = '广告播放异常预警';
        $filename = 'adver_warn_report';
        $this->exportExcel($xlsName, $xlsCell, $result,$filename);
    }

}
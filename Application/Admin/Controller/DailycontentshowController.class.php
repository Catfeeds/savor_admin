<?php
namespace Admin\Controller;

/**
 *@desc 专题组控制器,对专题组添加或者修改
 * @Package Name: SpecialgroupController
 *
 * @author      白玉涛
 * @version     3.0.1
 * @copyright www.baidu.com
 */
use Think\Controller;
use Common\Lib\Weixin_api;

class DailycontentshowController extends Controller {

    private $oss_host = '';
    public function __construct() {
        parent::__construct();
        $this->host_name =  C('HOST_NAME').'/admin';
        $this->oss_host = 'http://'.C('OSS_HOST_NEW').'/';
    }



    /*
     * @desc 显示h5页面
     * @method editSpecialGroup
     * @access public
     * @http NULL
     * @return void
     */
    public function showday(){
        $sourcename = I('get.location','');
        $this->assign('sourc', $sourcename);
        $dcontentModel = new \Admin\Model\DailyContentModel();
        $id = I('get.id');
        $field = "sg.title title,sg.create_time, sg.media_id mediaid,sg.keyword
        ,sg.desc,sg.source_id,sg.order_tag tag,sr.dailytype,sr.stext,sr
        .spictureid,sm.oss_addr simg,sas.name sourcename,dlk.bespeak_time ";
        $where =  " 1=1 and sg.id = $id ";
        $speca_arr_info = $dcontentModel->fetchDataBySql($field, $where);
        if( !(empty($speca_arr_info[0]['bespeak_time'])) ) {
            $speca_arr_info[0]['create_time'] =
                $speca_arr_info[0]['bespeak_time'];

        }

        $oss_host = $this->oss_host;
        $m_media = new \Admin\Model\MediaModel();
        $marr = $m_media->getMediaInfoById($speca_arr_info[0]['mediaid']);
        $spinfo = array(
            'sgid'=>$id,
            'title'=>$speca_arr_info[0]['title'],
            'sourcename'=>$speca_arr_info[0]['sourcename'],
            'oss_addr'=>empty($speca_arr_info[0]['mediaid'])?'':$marr['oss_addr'],
            'create_time'=>date("Y-m-d", strtotime
            ($speca_arr_info[0]['create_time'])),
        );

        if ($speca_arr_info) {
            foreach ($speca_arr_info as $spk=>$spv) {
                if($spv['dailytype'] == 3) {
                    $speca_arr_info[$spk]['simg'] = $oss_host.$spv['simg'];
                }
            }

        } else {
            $speca_arr_info = array();
        }
        $wpi = new Weixin_api();
        $share_url ='http://' .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $shareimg = 'http://'.$_SERVER['HTTP_HOST'].'/Public/admin/assets/img/logo_100_100.jpg';
        $share_title = $speca_arr_info[0]['sptitle'];
        if(empty($speca_arr_info[0]['spdesc'])){
            $share_desc = '小热点，陪伴你创造财富，享受生活。';
        }else{
            $cot = html_entity_decode($speca_arr_info[0]['spdesc']);
            $cot = strip_tags($cot);
            $share_desc = mb_substr($cot,0,50);
        }
        

        $share_config = $wpi->showShareConfig($share_url, $share_title,$share_desc,$share_url,$share_url);
        extract($share_config);
        $appid = $share_config['appid'];
        $noncestr = $share_config['noncestr'];
        $signature = $share_config['signature'];
        $this->assign('noncestr', $noncestr);
        $this->assign('signature', $signature);
        $this->assign('appid', $appid);
        $this->assign('share_title', $share_title);
        $this->assign('share_desc', $share_desc);
        $this->assign('shareimg', $shareimg);
        $this->assign('share_link', $share_url);


        $this->assign('srinfo', $speca_arr_info);
        $this->assign('vinfo', $spinfo);
        $this->display('new_daily');

    }


}

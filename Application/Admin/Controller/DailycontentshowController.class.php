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

    public function test() {

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
        $shareimg = 'http://'.$_SERVER['HTTP_HOST'].'/Public/admin/assets/img/logo_120_120.png';
        $share_title = '每日知享 - '.$speca_arr_info[0]['title'];
        if(empty($speca_arr_info[0]['desc'])){
            $share_desc = '小热点，陪伴你创造财富，享受生活。';
        }else{
            $cot = html_entity_decode($speca_arr_info[0]['desc']);
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





    public function showopen(){
        //http://admin.littlehotspot.com/admin/dailycontentshow/showday?id=60
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

        $m_weixin_api = new \Common\Lib\Weixin_api();
        $is_wx = checkWxbrowser();
        if($is_wx){
            $openid = I('openid','');
            $code = I('code', '');
            $contentid = I('id', '');

            if($openid) {
                $oid = session('openid');
                $opsr = $openid.'_'.$contentid;
                if($oid && $oid == $opsr) {
                    //最终值得到
                    //有对应关系
                    $share_url = 'http://' .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                } else {

                    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
                    var_dump($url);
                    if(!empty($code)) {
                        var_dump($oid);

                        $sourcepenid = $openid;
                        $result = $m_weixin_api->getWxOpenid($code,$url);
                        var_dump($sourcepenid);
                        $openid = $result['openid'];
                        $wxUserinfo = $m_weixin_api->getWxUserInfo($result['access_token'],$openid);
                        var_dump($wxUserinfo);


                        if($sourcepenid == $openid) {
                            $url = $this->getContentUrl().'?id='.$contentid;
                            $url .='&openid='.$openid;
                            session('openid',$openid.'_'.$contentid);
                            header("Location:".$url);
                        }else {
                            $map = array();
                            $url = $this->getContentUrl().'?id='.$contentid;
                            $url .='&openid='.$openid;
                            $share_weiModel = new \Admin\Model\DailyShareWeixinModel();
                            $map['sourceid'] = $sourcepenid;
                            $map['openid'] = $openid;
                            $map['artid'] = $contentid;
                            //先判断有无
                            $rs = $share_weiModel->getOne($map);
                            if ($rs) {

                            }else {
                                $share_weiModel->addData($map);
                            }
                            session('openid',$openid.'_'.$contentid);
                            header("Location:".$url);
                        }
                    } else {
                        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
                        $host_name = C('CONTENT_HOST');
                        $redirect_url = urlencode($url);
                        $jumpUrl = $host_name.'admin/wxapply/index?redirect_url='.$redirect_url;
                        header("Location:".$jumpUrl);
                    }

                }
            } else {
                if(!empty($code)) {
                    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
                    $result = $m_weixin_api->getWxOpenid($code,$url);
                    $openid = $result['openid'];
                    $url .='&openid='.$openid;
                    $redirect_url = urlencode($url);
                    $host_name = C('CONTENT_HOST');
                    $jumpUrl = $host_name.'admin/wxapply/index?redirect_url='.$redirect_url;
                    header("Location:".$jumpUrl);
                } else {
                    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
                    $host_name = C('CONTENT_HOST');
                    $redirect_url = urlencode($url);
                    $jumpUrl = $host_name.'admin/wxapply/index?redirect_url='.$redirect_url;
                    header("Location:".$jumpUrl);
                }

            }
        } else {
            $share_url = 'http://' .$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        $wpi = new Weixin_api();
        $shareimg = 'http://'.$_SERVER['HTTP_HOST'].'/Public/admin/assets/img/logo_120_120.png';
        $share_title = '每日知享 - '.$speca_arr_info[0]['title'];
        if(empty($speca_arr_info[0]['desc'])){
            $share_desc = '小热点，陪伴你创造财富，享受生活。';
        }else{
            $cot = html_entity_decode($speca_arr_info[0]['desc']);
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


    public function getContentUrl(){
        $content_host = C('CONTENT_HOST');
        $_SERVER["PHP_SELF"] = str_replace('/index.php/','', $_SERVER["PHP_SELF"]);
        $content_url = $content_host.$_SERVER["PHP_SELF"];
        return $content_url;
    }



    /**
     * @desc 微信授权
     */
    public function wxAuthorLog($url,$contentid, $type){

        $redirect_url = urlencode($url);
        $host_name = C('CONTENT_HOST');
        $jumpUrl = $host_name.'admin/wxapply/index?scope=0&redirect_url='.$redirect_url;
        header("Location:".$jumpUrl);
        exit;
        //$url = 'http://admin.littlehotspot.com/index.php/admin/dailycontentshow/showopen?id=60';
        $m_weixin_api = new \Common\Lib\Weixin_api();
        //微信授权登录开始
        $state = I('state','wxsq001','trim') ;
        if($iswx==1){

            $host_name = C('CONTENT_HOST');
            $openid = I('openid');
            if (!$code || $state!='wxsq001') {

                if($openid) {
                    $url .= '&type=2';
                } else {
                    //标明是第一次自己打开的网页
                    $url .= '&type=1';
                }
                $redirect_url = urlencode($url);
                $jumpUrl = $host_name.'admin/wxapply/index?scope=0&redirect_url='.$redirect_url;
                header("Location:".$jumpUrl);
                exit;
            }else {

                if($openid) {
                    //来源者openid
                    $type = I('type');
                    $sourcepenid = $openid;
                    $result = $m_weixin_api->getWxOpenid($code,$url);


                    $openid = $result['openid'];
                    //获取自身openid，如果相等则直接出来如果
                    if($sourcepenid == $openid) {
                        $url = $this->getContentUrl().'?id='.$contentid;
                        $url .='&openid='.$openid.'&type=1';
                        return array('code'=>0,'mul'=>$url);
                    }else {
                        $url = $this->getContentUrl().'?id='.$contentid;
                        $url .='&openid='.$openid.'&type=1';
                        return array('code'=>0,'mul'=>$url);
                    }
                }else {
                    $result = $m_weixin_api->getWxOpenid($code,$url);
                    $openid = $result['openid'];
                    $wxUserinfo = $m_weixin_api->getWxUserInfo($result['access_token'],$openid);
                    $url = $this->getContentUrl().'?id='.$contentid;
                    $url .='&issq=1&openid='.$openid.'&type=1';
                    $redirect_url = urlencode($url);
                    $host_name = C('CONTENT_HOST');
                    $jumpUrl = $host_name.'admin/wxapply/index?scope=1&redirect_url='.$redirect_url;
                    header("Location:".$jumpUrl);
                    exit;
                }
            }



            $result = $m_weixin_api->getWxOpenid($code,$url);
            $openid = $result['openid'];
            $wxUserinfo = $m_weixin_api->getWxUserInfo($result['access_token'],$openid);

            $wxUserinfo['nickname'] = base64_encode($wxUserinfo['nickname']);
            var_dump($wxUserinfo);
            die;
            $map =  array();
            $map['openid'] = $wxUserinfo['openid'];
            $map['nickname'] = $wxUserinfo['nickname'];
            $map['sex']      = $wxUserinfo['sex'];
            $map['country']  = $wxUserinfo['country'];
            $map['province'] = $wxUserinfo['province'];
            $map['city']     = $wxUserinfo['city'];
            $map['contentid']= $contentid;
            $map['create_time'] = date('Y-m-d H:i:s');

            $ip = get_client_ip();
            $map['ip_addr'] = $ip;
            $geoArr = getgeoByip($ip);
            $map['long'] = $geoArr['x'];
            $map['lat'] = $geoArr['y'];
            $m_content_wx_auth =  new \Admin\Model\ContentWxAuthModel();
            $m_content_wx_auth->addInfo($map);
        }
    }


}

<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * @desc 基础类，所有后台类必须继承此类
 *
 */
class BaseController extends Controller {
    
    public function __construct(){
        parent::__construct();
        $this->handlePublicParams();
        $this->checkLogin();
        $this->getNameByIp();
    }
    
    public function handlePublicParams(){
        $this->assign('host_name',$this->host_name().'/admin');
        $this->assign('site_host_name',$this->host_name());
        $this->assign('imgup_path',$this->imgup_path());
        $this->assign('imgup_show',$this->imgup_show());
        $this->sysLog($actionName='', $oppreate='', $program='');
    }
    
    public function host_name(){
        $host_name = C('HOST_NAME');
        return $host_name;
    }
    
    /**
     * @return 图片上传地址
     */
    public function imgup_path(){
        $imgup_path= './Public/uploads/';
        return $imgup_path;
    }
    
    /**
     * @return 页面图片展示地址
     */
    public function imgup_show(){
        $imgup_show= C('HOST_NAME').'/Public/uploads/';
        return $imgup_show;
    }

    public function output($message,$navTab,$type=1,$status=1,$callback="",$del){
        switch ($type){
            case 1://关闭
                $callbackType = 'closeCurrent';
                break;
            case 2://重新载入
                $callbackType = 'forward';
                break;
            default://停留在当前页
                $callbackType = '';
                break;
        }
        $data = array('status'=>$status,'info'=>$message,'navTabId'=>$navTab,'url'=>'',
           'callbackType'=>$callbackType,'forwardUrl'=>'','confirmMsg'=>'','callback'=>$callback,'del'=>$del);
        $this->ajaxReturn($data,'TEXT');
    }
    
    //生成缩略图
    public function getThumbSize($img, $width, $height, $prefix, $type=\Think\Image::IMAGE_THUMB_CENTER){
        $imglib = new \Think\Image();
        $imgPart = explode('/',$img);
        $i = count($imgPart);
        $name = $imgPart[$i-1];
        $path = str_replace($name, '', $img);
        //去掉域名
        $pathNohost = str_replace('./','/',str_replace(C('HOST_NAME'), '', $path));
        $sizeinfo = getimagesize('.'.$pathNohost.$name);
        if($sizeinfo[0] >= $width && $sizeinfo[1] >= $height){
            $imglib -> open('.'.$pathNohost.$name)->thumb($width, $height, $type)->save('.'.$pathNohost.$prefix.$name);
            $result = $pathNohost.$prefix.$name;
        }
        return $result;
    }
   
    //获取当前所有的栏目
    public function getMenuList(){
        $tmp_arr = array();
        $moduleMenu = new \Admin\Model\SysmenuModel();
        $menuList   = $moduleMenu->getAllList();
        foreach ($menuList as $key => $v){
            $tmp_arr[$key]['rank']= $v['code'];
            $tmp_arr[$key]['title']= $v['modulename'];
        }
        return $tmp_arr;
    }
    
    //dwz编辑器中内容和图片上传处理
    public function Upload() {
        header('Content-Type: text/html; charset=UTF-8');
        $inputname='filedata';      //表单文件域name
        $attachdir='./Public/uploads';     //上传文件保存路径，结尾不要带/
        $dirtype=1;                 //1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
        $maxattachsize=1048576 * 300;//最大上传大小，默认是300M
        $upext='pdf,zip,rar,txt,doc,docx,ppt,xls,xlsx,csv,jpg,jpeg,gif,png,bmp,swf,flv,fla,avi,wmv,wma,rm,mov,mpg,rmvb,3gp,mp4,mp3';//上传扩展名
        $msgtype=2;                  //返回上传参数的格式：1，只返回url，2，返回参数数组
        $immediate=isset($_REQUEST['immediate'])?$_REQUEST['immediate']:0;//立即上传模式
        ini_set('date.timezone','Asia/Shanghai');//时区
        if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])){
            if(preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)){
                $temp_name=ini_get("upload_tmp_dir").'\\'.date("YmdHis").mt_rand(1000,9999).'.tmp';
                file_put_contents($temp_name,file_get_contents("php://input"));
                $size=filesize($temp_name);
                $_FILES[$info[1]]=array('name'=>$info[2],'tmp_name'=>$temp_name,'size'=>$size,'type'=>'','error'=>0);
            }
        }
        $err = "";
        $msg = "''";
        $upfile=@$_FILES[$inputname];
        if(!isset($upfile)){
            $err='文件域的name错误';
        }elseif(!empty($upfile['error'])){
            switch($upfile['error']){
                case '1':
                    $err = '文件大小超过了php.ini定义的upload_max_filesize值';
                    break;
                case '2':
                    $err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
                    break;
                case '3':
                    $err = '文件上传不完全';
                    break;
                case '4':
                    $err = '无文件上传';
                    break;
                case '6':
                    $err = '缺少临时文件夹';
                    break;
                case '7':
                    $err = '写文件失败';
                    break;
                case '8':
                    $err = '上传被其它扩展中断';
                    break;
                case '999':
                default:
                    $err = '无有效错误代码';
            }
        }elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none'){
            $err = '无文件上传';
        }else{
            $temppath=$upfile['tmp_name'];
            $fileinfo=pathinfo($upfile['name']);
            $extension=$fileinfo['extension'];
            if(preg_match('/'.str_replace(',','|',$upext).'/i',$extension)){
                $bytes=filesize($temppath);
                if($bytes > $maxattachsize){
                    $err='请不要上传大小超过'.$maxattachsize.'的文件';
                }else{
                    switch($dirtype){
                        case 1: $attach_subdir = 'day_'.date('ymd'); break;
                        case 2: $attach_subdir = 'month_'.date('ym'); break;
                        case 3: $attach_subdir = 'ext_'.$extension; break;
                    }
                    $attach_dir = $attachdir.'/'.$attach_subdir;
                    if(!is_dir($attach_dir)){
                        @mkdir($attach_dir, 0777);
                        @fclose(fopen($attach_dir.'/index.htm', 'w'));
                    }
                    PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
                    $filename=date("YmdHis").mt_rand(1000,9999).'.'.$extension;
                    $target = $attach_dir.'/'.$filename;
                    rename($upfile['tmp_name'],$target);
                    @chmod($target,0755);
                    $target='/html/upload/'.$attach_subdir.'/'.$filename;
                    if($immediate=='1')$target='!'.$target;
                    if($msgtype==1)$msg="'$target'";
                    else $msg="{'url':'".$target."','localname':'".preg_replace("/([\\\\\/'])/",'\\\$1',$upfile['name'])."','id':'1'}";
                }
            }
            else $err='上传文件扩展名必需为：'.$upext;
            @unlink($temppath);
        }
        echo "{'err':'".preg_replace("/([\\\\\/'])/",'\\\$1',$err)."','msg':".$msg."}";
    }
    
    /*
     * @param actionName 当前栏目名称
     * @param oppreate  当前操作方式
     * @param program  当前栏目中某一条的信息
     * @param type  判断是否是登录、退出
     */
    public function sysLog($actionName, $oppreate, $program,$type=''){
        $userInfo = session('sysUserInfo');
        $loginId = $userInfo['id'];
        if(!$actionName){
            $sysMenu = new \Admin\Model\SysmenuModel();
            $result = $sysMenu->getList("where menulevel='1' ",'id desc',0,500);
            $menuList = $result['list'];
            $menuName = ACTION_NAME;
            if(IS_POST){
                if(('add' == strtolower(substr($menuName, -3))) or ('del' == strtolower(substr($menuName, -3)))) $menuName = substr($menuName, 0, -3).'List';
            }
            foreach ($menuList as $k => $v){
                if(stripos($v['code'] ,$menuName)){
                    $actionId =  $v['id'];
                    break;
                }
            }
        }else{
            $actionId = $actionName;
        }
        if($loginId && $actionId){
            $data['loginid']   = $loginId;
            $data['actionid'] = $actionId;
            $data['clientip'] = getClientIP();
            $data['areaname'] = $this->getNameByIp($data['clientip']);
            $data['logtime'] = date("Y-m-d H:i:s");
            if($type){
                if($type=='login'){
                    $data['opprate'] = '登录';
                }elseif($type=='logout'){
                    $data['opprate'] = '退出';
                }
                $data['program'] = '当前栏目';
                $syslog = new \Admin\Model\SyslogModel();
                $syslog->addData($data, 0);
            }else{
                if(IS_POST){
                    if('del' == strtolower(substr(ACTION_NAME, -3))){
                        $data['opprate'] =  '删除';
                        $data['program'] =   $this->getProName($_REQUEST['id'], ACTION_NAME);
                    }else{
                        $oppreate = ($_REQUEST['acttype'] == 1)? '修改' : '新增';
                        if($_REQUEST['shwtitle']){
                            $data['program'] = $_REQUEST['shwtitle'];
                        }elseif($_REQUEST['key']){
                            $data['program'] = $_REQUEST['key'];
                        }elseif($_REQUEST['modulename']){
                            $data['program'] = $_REQUEST['modulename'];
                        }elseif($_REQUEST['name']){
                            $data['program'] = $_REQUEST['name'];
                        }elseif($_REQUEST['remark']){
                            $data['program'] = $_REQUEST['remark'];
                        }
                        $data['opprate'] = $oppreate;
                    }
                    if($data['program'] && $data['opprate']){
                        $syslog = new \Admin\Model\SyslogModel();
                        $syslog->addData($data, 0);
                    }
                }else{
                    $data['opprate'] = '查看';
                    $data['program'] = '当前栏目';
                    $syslog = new \Admin\Model\SyslogModel();
                    $syslog->addData($data, 0);
                }
            }
        }
    }
    
    
    public function getNameByIp($ip){
        $arearName = '暂无地区名称';
        $Ip = new \Org\Net\IpLocation('UTFWry.dat');
        $area = $Ip->getlocation($ip);
        if($area) $areaName = $area['country'].','.$area['area'];
        return $areaName;
    }
    
    private function checkLogin(){
        $sysuserInfo = session('sysUserInfo');
        if(empty($sysuserInfo) && CONTROLLER_NAME.'/'.ACTION_NAME!='Login/index'){
            $cookie_upwd = cookie('login_upwd');
            if($cookie_upwd)$this->assign('cookie_upwd',$cookie_upwd);
            $this->display('Login/index');
            exit;
        }else{
            $this->assign('sysuerinfo', $sysuserInfo);
        }
    }
    
    private function getProName($id, $tabName){
        $title_name = '暂无标题';
        $tabName = substr($tabName, 0, -3);
        $is_table = M()->query("SHOW TABLES LIKE '%savor_$tabName%'");
        if($is_table){
            $progam = M("$tabName");
            $vinfo = $progam->find($id);
            $programName = $vinfo['shw_title'];
            if($programName){
                $title_name = $programName;
            }
        }
        return $title_name;
        
    }
}
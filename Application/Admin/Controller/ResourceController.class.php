<?php
/**
 *资源管理控制器
 * 
 */
namespace Admin\Controller;
use Admin\Controller\BaseController;

class ResourceController extends BaseController{
	 
	 /**
	  * 资源列表
	  */
	 public function resourceList(){	
		
		$size   = I('numPerPage',50);//显示每页记录数
        $start = I('pageNum',1);
        $order = I('_order','id');
        $sort = I('_sort','desc');
        $name = I('keywords','','trim');
        $beg_time = I('begin_time','');
        $end_time = I('end_time','');
        $orders = $order.' '.$sort;
        $pagenum = ($start-1) * $size>0?($start-1) * $size:0;
        $where = "1=1";
        if($name)   $where.= "	AND name LIKE '%{$name}%'";
        if($beg_time)   $where.=" AND create_time>='$beg_time'";
        if($end_time)   $where.=" AND create_time<='$end_time'";
        
	 	$mediaModel = new \Admin\Model\MediaModel();
        $result = $mediaModel->getList($where,$orders,$pagenum,$size);
        $time_info = array('now_time'=>date('Y-m-d H:i:s'),'begin_time'=>$beg_time,'end_time'=>$end_time);
        $this->assign('timeinfo',$time_info);
        $this->assign('pageNum',$start);
        $this->assign('numPerPage',$size);
        $this->assign('_order',$order);
        $this->assign('_sort',$sort);
   		$this->assign('list', $result['list']);
   	    $this->assign('page',  $result['page']);
    	$this->assign('keywords',$name);
	 	$this->display('resourcelist');
	 }


	 public function addResource(){
         $mediaModel = new \Admin\Model\MediaModel();
	     if(IS_POST){
	         $media_id                = I('post.id');
	         $save              = [];
	         $save['name']  	   = I('post.name','','trim');
	         $message = $url = '';
	         if($media_id){
	             $save['flag']      = I('post.flag','','intval');
	             $save['state']     = I('post.state','','intval');
	             if($mediaModel->where('id='.$media_id)->save($save)){
	                 $message = '更新成功!';
	                 $url = 'resource/resourceList';
	             }else{
	                 $message = '更新失败!';
	                 $url = 'resource/resourceList';
	             }
	         }else{
	             $save['oss_addr']    = I('post.oss_addr','','trim');
	             if(!$save['oss_addr']){
	                 $message = 'OSS上传失败!';
	                 $url = 'resource/resourceList';
	             }else{
	                 $user                = session('sysUserInfo');
	                 $save['create_time'] = date('Y-m-d H:i:s');
	                 $save['creator']     = $user['username'];
	                 $tempInfo = pathinfo($save['oss_addr']);
	                 $save['surfix'] = $tempInfo['extension'];
	                 if($mediaModel->add($save)){
	                     $message = '添加成功!';
	                     $url = 'resource/resourceList';
	                 }else{
	                     $message = '添加失败!';
	                     $url = 'resource/resourceList';
	                 }
	             }
	             $this->output($message, $url);
	         }
	     }else{
	         $where = ' flag=0';
	         $orders = 'id desc';
	         $start = 0;
	         $size = 50;
	         $result = $mediaModel->getList($where,$orders,$start,$size);
	         $this->assign('datalist', $result['list']);
	         $this->assign('action_url','resource/addResource');
	         $this->display('addresource');
	     }
	 }

	 public function uploadResource(){
	     $mediaModel = new \Admin\Model\MediaModel();
	     $code = 10001;
	     $data = array();
	     if(IS_POST){
	         $media_id                = I('post.id');
	         $save              = [];
	         $save['name']  	   = I('post.name','','trim');
	         if($media_id){
	             $save['flag']      = I('post.flag','','intval');
	             $save['state']     = I('post.state','','intval');
	             $res_media = $mediaModel->where('id='.$media_id)->save($save);
	             if($res_media){
	                 $code = 10000;
	                 $data['media_id'] = $media_id;
	             }
	         }else{
	             $save['oss_addr']    = I('post.oss_addr','','trim');
	             if($save['oss_addr']){
	                 $user                = session('sysUserInfo');
	                 $save['create_time'] = date('Y-m-d H:i:s');
	                 $save['creator']     = $user['username'];
	                 $tempInfo = pathinfo($save['oss_addr']);
	                 $save['surfix'] = $tempInfo['extension'];
	                 $media_id = $mediaModel->add($save);
	                 if($media_id){
	                     $code = 10000;
	                     $data['media_id'] = $media_id;
	                 }
	             }
	         }
	         $res_data = array('code'=>$code,'data'=>$data);
	         echo json_encode($res_data);
	         exit;
	     }else{
	         $where = ' flag=0';
	         $orders = 'id desc';
	         $start = 0;
	         $size = 50;
	         $result = $mediaModel->getList($where,$orders,$start,$size);
	         $this->assign('datalist', $result['list']);
	         $this->assign('action_url','resource/uploadResource');
	         $this->display('addresource');
	     }
	 }
	 
	 /**
	  * 获取OSS资源上传的配置初始化参数
	  * 
	  * @return [type] [description]
	  */
	 public function getOssParams(){
	 	$id = C('OSS_ACCESS_ID');
		$key = C('OSS_ACCESS_KEY');
		$host = 'http://'.C('OSS_TEST_BUCKET').'.'.C('OSS_ENDPOINT');
		$callbackUrl = C('OSS_SYNC_CALLBACK_URL');
	    $callback_param = array(
	    			 'callbackUrl'=>$callbackUrl, 
	                 'callbackBody'=>'filename=${object}&size=${size}&mimeType=${mimeType}&height=${imageInfo.height}&width=${imageInfo.width}', 
	                 'callbackBodyType'=>"application/x-www-form-urlencoded"
	                 );
		$callback_string = json_encode($callback_param);
		$base64_callback_body = base64_encode($callback_string);
		$now = time();
		$expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
		$end = $now + $expire;
		$expiration = $this->_gmt_iso8601($end);

		$rand = rand(10,99);
			
		//资源空间的目录前缀
		$dir = C('OSS_ADDR_PATH');
		
		//最大文件大小.用户可以自己设置
		$condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
		$conditions[] = $condition; 
		
		//表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
		$start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
		$conditions[] = $start; 
		$arr = array('expiration'=>$expiration,'conditions'=>$conditions);
		$policy = json_encode($arr);
		$base64_policy = base64_encode($policy);
		$string_to_sign = $base64_policy;
		$signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));
		
		$response              = array();
		$response['accessid']  = $id;
		$response['host']      = $host;
		$response['policy']    = $base64_policy;
		$response['signature'] = $signature;
		$response['expire']    = $end;
		$response['callback']  = $base64_callback_body;
		//这个参数是设置用户上传指定的前缀
		$response['dir']       = $dir;
	    echo json_encode($response);
        exit;
	 }

	 private function _gmt_iso8601($time){
	    $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
	 }
}

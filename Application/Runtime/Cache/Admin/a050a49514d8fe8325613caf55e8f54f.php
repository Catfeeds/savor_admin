<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="renderer" content="webkit">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <title>寻味管理系统</title>
  <link href="<?php echo ($site_host_name); ?>/min?b=./Public/admin/assets/plugins&f=font-awesome/css/font-awesome.min.css,simple-line-icons/css/simple-line-icons.css,bootstrap/css/bootstrap-custom.css,bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css,bootstrap-fileinput/bootstrap-fileinput.css,jquery-tags-input/jquery.tagsinput.css,bootstrap-switch/css/bootstrap-switch.min.css,bootstrap-select/bootstrap-select.min.css,footable/footable.css,dropzone/css/dropzone.css,icons-files/file.css,baidumap/searchinfowindow.min.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo ($site_host_name); ?>/min?b=./Public/admin/assets/css&f=core.css,components.css,plugins.css,style.css" rel="stylesheet" type="text/css" />
  <link rel="shortcut icon" href="/Public/admin/assets/img/favicon.png"/>
  <link rel="apple-touch-icon" sizes="57*57" href="/Public/admin/assets/img/phoneicon.png">
  <link rel="apple-touch-icon" sizes="72*72" href="/Public/admin/assets/img/phoneicon.png">
  <link rel="apple-touch-icon" sizes="114*114" href="/Public/admin/assets/img/phoneicon.png">
  <link rel="apple-touch-icon" sizes="144*144" href="/Public/admin/assets/img/phoneicon.png">
</head>

<body scroll="no">
  <input id="host_name" value="<?php echo ($host_name); ?>" type="hidden"/>
  <input id="site_host_name" value="<?php echo ($site_host_name); ?>" type="hidden"/>
  <div class="preloading-container loading">
    <div class="login-container">
      <div class="logo">
        <a>
        <img src="/Public/admin/assets/img/logo-big-white.png" alt=""/>
        </a>
      </div>
      <div class="loading-text">
        系统载入中...
      </div>
    </div>
  </div>
  <div id="layout">
    <div id="header">
      <div class="headerNav">
        <a class="logo1" href="#"></a>
        <a class="logo2 active" href="#"></a>
        <ul class="nav">
          <li><span><i class="icon-user"></i> <?php echo ($sysuerinfo["username"]); ?></span></li>
          <li><a mask="true" target="dialog" href="<?php echo ($host_name); ?>/user/chagePwd"><i class="icon-lock"></i> <span class="hidden-xs">修改密码</span></a></li>
          <li><a href="<?php echo ($host_name); ?>/login/logout"><i class="icon-logout"></i> <span class="hidden-xs">安全退出</span></a></li>
        </ul>
      </div>
      <!-- navMenu -->
    </div>
    <div id="sidebar" class="active">
      <div class="heading">
        <h2><i class="icon-layers"></i> 后台管理</h2></div>
      <div class="menu-container">
        <ul class="main-menu">
          <?php if($menuList != ''): echo ($menuList); ?>
      <?php else: ?>
        <li>
          <span>暂无菜单</span>
        </li><?php endif; ?>
        </ul>
      </div>
    </div>
    <div id="container" class="active">
      <div id="navTab" class="tabsPage">
        <div class="tabsPageHeader">
          <div class="tabsPageHeaderContent">
            <ul class="navTab-tab">
              <li tabid="main" class="main"><a href="javascript:;"><span><i class="icon-home"></i> 系统信息</span></a></li>
            </ul>
          </div>
          <div class="tabsLeft"><i class="icon-arrow-left"></i></div>
          <!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
          <div class="tabsRight"><i class="icon-arrow-right"></i></div>
          <!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
          <div class="tabsMore" tabIndex="1"><i class="icon-options-vertical"></i></div>
          <div class="tabsSideNav" tabIndex="1"><i class="fa"></i></div>
        </div>
        <ul class="tabsMoreList">
          <li><a href="javascript:;">系统信息</a></li>
        </ul>
        <div class="navTab-panel tabsPageContent layoutBox">
          <div class="page unitBox">
            <div class="pageContent autoflow">
              <div class="accountInfo clearfix">
                <p class="form-control-static text-danger">提示：您好,您本次登录的时间为 <strong class="login-time"><?php echo date("Y年m月d日 H:i:s");?></strong>&nbsp;&nbsp;当前IP地址为 <strong class="login-time"><?php echo ($_SERVER['REMOTE_ADDR']); ?></strong></p>
                <div class="pull-right index-top-op">
                  <a warn="警告" title="你确定要清理缓存吗？" target="ajaxTodo" href="<?php echo ($host_name); ?>/clean/cache" calback="navTabAjaxDone" class="btn btn-danger"><i class="fa fa-trash"></i> 清理缓存</a>
                </div>
              </div>
              <div class="indexContent">
                <div class="row sm-row">
                    <div class="portlet success-box box">
                      <div class="portlet-title">
                        <div class="caption">
                          <i class="fa fa-cogs"></i>系统信息
                        </div>
                      </div>
                      <div class="portlet-body">
                        <ul class="info-list">
                          <li>运行环境: <span>LNMP/LAMP</span></li>
                          <li>PHP版本: <span><?php echo ($VerPHP); ?></span></li>
                          <li>MYSQL版本: <span><?php echo ($VerMysql); ?></span></li>
                          <li>服务器IP: <span><?php echo ($_SERVER['SERVER_ADDR']); ?></span></li>
                          <li>服务器时间: <span><?php echo date("Y年m月d日 H:i:s");?></span></li>
                          <li>当前访问地址: <span><?php echo ($_SERVER['HTTP_HOST']); ?></span></li>
                        </ul>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div id="modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
          <p>One fine body&hellip;</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <div id="modal-file" class="modal fade modal-file">
    <div class="modal-table">
      <div class="modal-cell">
        <div class="dialog modal-dialog">
          <div class="modal-content">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal-view" class="modal fade">
    <div class="modal-table">
      <div class="modal-cell">
        <div class="dialog modal-dialog fullscreen">
          <div class="modal-content" view="full">
            <div class="dialogHeader modal-header">
              <a class="close-m" data-dismiss="modal"></a>
              <div class="screen-view pull-right hidden-xs">
                <select id="screen" class="form-control input-sm hidden-xs">
                  <?php $_result=C('MOBILE_TYPE');if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" data-width="<?php echo ($vo["w"]); ?>" data-height="<?php echo ($vo["h"]); ?>"><?php echo ($vo["t"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                  <option value="0" selected>全屏</option>
                </select>
                <div class="screen-info hidden">
                  <span class="screen-width"></span>
                  <span>x</span>
                  <span class="screen-height"></span>
                  <span class="screen-change"><i class="fa fa-refresh"></i></span>
                </div>
              </div>
              <div class="label-control pull-right hidden-xs">模拟器：</div>
              <h1 class="fa-globe">页面浏览</h1>
            </div>
            <div id="web-view">
              <iframe></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal-file-ueditor" class="modal fade modal-file">
    <div class="modal-table">
      <div class="modal-cell">
        <div class="dialog modal-dialog">
          <div class="modal-content">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="modal-attachfiles" class="modal fade modal-file">
    <div class="modal-table">
      <div class="modal-cell">
        <div class="dialog modal-dialog">
          <div class="modal-content">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.modal -->
  <div id="footer">&copy;  Copyright <a target="_blank" href="#">北京寻味传媒集团</a></div>
  <script src="<?php echo ($site_host_name); ?>/min?b=./Public/admin/assets/plugins&f=jquery.min.js,jquery.cookie.min.js,jquery.validate.js,jquery.bgiframe.js"></script>

  <script src="<?php echo ($site_host_name); ?>/min?b=./Public/admin/assets/plugins&f=bootstrap/js/bootstrap.js,lazyload.js,bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js,bootstrap-select/bootstrap-select.min.js,jquery-tags-input/jquery.tagsinput.min.js,bootstrap-switch/js/bootstrap-switch.min.js,footable/footable.js,dropzone/dropzone.js,hammer.min.js,jquery.hammer.js"></script>
  <script type="text/javascript" src="<?php echo ($site_host_name); ?>/min?b=./Public/admin/ueditor&f=ueditor.config.js,ueditor.all.js"></script>
  <script src="<?php echo ($site_host_name); ?>/min?b=./Public/admin/assets/plugins/dwzjs&f=dwz.js,dwz.regional.zh.js" type="text/javascript"></script>

  <script src="/Public/admin/assets/js/main.js"></script>
  <script type="text/javascript">
  function addEvent(elem, event, fn) {
      if (elem.addEventListener) {
          elem.addEventListener(event, fn, false);
      } else {
          elem.attachEvent("on" + event, function() {
              // set the this pointer same as addEventListener when fn is called
              return(fn.call(elem, window.event));   
          });
      }
  }
  $(function() {
    DWZ.init({
      loginUrl:"/admin/Login/login", //跳到登录页面
      statusCode:{ok:1,error:0},
      keys:{statusCode:"status", message:"info"},
      pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"_order", orderDirection:"_sort"}, //【可选】
      debug:false, // 调试模式 【true|false】 //【可选】
      callback: function() {
        initEnv();
      }
    });
    //顶部滚动文字提示
    function textLeft1() {
      var left = parseInt($('.top-tips1 p').css('left'));
      if(left<-$('.top-tips1 p').width()) {
        left="100%";
      }else {
        left -= 1;
      }
      $('.top-tips1 p').css('left',left);
    }
    setInterval(textLeft1,30);
    function textLeft2() {
      var left = parseInt($('.top-tips2 p').css('left'));
      if(left<-$('.top-tips2 p').width()) {
        left="100%";
      }else {
        left -= 1;
      }
      $('.top-tips2 p').css('left',left);
    }
    setInterval(textLeft2,30);
  });
  function echartLoaded(){
    $("#echart-script").addClass("loaded",1);
  }
  function loadEcharts() {
    var script = document.createElement("script");
    script.id = "echart-script";
    script.type = "text/javascript";
    script.src = "/Public/admin/assets/plugins/echart/echarts-all.js";
    document.body.appendChild(script);
    addEvent(script,'load', echartLoaded);
  }
  window.onload = function(){
      loadEcharts();
  }
  </script>
</body>

</html>
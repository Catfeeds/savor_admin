<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
  <form method="post" action="<?php echo ($host_name); ?>/test/ueditior" class="pageForm required-validate" enctype="multipart/form-data" onsubmit="return iframeCallback(this, dialogAjaxDone)">
    <div class="pageFormContent modal-body">
      <div class="tabsContent">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab1" data-toggle="tab"><span>基本信息</span></a></li>
          <li class=""><a href="#tab2" data-toggle="tab"><span>扩展信息</span></a></li>
        </ul>
        <div class="tab-content">
          <div id="tab1" class="tab-pane active fade in">
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                父级分类：
              </label>
              <div class="col-xs-12 col-sm-10">
                <select name="cateid" class="form-control bs-select" title="顶级分类...">
                    <option value="1" data-content='测试分类1' selected>测试分类1</option>
                    <option value="2" data-content='测试分类2'>测试分类2</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                名称：
              </label>
              <div class="col-xs-12 col-sm-10">
                <input name="title" type="text" value="<?php echo ($vinfo["shw_title"]); ?>"  minlength="2" maxlength="30" class="form-control" required/>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                展示图片：
              </label>
              <div class="col-xs-12 col-sm-10">
                <div class="fileinput fileinput-new" data-fileinput>
                  <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                    <a data-target="#modal-file" href="<?php echo ($host_name); ?>/uploadmgr/uploadmgrList?browseFile=true&s_type=image" data-browse-file>
                      <?php if(($vinfo['shw_image'] == 'NULL') OR $vinfo['shw_image'] == ''): ?><img src="/Public/admin/assets/img/noimage.png" border="0" />
                      <?php else: ?>
                        <img src="<?php echo ($vinfo["shw_image"]["full"]); ?>" border="0" /><?php endif; ?>
                    </a>
                  </div>
                  <span class="help-block">请上传512x320像素的jpg格式图片，展示效果最佳，文件大小在300KB内</span>
                  <div>
                    <a class="btn btn-success btn-file" data-target="#modal-file" href="<?php echo ($host_name); ?>/uploadmgr/uploadmgrList?browseFile=true&s_type=image" data-browse-file>
                      选择图片                     
                    </a>
                    <input type="hidden" name="shwimage" value="<?php echo ($vinfo["shw_image"]["full"]); ?>">
                    <a href="javascript:;" class="btn btn-danger" data-remove-file="/Public/admin/assets/img/noimage.png">
                    删除 </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                内容：
              </label>
              <div class="col-xs-12 col-sm-10">
                <script id="editor" type="text/plain" class="ueditor-init" name="content" style="height: 250px; width: 100%"><?php echo (html_entity_decode($vinfo["shw_content"],ENT_COMPAT)); ?></script>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                发布时间：
              </label>
              <div class="col-xs-12 col-sm-10">
                <div class="input-group date form_datetime" data-date="<?php echo ($vinfo["log_time"]); ?>">
                  <input name="logtime" type="text" size="16" class="form-control date" placeholder="开始日期" value="<?php echo ($vinfo["log_time"]); ?>" readonly>
                  <span class="input-group-btn">
                    <button class="btn default date-reset" type="button"><i class="fa fa-times"></i></button>
                    <button class="btn btn-success date-set" type="button"><i class="fa fa-calendar"></i></button>
                  </span>
                </div> 
              </div>
            </div>
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                状态：
              </label>
              <div class="col-xs-12 col-sm-10">
                <input type="hidden" name="status" value="2">
                <input type="checkbox" value="1" class="make-switch status" name="status" data-size="small" data-on-text="启用" data-off-text="禁用" <?php if($vinfo["mgr_status"] != 2): ?>checked<?php endif; ?>>
              </div>
            </div>
          </div>
          <div id="tab2" class="tab-pane fade">
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                测试扩展信息：
              </label>
              <div class="col-xs-12 col-sm-10">
                <input name="extinfo" type="text" value="" class="form-control" />
              </div>
            </div>
            <div class="form-group row">
              <label class="col-xs-12 col-sm-2 control-label">
                description：
              </label>
              <div class="col-xs-12 col-sm-10">
                <textarea name="description" type="textInput" class="form-control"></textarea>
                <span class="tips">注：请描述与该页面相关性高的一段文字，限120字以内。</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-default close-m" type="button">取消</button>
      <button class="btn btn-primary" type="submit">保存</button>
    </div>
    
  </form>
</div>
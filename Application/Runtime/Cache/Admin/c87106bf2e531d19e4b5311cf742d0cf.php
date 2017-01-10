<?php if (!defined('THINK_PATH')) exit();?><!--修改样式2 p元素自适应宽度 start-->
<div class="pageContent">
  <form method="post" action="<?php echo ($host_name); ?>/user/chagePwd" class="pageForm required-validate" onsubmit="return validateCallback(this, dialogAjaxDone)">
    <input type="hidden" name="acttype" value="<?php echo ($acttype); ?>">
    <input type="hidden" name="id" value="<?php echo ($vinfo["id"]); ?>">
    <div class="pageFormContent modal-body">
      <div class="form-group row">
        <label class="col-xs-12 col-sm-2 control-label">
          用户昵称：
        </label>
        <div class="col-xs-12 col-sm-10">
          <input name="remark" type="text" value="<?php echo ($vinfo["remark"]); ?>"  minlength="2" maxlength="10" class="form-control" required  />
        </div>
      </div>
      <div class="form-group row">
        <label class="col-xs-12 col-sm-2 control-label">
          登录名称：
        </label>
        <div class="col-xs-12 col-sm-10">
          <input name="username" type="text" value="<?php echo ($vinfo["username"]); ?>"  minlength="4" maxlength="10" class="form-control" readonly />
        </div>
      </div>
      
      <div class="form-group row">
        <label class="col-xs-12 col-sm-2 control-label">
          当前密码：
        </label>
        <div class="col-xs-12 col-sm-10">
          <input name="curentuserpwd" type="text" value=""  minlength="5" maxlength="20" class="form-control" required  />
        </div>
      </div>
      
      <div class="form-group row">
        <label class="col-xs-12 col-sm-2 control-label">
          新密码：
        </label>
        <div class="col-xs-12 col-sm-10">
          <input name="newuserpwd" type="text" value=""  minlength="5" maxlength="20" class="form-control" required/>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-default close-m" type="button">取消</button>
      <button class="btn btn-primary" type="submit">保存</button>
    </div>
  </form>
</div>